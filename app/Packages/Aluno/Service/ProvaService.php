<?php

namespace App\Packages\Aluno\Service;


use App\Packages\Aluno\Model\Prova;
use App\Packages\Aluno\Model\SnapshotPergunta;
use App\Packages\Aluno\Model\SnapshotResposta;
use App\Packages\Aluno\Repository\AlunoRepository;
use App\Packages\Aluno\Repository\ProvaRepository;
use App\Packages\Aluno\Repository\SnapshotRespostaRepository;
use App\Packages\Prova\Repository\MateriaRepository;
use App\Packages\Prova\Repository\PerguntaRepository;
use App\Packages\Prova\Repository\RespostaRepository;
use App\Packages\Aluno\Repository\SnapshotPerguntaRepository;
use Carbon\Carbon;
use LaravelDoctrine\ORM\Facades\EntityManager;


class ProvaService
{

    const MIN = 2;
    const MAX = 3;

    public function __construct(
        protected AlunoRepository $alunoRepository,
        protected MateriaRepository $materiaRepository,
        protected PerguntaRepository $perguntaRepository,
        protected RespostaRepository $respostaRepository,
        protected ProvaRepository $provaRepository,
        protected SnapshotPerguntaRepository $snapshotPerguntaRepository,
        protected  SnapshotRespostaRepository $snapshotRespostaRepository,

    )
    {
    }

    public function createProva(string $aluno, string $materia): Prova
    {
        $alunoDb = $this->alunoRepository->getNomeAluno($aluno)[0];
        $materiaId = $this->materiaRepository->getIdMateriaByNome($materia);
        $quantidadePergunta = $this->quantidadeAleatoriaPerguntas();
        $perguntasAleatorias = $this->perguntaRepository->getAleatoriasPerguntas($materiaId,$quantidadePergunta);
        $prova = new Prova($alunoDb, $quantidadePergunta, $materia);
        $this->provaRepository->add($prova);

        foreach ($perguntasAleatorias as $pergunta) {
            $snapshotPergunta = new SnapshotPergunta($prova, $pergunta, $quantidadePergunta, 10);
            $this->snapshotPerguntaRepository->add($snapshotPergunta);
            $respostas = $pergunta->getResposta()->toArray();
            foreach ($respostas as $resposta){
                $this->snapshotRespostaRepository->add(
                    new SnapshotResposta(
                        $resposta->getDescricao(),
                        $snapshotPergunta,
                        $resposta->getRespostaCorreta()
                    )
                );
            }
        }
        EntityManager::flush();

        return $prova;
    }

    public function getPerguntasRespostasDb(Prova $prova):array
    {
        $perguntaDb = $this->snapshotPerguntaRepository->getPerguntaSnapshot($prova->getId());
        $perguntasAlternativas = [];
        foreach ($perguntaDb as $pergunta){
            $respostaDb = $this->snapshotRespostaRepository->getAllReapostaSnapshot($pergunta->getId());
            $resposta= array_map(function ($item) {
                $idDescricao = collect();
                $idDescricao ->add([
                    'id'=> $item->getId(),
                    'descricao'=>$item->getDescricao()
                ]);
                return $idDescricao[0];
            }, $respostaDb);
            $perguntasAlternativas[] = [
                'pergunta'=>$pergunta->getPergunta(),
                'alternativas'=>$resposta
            ];
        }
        return $perguntasAlternativas;
    }

    public function quantidadeAleatoriaPerguntas():int
    {
        return rand(self::MIN, self::MAX);
    }

    public function corrigeProva(array $perguntasRespostas, string $idProva)
    {
        $prova = $this->provaRepository->getProva($idProva);
        $perguntas = $prova->getPergunta();
        $valorDaQuestão = $perguntas[0]->getValorQuestao();
        $status = $this->provaRepository->getStatusProva($idProva);
        if(!$status) {
            foreach ($perguntasRespostas as $pergunta) {
                $alternativa = $pergunta['alternativas'][0];
                $idAlternativa = $alternativa['id'];
                $resposta = $this->snapshotRespostaRepository->getRespostaId($idAlternativa);
                $respostaCorreta = $resposta->isRespostaCorreta();

                $this->snapshotRespostaRepository->setRespostaEscolhidaSnapshot($resposta);

                if ($respostaCorreta) {
                    $this->provaRepository->setNotaDb($idProva, $valorDaQuestão);
                }

            }
        }
    }

    public function validaTempo(string $idProva)
    {
        $inicio = $this->provaRepository->getProva($idProva)->getInicioTempo();
        $this->provaRepository->setFinal($idProva, \Carbon\Carbon::now());
        $re = \Carbon\Carbon::now()->diffInHours(Carbon::parse($inicio->format('Y-m-d H:i:s'))) > 1;
        return $re;
    }

    public function retornaProva($id)
    {
        $prova = $this->provaRepository->getProva($id);
        $perguntas = $prova->getPergunta();
        $perguntasCollection = collect();

        foreach ($perguntas as $pergunta){

            $respostasCollection = collect();
            $correta = $this->snapshotRespostaRepository->getRespostaCorreta($pergunta->getId());
            $escolhida = $this->snapshotRespostaRepository->getRespostaEscolhida($pergunta->getId());
            $respostasCollection->add([
                'Resposta Correta'=>$correta->getDescricao(),
                'Resposta Escolhida' => $escolhida->getDescricao()
            ]);

            $perguntasCollection->add([

                'pergunta' => $pergunta->getPergunta(),
                'alternativa' => $respostasCollection[0]
            ]);

        }
            $retornoProva = [
                'Aluno'=> $prova->getAluno()->getNome(),
                'Status'=> $prova->getStatus(),
                'Nota Total' => $prova->getNotaTotal(),
                $perguntasCollection->toArray()
            ];
        return $retornoProva;
    }

}
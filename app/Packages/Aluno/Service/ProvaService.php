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
    const MAX = 5;

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
        $alunoDb = $this->alunoRepository->getNomeAluno($aluno);
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



    public function getProvaDb(Prova $prova):array
    {
        $perguntaDb = $this->snapshotPerguntaRepository->getPerguntaSnapshot($prova->getId());
        $perguntasAlternativas = [];
        foreach ($perguntaDb as $pergunta){
            $respostaDb = $this->snapshotRespostaRepository->getReapostaSnapshot($pergunta->getId());
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
        $perguntaDb = $this->snapshotPerguntaRepository->getPerguntaSnapshot($idProva);
       foreach ($perguntaDb as $pergunta){
       }
    }

    public function validaTempo(string $idProva)
    {
        $r = $this->provaRepository->getProva($idProva)->getInicioTempo();
        $re = \Carbon\Carbon::now()->diffInHours(Carbon::parse($r->format('Y-m-d H:i:s'))) > 1;
        return $re;
    }
}
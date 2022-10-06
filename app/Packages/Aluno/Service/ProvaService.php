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
use LaravelDoctrine\ORM\Facades\EntityManager;


class ProvaService
{

    const MIN = 1;
    const MAX = 4;

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

    public function createProva($aluno, $materia)
    {
        $alunoDb = $this->alunoRepository->getNomeAluno($aluno);
        $materiaId = $this->materiaRepository->getIdMateriaByNome($materia);
        $quantidadePergunta = $this->quantidadeAleatoriaPerguntas();
        $perguntasAleatorias = $this->perguntaRepository->getAleatoriasPerguntas($materiaId,$quantidadePergunta);
        $prova = new Prova($alunoDb, $quantidadePergunta );
        $this->provaRepository->add($prova);

        $this->saveSnapshotProva($perguntasAleatorias, $prova, $quantidadePergunta);
    }

    public function getProvaDb(/*Prova $prova*/ $id)
    {
        $provaDb = $this->provaRepository->getProva(/*$prova->getId()*/$id);
        $perguntaDb = $provaDb->getPergunta()->toArray();
        $perguntasAlternativas = collect();
        foreach ($perguntaDb as $pergunta){
            $respostaDb = $pergunta->getResposta()->map(function ($item) {
                $idDescricao = collect();
                $idDescricao ->add([
                    'id'=> $item->getId(),
                    'descricao'=>$item->getDescricao()
                ]);
                return $idDescricao[0];
            });
            $perguntasAlternativas->add([
                'pergunta'=>$pergunta->getPergunta(),
                'alternativas'=>$respostaDb->toArray()[0]
            ]);
        }
        dd($perguntasAlternativas);
    }

    public function quantidadeAleatoriaPerguntas()
    {
        return rand(self::MIN, self::MAX);
    }

    /**
     * @param mixed $perguntasAleatorias
     * @param Prova $prova
     * @param int $quantidadePergunta
     * @return void
     */
    public function saveSnapshotProva(mixed $perguntasAleatorias, Prova $prova, int $quantidadePergunta): void
    {
        foreach ($perguntasAleatorias as $pergunta) {
            $snapshotPergunta = new SnapshotPergunta($prova, $pergunta, $quantidadePergunta, 10);
            $respostas = $pergunta->getResposta()->toArray();

            $this->snapshotPerguntaRepository->add($snapshotPergunta);
            foreach ($respostas as $resposta)
                $this->snapshotRespostaRepository->add(new SnapshotResposta($resposta->getDescricao(), $snapshotPergunta, $resposta->getRespostaCorreta()));

        }
        EntityManager::flush();
    }
}
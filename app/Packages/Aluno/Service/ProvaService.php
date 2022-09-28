<?php

namespace App\Packages\Aluno\Service;


use App\Packages\Aluno\Repository\AlunoRepository;
use App\Packages\Prova\Repository\MateriaRepository;
use App\Packages\Prova\Repository\PerguntaRepository;
use App\Packages\Prova\Repository\RespostaRepository;

class ProvaService
{

    const MIN = 5;
    const MAX = 11;

    public function __construct(
        protected AlunoRepository $alunoRepository,
        protected MateriaRepository $materiaRepository,
        protected PerguntaRepository $perguntaRepository,
        protected RespostaRepository $respostaRepository
    )
    {
    }

    public function createProva($aluno, $materia):void
    {
        $alunoDb = $this->alunoRepository->getNomeAluno($aluno);
        $materiaId = $this->materiaRepository->getIdMateriaByNome($materia);


    }

    public function quantidadeAleatoriaPerguntas()
    {
        return rand(self::MIN, self::MAX);
    }
}
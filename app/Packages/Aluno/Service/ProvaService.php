<?php

namespace App\Packages\Aluno\Service;


use App\Packages\Aluno\Repository\AlunoRepository;
use App\Packages\Prova\Repository\MateriaRepository;
use App\Packages\Prova\Repository\PerguntaRepository;
use App\Packages\Prova\Repository\RespostaRepository;

class ProvaService
{

    const MIN = 1;
    const MAX = 3;

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
        $quantidadePergunta = $this->quantidadeAleatoriaPerguntas();
        $perguntasAleatorias = $this->perguntaRepository->getAleatoriasPerguntas($materiaId,$quantidadePergunta);
        dd($perguntasAleatorias[0]->getResposta()->toArray());
    }

    public function quantidadeAleatoriaPerguntas()
    {
        return rand(self::MIN, self::MAX);
    }
}
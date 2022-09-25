<?php

namespace App\Http\Controllers;

use App\Packages\Base\HttpStatus;
use App\Packages\Prova\Model\Materia;
use App\Packages\Prova\Model\Pergunta;
use App\Packages\Prova\Repository\MateriaRepository;
use App\Packages\Prova\Repository\PerguntaRepository;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RespostasController
{

    public function __construct(
        protected PerguntaRepository $perguntaRepository,
        protected  MateriaRepository $materiaRepository
    )
    {

    }

    public function store(Request $request)
    {
        $perguntaRequest = $request->get('pergunta');
        $respostas = $request->get('resposta');
        $respostaCorreta = $request->get('respostaCorreta');

        dd($respostas);

        $mat = $this->materiaRepository->findBy(["materia"=>$materiaRequest]);

        $pergunta = new Pergunta($perguntaRequest, $mat[0]);
        $this->perguntaRepository->add($pergunta);

        EntityManager::flush();
        return response(, HttpStatus::CREATED);
    }


}
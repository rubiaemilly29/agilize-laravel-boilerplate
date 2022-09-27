<?php

namespace App\Http\Controllers;

use App\Packages\Base\HttpStatus;
use App\Packages\Prova\Model\Pergunta;
use App\Packages\Prova\Model\Resposta;
use App\Packages\Prova\Repository\PerguntaRepository;
use App\Packages\Prova\Repository\RespostaRepository;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RespostasController
{

    public function __construct(
        protected RespostaRepository $respostaRepository,
        protected PerguntaRepository $perguntaRepository
    )
    {

    }

    public function store(Request $request)
    {
        $perguntaRequest = $request->get('pergunta');
        $respostasRequest = $request->get('respostas');
        $respostaCorreta = $request->get('respostaCorreta');


        $pergunta = $this->perguntaRepository->findBy(['pergunta'=>$perguntaRequest]);

        foreach ($respostasRequest as $chave => $valor){
            $chave == $respostaCorreta ?
                $this->respostaRepository->add(new Resposta($valor, $pergunta[0], true)):
                $this->respostaRepository->add(new Resposta($valor, $pergunta[0]));
        }

        EntityManager::flush();
        return response("response", HttpStatus::CREATED);
    }


}
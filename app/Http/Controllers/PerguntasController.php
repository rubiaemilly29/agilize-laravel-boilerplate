<?php

namespace App\Http\Controllers;

use App\Packages\Base\HttpStatus;
use App\Packages\Prova\Model\Materia;
use App\Packages\Prova\Model\Pergunta;
use App\Packages\Prova\Repository\MateriaRepository;
use App\Packages\Prova\Repository\PerguntaRepository;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class PerguntasController
{

    public function __construct(
        protected PerguntaRepository $perguntaRepository,
        protected  MateriaRepository $materiaRepository
    )
    {

    }

    public function store(Request $request)
    {
        $materiaRequest = $request->get('materia');
        $perguntaRequest = $request->get('pergunta');

        $naoExistePergunta = strlen(trim($perguntaRequest)) < 1;
        $naoExisteMateria = strlen(trim($materiaRequest)) < 1;
        if($naoExisteMateria || $naoExistePergunta) {
            return response('Materia e Pergunta deve existir',HttpStatus::BAD_REQUEST);
        }

        $mat = $this->materiaRepository->getNomeMateria($materiaRequest);

        $pergunta = new Pergunta($perguntaRequest, $mat);
        $this->perguntaRepository->add($pergunta);

        EntityManager::flush();
        return response("A pergunta: '$perguntaRequest' foi cadastrada", HttpStatus::CREATED);
    }


}
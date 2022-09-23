<?php

namespace App\Http\Controllers;

use App\Packages\Aluno\Model\Aluno;
use App\Packages\Base\HttpStatus;
use App\Packages\Prova\Model\Materia;
use App\Packages\Prova\Repository\MateriaRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Illuminate\Http\Request;

class PerguntasController
{

    public function __construct(
        protected PerguntaRepository $materiaRepository
    )
    {

    }

    public function store(Request $request)
    {
        $materia = $request->get('materia');
        if(strlen(trim($materia)) < 1) {
            return response('Materia deve existir',HttpStatus::BAD_REQUEST);
        }
        if($this->materiaRepository->findBy(['materia'=>$materia]))
        {
            return response('Materia ja existe',HttpStatus::BAD_REQUEST);
        }
        $this->materiaRepository->add(new Materia($materia));
        EntityManager::flush();
        return response("$materia cadastrado", HttpStatus::CREATED);
    }


}
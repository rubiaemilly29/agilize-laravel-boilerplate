<?php

namespace App\Http\Controllers;

use App\Packages\Aluno\Model\Aluno;
use App\Packages\Base\HttpStatus;
use App\Packages\Prova\Repository\MateriaRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Illuminate\Http\Request;

class MateriaController
{

    public function __construct(
        protected MateriaRepository $materiaRepository
    )
    {

    }

    public function store(Request $request)
    {
        $materia = $request->get('materia');
        if(strlen(trim($materia)) < 1) {
            return response('Materia deve existir',HttpStatus::BAD_REQUEST);
        }
        if($this->materiaRepository->findBy([''=>$aluno]))
        {
            return response('Materia ja existe',HttpStatus::BAD_REQUEST);
        }
        $this->materiaRepository->add(new Aluno($materia));
        EntityManager::flush();
        return response("$aluno cadastrado", HttpStatus::CREATED);
    }


}
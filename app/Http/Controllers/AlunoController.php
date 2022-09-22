<?php

namespace App\Http\Controllers;



use App\Packages\Aluno\Model\Aluno;
use App\Packages\Aluno\Repository\AlunoRepository;
use App\Packages\Base\HttpStatus;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Illuminate\Http\Request;

class AlunoController
{

    public function __construct(
        protected AlunoRepository $alunoRepository
    )
    {

    }

    public function store(Request $request)
    {
        $aluno = $request->get('aluno');
        if(strlen(trim($aluno)) < 3) {
            return response('O aluno deve ter mais que 3 letras',HttpStatus::BAD_REQUEST);
        }
        if($this->alunoRepository->findBy(['nome'=>$aluno]))
        {
            return response('O aluno ja existe',HttpStatus::BAD_REQUEST);
        }
        $this->alunoRepository->add(new Aluno($aluno));
        EntityManager::flush();
        return response("$aluno cadastrado", HttpStatus::CREATED);
    }


}
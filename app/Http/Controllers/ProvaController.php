<?php

namespace App\Http\Controllers;


use App\Packages\Aluno\Service\ProvaService;
use App\Packages\Base\HttpStatus;
use Illuminate\Http\Request;

class ProvaController extends Controller
{
    public function __construct(
        protected ProvaService $provaService,
    )
    {

    }

    public function store(Request $request)
    {
       $req = !$request->get('aluno')  || !$request->get('materia') ? response('Deve existir um Aluno e uma Materia',HttpStatus::BAD_REQUEST) :$request;
        $provaServiceCreate = $this->provaService->createProva($req->get('aluno'), $req->get('materia'));
//       return $provaServiceCreate
    }
}
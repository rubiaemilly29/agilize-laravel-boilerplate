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
            $provaServiceCreate =$this->provaService->getProvaDb('638b3958-ac14-4c4b-911e-a8f7b6b69663');
//        $provaServiceCreate = $this->provaService->createProva($req->get('aluno'), $req->get('materia'));
        dd($provaServiceCreate);
        response()->json($provaServiceCreate->toArray())->status(201);
    }
}
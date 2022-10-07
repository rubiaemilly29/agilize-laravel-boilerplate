<?php

namespace App\Http\Controllers;


use App\Packages\Aluno\Service\ProvaService;
use App\Packages\Base\HttpStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProvaController extends Controller
{
    public function __construct(
        protected ProvaService $provaService,
    )
    {

    }

    public function index(Request $request)
    {
       $req = !$request->get('aluno')  || !$request->get('materia') ? response('Deve existir um Aluno e uma Materia',HttpStatus::BAD_REQUEST) :$request;
        $provaServiceCreateAndReturnId = $this->provaService->createProva($req->get('aluno'), $req->get('materia'));
        $getProvaDb =$this->provaService->getProvaDb($provaServiceCreateAndReturnId);

        $response = [
            'Aluno'=>$request->get('aluno'),
            'Materia'=> $request->get('materia'),
            'id'=> $provaServiceCreateAndReturnId->getId(),
            'inicio da prova' => $provaServiceCreateAndReturnId->getInicioTempo(),
            'perguntas'=>$getProvaDb
        ];
       return response()->json([$response]);
    }

    public function store(Request $request)
    {
        $req = !$request->get('prova') ? response('Deve existir uma prova',HttpStatus::BAD_REQUEST) :$request->get('prova')[0];
        $perguntasRespostas = $req['perguntas'];
        $idProva = $req['id'];
        if ($this->provaService->validaTempo($idProva)){
            return response('Tempo da prova expirado',HttpStatus::BAD_REQUEST);
        }
        $this->provaService->corrigeProva($perguntasRespostas, $idProva);

    }
}
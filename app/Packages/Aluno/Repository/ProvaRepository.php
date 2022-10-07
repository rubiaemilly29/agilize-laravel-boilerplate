<?php

namespace App\Packages\Aluno\Repository;


use App\Packages\Aluno\Model\Prova;
use App\Packages\Base\Repository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaRepository extends Repository
{
    public string $entityName = Prova::class;

    public function getProva($id)
    {
        return $this->findBy(['id'=>$id])[0];
    }

    public function createProva($alunoDb, $quantidadePergunta)
    {
        $prova = new Prova($alunoDb, $quantidadePergunta);
        $this->add($prova);
        return $prova;
    }
}
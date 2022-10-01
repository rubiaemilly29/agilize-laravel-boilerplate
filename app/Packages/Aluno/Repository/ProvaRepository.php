<?php

namespace App\Packages\Aluno\Repository;


use App\Packages\Aluno\Model\Prova;
use App\Packages\Base\Repository;

class ProvaRepository extends Repository
{
    public string $entityName = Prova::class;

    public function getProva($id)
    {
        return $this->findBy(['nome'=>$id])[0];
    }
}
<?php

namespace App\Packages\Aluno\Repository;

use App\Packages\Aluno\Model\Aluno;
use App\Packages\Base\Repository;

class AlunoRepository extends Repository
{
    public string $entityName = Aluno::class;

    public function getNomeAluno($aluno)
    {
       return $this->findBy(['nome'=>$aluno])[0];
    }
}
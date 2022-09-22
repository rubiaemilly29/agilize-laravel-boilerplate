<?php

namespace App\Packages\Aluno\Repository;

use App\Packages\Aluno\Model\Aluno;
use App\Packages\Base\AbstractRepository;

class AlunoRepository extends AbstractRepository
{
    public string $entityName = Aluno::class;

    public function add(object $entity): void
    {
        $this->_em->persist($entity);
    }
}
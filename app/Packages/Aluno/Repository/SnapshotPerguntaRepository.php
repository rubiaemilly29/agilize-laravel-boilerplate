<?php

namespace App\Packages\Aluno\Repository;


use App\Packages\Aluno\Model\SnapshotPergunta as SnapshotPergunta;
use App\Packages\Base\Repository;

class SnapshotPerguntaRepository extends Repository
{
    public string $entityName = SnapshotPergunta::class;

    public function getPerguntaSnapshot($id)
    {
        return $this->findBy(['id'=>$id])[0];
    }
}
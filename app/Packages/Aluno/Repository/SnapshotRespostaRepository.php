<?php

namespace App\Packages\Aluno\Repository;


use App\Packages\Aluno\Model\SnapshotResposta;
use App\Packages\Base\Repository;

class SnapshotRespostaRepository extends Repository
{
    public string $entityName = SnapshotResposta::class;

    public function getReapostaSnapshot($id)
    {
        return $this->findBy(['snapshotPergunta'=>$id]);
    }

    public function createRespostaSnapshot()
    {
        
    }
}
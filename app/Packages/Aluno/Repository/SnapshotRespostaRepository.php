<?php

namespace App\Packages\Aluno\Repository;


use App\Packages\Aluno\Model\SnapshotResposta;
use App\Packages\Base\Repository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class SnapshotRespostaRepository extends Repository
{
    public string $entityName = SnapshotResposta::class;

    public function getAllReapostaSnapshot($id)
    {
        return $this->findBy(['snapshotPergunta'=>$id]);
    }

    public function getRespostaId($id)
    {
        $resposta = $this->findBy(['id'=>$id])[0];
        return $resposta;
    }
    public function setRespostaEscolhidaSnapshot($resposta)
    {
            $resposta->setRespostaEscolhida(true);
            EntityManager::flush();
    }

    public function getRespostaCorreta($id)
    {
       return $respostaCorreta = $this->findBy(['snapshotPergunta'=>$id, 'respostaCorreta'=>true])[0];
    }

    public function getRespostaEscolhida($id)
    {
        return $respostaEscolhida = $this->findBy(['snapshotPergunta'=>$id, 'respostaEscolhida'=>true])[0];

    }
}
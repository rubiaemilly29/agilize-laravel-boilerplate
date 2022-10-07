<?php

namespace App\Packages\Aluno\Repository;


use App\Packages\Aluno\Model\Prova;
use App\Packages\Base\Repository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaRepository extends Repository
{
    const CONCLUIDO = 'concluido';
    public string $entityName = Prova::class;

    public function getProva($id)
    {
        return $this->findBy(['id'=>$id])[0];
    }
    public function setNotaDb($id, $valorDaQuestão)
    {
        $prova = $this->findBy(['id'=>$id])[0];
        $prova->setNotaTotal($valorDaQuestão);
        $prova->setStatus(self::CONCLUIDO);
        EntityManager::flush();
        return $prova->getNotaTotal();
    }

    public function setFinal($id, $now)
    {
        $prova = $this->findBy(['id'=>$id])[0];
        $prova->setFinalTempo($now);
        EntityManager::flush();
    }
    public function getStatusProva($id)
    {
        $status = $this->findBy(['id'=>$id, 'status'=>'concluido']);

         if(!empty($status) && $status[0]->getStatus() == self::CONCLUIDO){
             return true;
         }
    }
}
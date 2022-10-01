<?php

namespace App\Packages\Prova\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Model\Pergunta;

class PerguntaRepository extends Repository
{
    public string $entityName = Pergunta::class;

    public function getAleatoriasPerguntas($materia, $quantidadePergunta)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        return $q
            ->select('pergunta')
            ->from($this->entityName, 'pergunta')
            ->where('pergunta.materia = :materia')
            ->setParameter('materia', $materia)
            ->orderBy('RANDOM()')
            ->setMaxResults($quantidadePergunta)
            ->getQuery()
            ->getResult();
    }
}
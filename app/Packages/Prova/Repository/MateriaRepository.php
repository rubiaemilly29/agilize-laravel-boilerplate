<?php

namespace App\Packages\Prova\Repository;

use App\Packages\Prova\Model\Materia;
use App\Packages\Base\AbstractRepository;

class MateriaRepository extends AbstractRepository
{
    public string $entityName = Materia::class;

    public function add(object $entity): void
    {
        $this->findBy($entity->getMateria);
        $this->_em->persist($entity);
    }
}
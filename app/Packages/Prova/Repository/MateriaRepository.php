<?php

namespace App\Packages\Prova\Repository;

use App\Packages\Base\Repository;
use App\Packages\Prova\Model\Materia;

class MateriaRepository extends Repository
{
    public string $entityName = Materia::class;

    public function getNomeMateria($materia)
    {
        return $this->findBy(['materia'=>$materia])[0];
    }

    public function getIdMateriaByNome($materia)
    {
        return $this->findBy(['materia'=>$materia])[0]->getId();
    }
}
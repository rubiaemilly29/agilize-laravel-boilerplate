<?php

namespace App\Packages\Base;

use App\Packages\Base\AbstractRepository;
use Doctrine\ORM\QueryBuilder;

class Repository extends AbstractRepository
{
    protected array $defaultOrderings = [];

    public function add(object $entity): void
    {
        $this->_em->persist($entity);
    }

    public function update(object $entity): object
    {
        return $this->_em->merge($entity);
    }

    public function remove(object $entity): void
    {
        $this->_em->remove($entity);
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->_em->createQueryBuilder();
    }

}
<?php

namespace App\Packages\Aluno\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */
class Aluno
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid", unique=true)
     * @ORM\GeneratedValue(strategy="UUID")
     *
     */
    protected string $id;


    /** @ORM\Column(type="string") */
    protected string $nome;

    /** @ORM\OneToMany(targetEntity="\App\Packages\Aluno\Model\Prova", mappedBy="Aluno") */

    protected ?Collection $prova;

    public function __construct(string $nome)
    {
        $this->id = Str::uuid()->toString();
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

}
<?php

namespace App\Packages\Prova\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */

class Materia
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected string $id;


    /** @ORM\Column(type="string") */
    protected string $materia;

    /** @ORM\OneToMany(targetEntity="\App\Packages\Prova\Model\Pergunta", mappedBy="materia") */

    protected Collection $pergunta;


    public function __construct(string $materia)
    {
        $this->id = Str::uuid()->toString();
        $this->materia = $materia;
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
    public function getMateria(): string
    {
        return $this->materia;
    }

    /**
     * @param string $materia
     */
    public function setMateria(string $materia): void
    {
        $this->materia = $materia;
    }

    /**
     * @return Collection
     */
    public function getPergunta(): Collection
    {
        return $this->pergunta;
    }

    /**
     * @param Pergunta $pergunta
     */
    public function setPergunta(Pergunta $pergunta): void
    {
        $this->pergunta->add($pergunta);
        $pergunta->setMateria($this);
    }


}
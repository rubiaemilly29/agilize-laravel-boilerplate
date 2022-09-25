<?php

namespace App\Packages\Prova\Model;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */
class Pergunta
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected string $id;


    /** @ORM\Column(type="string") */
    protected string $pergunta;

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Prova\Model\Materia",  cascade={"persist", "remove"}, inversedBy="pergunta")
     *
     *  @ORM\JoinColumn(name="materia_id", referencedColumnName="id")
     */
    protected Materia $materia;

    /** @ORM\OneToMany(targetEntity="Resposta", mappedBy="pergunta") */
    protected Collection $resposta;

    public function __construct(string $pergunta, Materia $materia)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta;
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
    public function getPergunta(): string
    {
        return $this->pergunta;
    }

    /**
     * @return string
     */
    public function getMateria(): string
    {
        return $this->materia;
    }

    /**
     * @return Collection
     */
    public function getResposta(): Collection
    {
        return $this->resposta;
    }

}
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

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Prova\Model\Materia", inversedBy="pergunta") */
    protected string $materia;

    /** @ORM\OneToMany(targetEntity="Resposta", mappedBy="pergunta") */
    protected Collection $resposta;

    public function __construct(string $pergunta)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta;
    }
}
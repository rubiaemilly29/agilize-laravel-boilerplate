<?php

namespace App\Packages\Prova\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */
class Resposta
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected string $id;


    /** @ORM\Column(type="boolean") */
    protected bool $respostaCorreta;

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Prova\Model\Pergunta", inversedBy="resposta") */

    protected string $pergunta;

    protected string $descricao;

    public function __construct(string $descricao, $respostaCorreta = false)
    {
        $this->id = Str::uuid()->toString();
        $this->descricao = $descricao;
        $this->respostaCorreta = $respostaCorreta;
    }
}
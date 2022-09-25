<?php

namespace App\Packages\Aluno\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */
class SnapshotResposta
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

    /** @ORM\OneToMany(targetEntity="\App\Packages\Aluno\Model\SnapshotPergunta", cascade={"persist", "remove"}, inversedBy="snapshotResposta") */
    protected SnapshotPergunta $snapshotPergunta;

    protected string $descricao;

    /** @ORM\Column(type="boolean") */
    protected  string $respostaEscolhida;

    public function __construct(string $descricao, SnapshotPergunta $snapshotPergunta,  bool $respostaEscolhida = false, bool $respostaCorreta = false)
    {
        $this->id = Str::uuid()->toString();
        $this->descricao = $descricao;
        $this->respostaEscolhida = $respostaEscolhida;
        $this->respostaCorreta = $respostaCorreta;
        $this->snapshotPergunta = $snapshotPergunta;
    }
}
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

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Aluno\Model\SnapshotPergunta", cascade={"persist", "remove"}, inversedBy="snapshotResposta") */
    protected SnapshotPergunta $snapshotPergunta;

    /** @ORM\Column(type="string") */
    protected string $descricao;

    /** @ORM\Column(type="boolean") */
    protected  bool $respostaEscolhida;

    public function __construct(string $descricao, SnapshotPergunta $snapshotPergunta, bool $respostaCorreta = false, bool $respostaEscolhida = false)
    {
        $this->id = Str::uuid()->toString();
        $this->descricao = $descricao;
        $this->respostaCorreta = $respostaCorreta;
        $this->snapshotPergunta = $snapshotPergunta;
        $this->respostaEscolhida= $respostaEscolhida;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isRespostaCorreta(): bool
    {
        return $this->respostaCorreta;
    }


    /**
     * @return SnapshotPergunta
     */
    public function getSnapshotPergunta(): SnapshotPergunta
    {
        return $this->snapshotPergunta;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @return string
     */
    public function getRespostaEscolhida(): bool
    {
        return $this->respostaEscolhida;
    }

    /**
     * @param string $respostaEscolhida
     */
    public function setRespostaEscolhida(bool $respostaEscolhida): void
    {
        $this->respostaEscolhida = $respostaEscolhida;
    }

}
<?php

namespace App\Packages\Aluno\Model;


use App\Packages\Prova\Model\Pergunta;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */
class SnapshotPergunta
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

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Aluno\Model\Prova", cascade={"persist", "remove"}, inversedBy="snapshotPergunta") */
    protected Prova $prova;

    /** @ORM\OneToMany(targetEntity="\App\Packages\Aluno\Model\SnapshotResposta", mappedBy="snapshotPergunta") */
    protected Collection $resposta;

    /** @ORM\Column(type="float") */

    protected  float $valorQuestao;

    public function __construct(Prova $prova, Pergunta $pergunta, int $numeroQuestao, $valorProva)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta->getPergunta();
        $this->valorQuestao = round($valorProva / $numeroQuestao, 1);
        $this->prova = $prova;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Prova
     */
    public function getProva(): Prova
    {
        return $this->prova;
    }

    /**
     * @return string
     */
    public function getPergunta(): string
    {
        return $this->pergunta;
    }

    /**
     * @return Collection
     */
    public function getResposta(): Collection
    {
        return $this->resposta;
    }
    /**
     * @return float|int
     */
    public function getValorQuestao(): float|int
    {
        return $this->valorQuestao;
    }
}
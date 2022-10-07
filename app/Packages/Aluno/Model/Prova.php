<?php

namespace App\Packages\Aluno\Model;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 */
class Prova
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected string $id;

    /** @ORM\Column(type="string") */
    protected string $status;

    /** @ORM\OneToMany(targetEntity="\App\Packages\Aluno\Model\SnapshotPergunta", mappedBy="prova") */
    protected Collection $pergunta;

    /** @var \DateTime @ORM\Column(nullable = true) */
    protected \DateTime $inicioTempo;

    /** @var \DateTime @ORM\Column(nullable = true) */
    protected \DateTime $finalTempo;

    /** @ORM\Column(type="integer") */
    protected int $quantidadeQuestao;

    /** @ORM\Column(type="float", nullable = true) */
    protected float $notaTotal;

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Aluno\Model\Aluno", cascade={"persist", "remove"}, inversedBy="Prova") */
    protected Aluno $aluno;

    /**@ORM\Column(type="string")**/
    protected string $materia;


    public function __construct(Aluno $aluno, int $quantidadeQuestao, string $materia, string $status= 'iniciado')
    {
        $this->id = Str::uuid()->toString();
        $this->status = $status;
        $this->quantidadeQuestao = $quantidadeQuestao;
        $this->inicioTempo = Carbon::createFromFormat('Y-m-d H:i:s', now());
        $this->aluno = $aluno;
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
     * @return bool|string
     */
    public function getStatus(): bool|string
    {
        return $this->status;
    }

    /**
     * @return Collection
     */
    public function getPergunta(): Collection
    {
        return $this->pergunta;
    }

    /**
     * @return \DateTime
     */
    public function getInicioTempo(): \DateTime|Carbon
    {
        return $this->inicioTempo;
    }

    /**
     * @return \DateTime
     */
    public function getFinalTempo(): \DateTime
    {
        return $this->finalTempo;
    }

    /**
     * @return int
     */
    public function getQuantidadeQuestao(): int
    {
        return $this->quantidadeQuestao;
    }

    /**
     * @return float
     */
    public function getNotaTotal(): float
    {
        return $this->notaTotal;
    }

    /**
     * @return Aluno
     */
    public function getAluno(): Aluno
    {
        return $this->aluno;
    }

    /**
     * @param \DateTime $finalTempo
     */
    public function setFinalTempo(\DateTime $finalTempo): void
    {
        $this->finalTempo = $finalTempo;
    }

    /**
     * @param float $notaTotal
     */
    public function setNotaTotal(float $notaTotal): void
    {
        $this->notaTotal = $notaTotal;
    }
}
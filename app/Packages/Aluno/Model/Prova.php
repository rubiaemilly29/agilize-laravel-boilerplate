<?php

namespace App\Packages\Aluno\Model;

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


    protected string $materia;

    /** @ORM\OneToMany(targetEntity="\App\Packages\Aluno\Model\SnapshotPergunta", mappedBy="prova") */
    protected Collection $pergunta;

    /** @var \DateTime @ORM\Column(nullable = true) */
    protected \DateTime $inicioTempo;

    /** @var \DateTime @ORM\Column(nullable = true) */
    protected \DateTime $finalTempo;

    protected int $quantidadeQuestao;

    protected float $notaTotal;

    public function __construct(string $status, int $quantidadeQuestao, float $notaTotal, ?\DateTime $inicioTempo, ?\DateTime $finalTempo)
    {
        $this->id = Str::uuid()->toString();
        $this->status = $status;
        $this->quantidadeQuestao = $quantidadeQuestao;
        $this->notaTotal = $notaTotal;
        $this->inicioTempo = $inicioTempo;
        $this->finalTempo = $finalTempo;
    }

}
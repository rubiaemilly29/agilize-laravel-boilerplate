<?php

namespace App\Packages\Aluno\Model;


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

    /** @ORM\ManyToOne(targetEntity="\App\Packages\Aluno\Model\Prova", inversedBy="snapshotPergunta") */
    protected string $prova;

    /** @ORM\OneToMany(targetEntity="\App\Packages\Aluno\Model\SnapshotResposta", mappedBy="snapshotPergunta") */
    protected Collection $resposta;

    protected  float $valorQuestao;

    public function __construct(string $pergunta, int $valorQuestao)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta;
        $this->valorQuestao = $valorQuestao;
    }
}
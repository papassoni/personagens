<?php

namespace App\Entity;

use App\Repository\PersonagensRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonagensRepository::class)
 */
class Personagens
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nome;

    /**
     * @ORM\Column(type="text")
     */
    private $detalhes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDetalhes(): ?string
    {
        return $this->detalhes;
    }

    public function setDetalhes(string $detalhes): self
    {
        $this->detalhes = $detalhes;

        return $this;
    }
}

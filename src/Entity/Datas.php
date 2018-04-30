<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DatasRepository")
 */
class Datas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $symbol;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $rand_key;

    public function getId()
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getRandKey(): ?int
    {
        return $this->rand_key;
    }

    public function setRandKey(int $rand_key): self
    {
        $this->rand_key = $rand_key;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntryRepository::class)
 */
class Entry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="float")
     */
    private $D1;

    /**
     * @ORM\Column(type="float")
     */
    private $D2;

    /**
     * @ORM\Column(type="float")
     */
    private $D3;

    /**
     * @ORM\Column(type="float")
     */
    private $D4;

    /**
     * @ORM\Column(type="float")
     */
    private $D5;

    /**
     * @ORM\Column(type="float")
     */
    private $D6;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     */
    private $acquieredDomains = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAlternant = false;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getD1(): ?float
    {
        return $this->D1;
    }

    public function setD1(float $D1): self
    {
        $this->D1 = $D1;
        if($D1 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD2(): ?float
    {
        return $this->D2;
    }

    public function setD2(float $D2): self
    {
        $this->D2 = $D2;
        if($D2 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD3(): ?float
    {
        return $this->D3;
    }

    public function setD3(float $D3): self
    {
        $this->D3 = $D3;
        if($D3 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD4(): ?float
    {
        return $this->D4;
    }

    public function setD4(float $D4): self
    {
        $this->D4 = $D4;
        if($D4 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD5(): ?float
    {
        return $this->D5;
    }

    public function setD5(float $D5): self
    {
        $this->D5 = $D5;
        if($D5 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD6(): ?float
    {
        return $this->D6;
    }

    public function setD6(float $D6): self
    {
        $this->D6 = $D6;
        if($D6 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getAcquieredDomains(): ?int
    {
        return $this->acquieredDomains;
    }

    public function setAcquieredDomains(int $acquieredDomains): self
    {
        $this->acquieredDomains = $acquieredDomains;

        return $this;
    }

    public function getIsAlternant(): ?bool
    {
        return $this->isAlternant;
    }

    public function setIsAlternant(bool $isAlternant): self
    {
        $this->isAlternant = $isAlternant;

        return $this;
    }
}

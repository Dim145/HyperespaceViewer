<?php

namespace App\Entity;

class Student
{
    private ?int $id;

    private ?string $number;

    private ?string $fullName;

    private ?string $fileName;

    private ?float $d1;

    private ?float $d2;

    private ?float $d3;

    private ?float $d4;

    private ?float $d5;

    private ?float $d6;

    private ?float $total;

    private int $acquieredDomains = 0;

    private bool $isAlternant = false;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

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
        return $this->d1;
    }

    public function setD1(float $d1): self
    {
        $this->d1 = $d1;
        if ($d1 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD2(): ?float
    {
        return $this->d2;
    }

    public function setD2(float $d2): self
    {
        $this->d2 = $d2;
        if ($d2 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD3(): ?float
    {
        return $this->d3;
    }

    public function setD3(float $d3): self
    {
        $this->d3 = $d3;
        if ($d3 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD4(): ?float
    {
        return $this->d4;
    }

    public function setD4(float $d4): self
    {
        $this->d4 = $d4;
        if ($d4 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD5(): ?float
    {
        return $this->d5;
    }

    public function setD5(float $d5): self
    {
        $this->d5 = $d5;
        if ($d5 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

        return $this;
    }

    public function getD6(): ?float
    {
        return $this->d6;
    }

    public function setD6(float $d6): self
    {
        $this->d6 = $d6;
        if ($d6 >= 66.66) $this->setAcquieredDomains($this->acquieredDomains + 1);

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

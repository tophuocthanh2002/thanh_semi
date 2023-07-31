<?php

namespace App\Entity;

use App\Repository\ChuongRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChuongRepository::class)]
class Chuong
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tenchuong = null;

    #[ORM\Column(length: 255)]
    private ?string $noidung = null;

    #[ORM\ManyToOne(inversedBy: 'chuongs')]
    private ?Truyen $truyen = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenchuong(): ?string
    {
        return $this->tenchuong;
    }

    public function setTenchuong(string $tenchuong): static
    {
        $this->tenchuong = $tenchuong;

        return $this;
    }

    public function getNoidung(): ?string
    {
        return $this->noidung;
    }

    public function setNoidung(string $noidung): static
    {
        $this->noidung = $noidung;

        return $this;
    }

    public function getTruyen(): ?Truyen
    {
        return $this->truyen;
    }

    public function setTruyen(?Truyen $truyen): static
    {
        $this->truyen = $truyen;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\LichsuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LichsuRepository::class)]

class Lichsu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ngaydoc = null;

    #[ORM\Column(length: 255)]
    private ?string $luotxem = null;

    #[ORM\ManyToOne(targetEntity: Nguoidung::class, inversedBy: 'lichsus')]
    private ?Nguoidung $nguoidung = null;

    #[ORM\ManyToOne(targetEntity: Truyen::class, inversedBy: 'lichsus')]
    private ?Truyen $truyen = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNgaydoc(): ?string
    {
        return $this->ngaydoc;
    }

    public function setNgaydoc(string $ngaydoc): self
    {
        $this->ngaydoc = $ngaydoc;

        return $this;
    }

    public function getLuotxem(): ?string
    {
        return $this->luotxem;
    }

    public function setLuotxem(string $luotxem): self
    {
        $this->luotxem = $luotxem;

        return $this;
    }

    public function getNguoidung(): ?Nguoidung
    {
        return $this->nguoidung;
    }

    public function setNguoidung(?Nguoidung $nguoidung): self
    {
        $this->nguoidung = $nguoidung;

        return $this;
    }

    public function getTruyen(): ?Truyen
    {
        return $this->truyen;
    }

    public function setTruyen(?Truyen $truyen): self
    {
        $this->truyen = $truyen;

        return $this;
    }

}

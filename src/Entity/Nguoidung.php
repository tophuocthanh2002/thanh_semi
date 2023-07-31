<?php

namespace App\Entity;

use App\Repository\NguoidungRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NguoidungRepository::class)]
class Nguoidung
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tendangnhap = null;

    #[ORM\Column(length: 255)]
    private ?string $matkhau = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'nguoidung', targetEntity: Lichsu::class)]
    private Collection $lichsus;

    public function __construct()
    {
        $this->lichsus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTendangnhap(): ?string
    {
        return $this->tendangnhap;
    }

    public function setTendangnhap(string $tendangnhap): static
    {
        $this->tendangnhap = $tendangnhap;

        return $this;
    }

    public function getMatkhau(): ?string
    {
        return $this->matkhau;
    }

    public function setMatkhau(string $matkhau): static
    {
        $this->matkhau = $matkhau;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Lichsu>
     */
    public function getLichsus(): Collection
    {
        return $this->lichsus;
    }

    public function addLichsu(Lichsu $lichsu): static
    {
        if (!$this->lichsus->contains($lichsu)) {
            $this->lichsus->add($lichsu);
            $lichsu->setNguoidung($this);
        }

        return $this;
    }

    public function removeLichsu(Lichsu $lichsu): static
    {
        if ($this->lichsus->removeElement($lichsu)) {
            // set the owning side to null (unless already changed)
            if ($lichsu->getNguoidung() === $this) {
                $lichsu->setNguoidung(null);
            }
        }

        return $this;
    }
}

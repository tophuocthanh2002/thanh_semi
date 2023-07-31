<?php

namespace App\Entity;

use App\Repository\TheloaiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TheloaiRepository::class)]
class Theloai
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ten_the_loai = null;

    #[ORM\OneToMany(mappedBy: 'theloai', targetEntity: Truyen::class)]
    private Collection $truyens;

    public function __construct()
    {
        $this->truyens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenTheLoai(): ?string
    {
        return $this->ten_the_loai;
    }

    public function setTenTheLoai(string $ten_the_loai): static
    {
        $this->ten_the_loai = $ten_the_loai;

        return $this;
    }

    /**
     * @return Collection<int, Truyen>
     */
    public function getTruyens(): Collection
    {
        return $this->truyens;
    }

    public function addTruyen(Truyen $truyen): static
    {
        if (!$this->truyens->contains($truyen)) {
            $this->truyens->add($truyen);
            $truyen->setTheloai($this);
        }

        return $this;
    }

    public function removeTruyen(Truyen $truyen): static
    {
        if ($this->truyens->removeElement($truyen)) {
            // set the owning side to null (unless already changed)
            if ($truyen->getTheloai() === $this) {
                $truyen->setTheloai(null);
            }
        }

        return $this;
    }
}

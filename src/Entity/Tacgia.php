<?php

namespace App\Entity;

use App\Repository\TacgiaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TacgiaRepository::class)]
class Tacgia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tentacgia = null;

    #[ORM\OneToMany(mappedBy: 'tacgia', targetEntity: Truyen::class)]
    private Collection $truyens;

    public function __construct()
    {
        $this->truyens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTentacgia(): ?string
    {
        return $this->tentacgia;
    }

    public function setTentacgia(string $tentacgia): static
    {
        $this->tentacgia = $tentacgia;

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
            $truyen->setTacgia($this);
        }

        return $this;
    }

    public function removeTruyen(Truyen $truyen): static
    {
        if ($this->truyens->removeElement($truyen)) {
            // set the owning side to null (unless already changed)
            if ($truyen->getTacgia() === $this) {
                $truyen->setTacgia(null);
            }
        }
        return $this;
    }
}

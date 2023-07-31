<?php

namespace App\Entity;

use App\Repository\TruyenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TruyenRepository::class)]
class Truyen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tentruyen = null;

    #[ORM\Column(length: 255)]
    private ?string $hinhanh = null;

    #[ORM\Column(length: 255)]
    private ?string $mota = null;

    #[ORM\Column(length: 255)]
    private ?string $ngaydang = null;

    #[ORM\ManyToOne(inversedBy: 'truyens')]
    private ?Theloai $theloai = null;

    #[ORM\ManyToOne(inversedBy: 'truyens')]
    private ?Tacgia $tacgia = null;

    #[ORM\OneToMany(mappedBy: 'truyen', targetEntity: Chuong::class)]
    private Collection $chuongs;

    #[ORM\OneToMany(mappedBy: 'truyen', targetEntity: Lichsu::class)]
    private Collection $lichsus;

    public function __construct()
    {
        $this->chuongs = new ArrayCollection();
        $this->lichsus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTentruyen(): ?string
    {
        return $this->tentruyen;
    }

    public function setTentruyen(string $tentruyen): static
    {
        $this->tentruyen = $tentruyen;

        return $this;
    }

    public function getHinhanh(): ?string
    {
        return $this->hinhanh;
    }

    public function setHinhanh(string $hinhanh): static
    {
        $this->hinhanh = $hinhanh;

        return $this;
    }

    public function getMota(): ?string
    {
        return $this->mota;
    }

    public function setMota(string $mota): static
    {
        $this->mota = $mota;

        return $this;
    }

    public function getNgaydang(): ?string
    {
        return $this->ngaydang;
    }

    public function setNgaydang(string $ngaydang): static
    {
        $this->ngaydang = $ngaydang;

        return $this;
    }


    public function getTheloai(): ?Theloai
    {
        return $this->theloai;
    }

    public function setTheloai(?Theloai $theloai): static
    {
        $this->theloai = $theloai;

        return $this;
    }

    public function getTacgia(): ?Tacgia
    {
        return $this->tacgia;
    }

    public function setTacgia(?Tacgia $tacgia): static
    {
        $this->tacgia = $tacgia;

        return $this;
    }
    public function getNoidung(): ?string
    {
        return $this->noidung;
    }

    public function setNoidung(string $noidung): self
    {
        $this->noidung = $noidung;

        return $this;
    }

    /**
     * @return Collection<int, Chuong>
     */
    public function getChuongs(): Collection
    {
        return $this->chuongs;
    }

    public function addChuong(Chuong $chuong): static
    {
        if (!$this->chuongs->contains($chuong)) {
            $this->chuongs->add($chuong);
            $chuong->setTruyen($this);
        }

        return $this;
    }

    public function removeChuong(Chuong $chuong): static
    {
        if ($this->chuongs->removeElement($chuong)) {
            // set the owning side to null (unless already changed)
            if ($chuong->getTruyen() === $this) {
                $chuong->setTruyen(null);
            }
        }

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
            $lichsu->setTruyen($this);
        }

        return $this;
    }

    public function removeLichsu(Lichsu $lichsu): static
    {
        if ($this->lichsus->removeElement($lichsu)) {
            // set the owning side to null (unless already changed)
            if ($lichsu->getTruyen() === $this) {
                $lichsu->setTruyen(null);
            }
        }

        return $this;
    }


}

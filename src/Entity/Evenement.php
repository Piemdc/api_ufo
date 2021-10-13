<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator_id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $icone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Besoin::class, mappedBy="evenement_id")
     */
    private $besoins;

    /**
     * @ORM\OneToMany(targetEntity=Dispo::class, mappedBy="evenement_id")
     */
    private $dispos;

    public function __construct()
    {
        $this->besoins = new ArrayCollection();
        $this->dispos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatorId(): ?User
    {
        return $this->creator_id;
    }

    public function setCreatorId(?User $creator_id): self
    {
        $this->creator_id = $creator_id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIcone(): ?int
    {
        return $this->icone;
    }

    public function setIcone(int $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Besoin[]
     */
    public function getBesoins(): Collection
    {
        return $this->besoins;
    }

    public function addBesoin(Besoin $besoin): self
    {
        if (!$this->besoins->contains($besoin)) {
            $this->besoins[] = $besoin;
            $besoin->setEvenementId($this);
        }

        return $this;
    }

    public function removeBesoin(Besoin $besoin): self
    {
        if ($this->besoins->removeElement($besoin)) {
            // set the owning side to null (unless already changed)
            if ($besoin->getEvenementId() === $this) {
                $besoin->setEvenementId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dispo[]
     */
    public function getDispos(): Collection
    {
        return $this->dispos;
    }

    public function addDispo(Dispo $dispo): self
    {
        if (!$this->dispos->contains($dispo)) {
            $this->dispos[] = $dispo;
            $dispo->setEvenementId($this);
        }

        return $this;
    }

    public function removeDispo(Dispo $dispo): self
    {
        if ($this->dispos->removeElement($dispo)) {
            // set the owning side to null (unless already changed)
            if ($dispo->getEvenementId() === $this) {
                $dispo->setEvenementId(null);
            }
        }

        return $this;
    }
}

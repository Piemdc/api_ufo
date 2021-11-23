<?php

namespace App\Entity;

use App\Repository\BesoinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=BesoinRepository::class)
 */
class Besoin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"need:read","need:wright"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="besoins")
     * @Groups({"need:read","need:wright"})
     */
    private $evenement_id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"need:read","need:wright"})
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"need:read","need:wright"})
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"need:read","need:wright"})
     */
    private $reste;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $icone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvenementId(): ?Evenement
    {
        return $this->evenement_id;
    }

    public function setEvenementId(?Evenement $evenement_id): self
    {
        $this->evenement_id = $evenement_id;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getReste(): ?int
    {
        return $this->reste;
    }

    public function setReste(int $reste): self
    {
        $this->reste = $reste;

        return $this;
    }

    public function getIcone(): ?int
    {
        return $this->icone;
    }

    public function setIcone(?int $icone): self
    {
        $this->icone = $icone;

        return $this;
    }
}

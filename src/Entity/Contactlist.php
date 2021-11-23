<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRepository")
 */
class Contactlist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"contact:read","contact:wright"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_one_id", referencedColumnName="id")
     * })
     * @Groups({"contact:read","contact:wright"})
     */
    private $userOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_two_id", referencedColumnName="id")
     * })
     * @Groups({"contact:read","contact:wright"})
     */
    private $userTwo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"contact:read","contact:wright"})
     */
    private $since;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"contact:read","contact:wright"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"contact:read","contact:wright"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->status = 0;
        $this->createdAt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserOne(): ?User
    {
        return $this->userOne;
    }

    public function setUserOne(?User $userOne): self
    {
        $this->userOne = $userOne;

        return $this;
    }

    public function getUserTwo(): ?User
    {
        return $this->userTwo;
    }

    public function setUserTwo(?User $userTwo): self
    {
        $this->userTwo = $userTwo;

        return $this;
    }

    public function getSince(): ?\DateTimeInterface
    {
        return $this->since;
    }

    public function setSince(\DateTimeInterface $since): self
    {
        $this->since = $since;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

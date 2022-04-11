<?php

namespace App\Entity;

use App\Repository\MessagechatRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: MessagechatRepository::class)]
#[ApiResource()]
class Messagechat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\Column(type: 'datetime')]
    private $dateenvoi;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'messagerecu')]
    #[ORM\JoinColumn(nullable: false)]
    private $userrecoi;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'messageenvoi')]
    #[ORM\JoinColumn(nullable: false)]
    private $userenvoi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateenvoi(): ?\DateTimeInterface
    {
        return $this->dateenvoi;
    }

    public function setDateenvoi(\DateTimeInterface $dateenvoi): self
    {
        $this->dateenvoi = $dateenvoi;

        return $this;
    }

    public function getUserrecoi(): ?Utilisateur
    {
        return $this->userrecoi;
    }

    public function setUserrecoi(?Utilisateur $userrecoi): self
    {
        $this->userrecoi = $userrecoi;

        return $this;
    }

    public function getUserenvoi(): ?Utilisateur
    {
        return $this->userenvoi;
    }

    public function setUserenvoi(?Utilisateur $userenvoi): self
    {
        $this->userenvoi = $userenvoi;

        return $this;
    }
}

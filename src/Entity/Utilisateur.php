<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource()]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'datetime')]
    private $dateinscription;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomEquipage;

    #[ORM\OneToMany(mappedBy: 'userrecoi', targetEntity: Messagechat::class, orphanRemoval: true)]
    private $messagerecu;

    #[ORM\OneToMany(mappedBy: 'userenvoi', targetEntity: Messagechat::class, orphanRemoval: true)]
    private $messageenvoi;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Annonce::class, orphanRemoval: true)]
    private $annonces;

    #[ORM\OneToOne(mappedBy: 'utilisateur', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;


    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->messagerecu = new ArrayCollection();
        $this->messageenvoi = new ArrayCollection();
    }

    public function __toString(){
        return $this->getMessagerecu;
        return $this->getMessageenvoi;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateinscription(): ?\DateTimeInterface
    {
        return $this->dateinscription;
    }

    public function setDateinscription(\DateTimeInterface $dateinscription): self
    {
        $this->dateinscription = $dateinscription;

        return $this;
    }

    public function getNomEquipage(): ?string
    {
        return $this->nomEquipage;
    }

    public function setNomEquipage(?string $nomEquipage): self
    {
        $this->nomEquipage = $nomEquipage;

        return $this;
    }

    /**
     * @return Collection<int, Messagechat>
     */
    public function getMessagerecu(): Collection
    {
        return $this->messagerecu;
    }

    public function addMessagerecu(Messagechat $messagerecu): self
    {
        if (!$this->messagerecu->contains($messagerecu)) {
            $this->messagerecu[] = $messagerecu;
            $messagerecu->setUserrecoi($this);
        }

        return $this;
    }

    public function removeMessagerecu(Messagechat $messagerecu): self
    {
        if ($this->messagerecu->removeElement($messagerecu)) {
            // set the owning side to null (unless already changed)
            if ($messagerecu->getUserrecoi() === $this) {
                $messagerecu->setUserrecoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messagechat>
     */
    public function getMessageenvoi(): Collection
    {
        return $this->messageenvoi;
    }

    public function addMessageenvoi(Messagechat $messageenvoi): self
    {
        if (!$this->messageenvoi->contains($messageenvoi)) {
            $this->messageenvoi[] = $messageenvoi;
            $messageenvoi->setUserenvoi($this);
        }

        return $this;
    }

    public function removeMessageenvoi(Messagechat $messageenvoi): self
    {
        if ($this->messageenvoi->removeElement($messageenvoi)) {
            // set the owning side to null (unless already changed)
            if ($messageenvoi->getUserenvoi() === $this) {
                $messageenvoi->setUserenvoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUtilisateur() === $this) {
                $annonce->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setUtilisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getUtilisateur() !== $this) {
            $user->setUtilisateur($this);
        }

        $this->user = $user;

        return $this;
    }
}
<?php

namespace App\Entity;

use App\Repository\AccesDeckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccesDeckRepository::class)
 */
class AccesDeck
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_dernier_acces;

    /**
     * @ORM\ManyToOne(targetEntity=Deck::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $deck;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="accesDecks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDernierAcces(): ?\DateTimeInterface
    {
        return $this->date_dernier_acces;
    }

    public function setDateDernierAcces(\DateTimeInterface $date_dernier_acces): self
    {
        $this->date_dernier_acces = $date_dernier_acces;

        return $this;
    }

    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    public function setDeck(?Deck $deck): self
    {
        $this->deck = $deck;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}

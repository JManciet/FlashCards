<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeckRepository::class)
 */
class Deck
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date_creation;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="decks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="deck", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="decks")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Carte::class, mappedBy="deck", orphanRemoval=true)
     */
    private $cartes;

    /**
     * @ORM\OneToMany(targetEntity=NoteDeck::class, mappedBy="deck", orphanRemoval=true)
     */
    private $noteDecks;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->cartes = new ArrayCollection();
        $this->noteDecks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isVisibilite(): ?bool
    {
        return $this->visibilite;
    }

    public function setVisibilite(bool $visibilite): self
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeImmutable $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setDeck($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getDeck() === $this) {
                $commentaire->setDeck(null);
            }
        }

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

    /**
     * @return Collection<int, Carte>
     */
    public function getCartes(): Collection
    {
        return $this->cartes;
    }

    public function addCarte(Carte $carte): self
    {
        if (!$this->cartes->contains($carte)) {
            $this->cartes[] = $carte;
            $carte->setDeck($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getDeck() === $this) {
                $carte->setDeck(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteDeck>
     */
    public function getNoteDecks(): Collection
    {
        return $this->noteDecks;
    }

    public function addNoteDeck(NoteDeck $noteDeck): self
    {
        if (!$this->noteDecks->contains($noteDeck)) {
            $this->noteDecks[] = $noteDeck;
            $noteDeck->setDeck($this);
        }

        return $this;
    }

    public function removeNoteDeck(NoteDeck $noteDeck): self
    {
        if ($this->noteDecks->removeElement($noteDeck)) {
            // set the owning side to null (unless already changed)
            if ($noteDeck->getDeck() === $this) {
                $noteDeck->setDeck(null);
            }
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->titre;
    }
}

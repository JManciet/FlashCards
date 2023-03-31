<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarteRepository::class)
 */
class Carte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     */
    private $reponse;

    /**
     * @ORM\ManyToOne(targetEntity=Deck::class, inversedBy="cartes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deck;





    // /**
    //  * @ORM\OneToMany(targetEntity=PositionCarte::class, mappedBy="carte", orphanRemoval=false)
    //  */
    // private $positionCartes;

    // /**
    //  * @ORM\ManyToOne(targetEntity=PositionCarte::class, inversedBy="cartes")
    //  * @ORM\JoinColumn(nullable=false)
    //  */
    // private $positionCarte;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

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




    // /**
    //  * @return Collection<int, PositionCarte>
    //  */
    // public function getPositionCartes(): Collection
    // {
    //     return $this->positionCartes;
    // }


    // public function getPositionCarte(): ?PositionCarte
    // {
    //     return $this->positionCarte;
    // }

    // public function setPositionCarte(?PositionCarte $positionCarte): self
    // {
    //     $this->positionCarte = $positionCarte;

    //     return $this;
    // }


}

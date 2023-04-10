<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $question;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reponse;

    /**
     * @ORM\ManyToOne(targetEntity=Deck::class, inversedBy="cartes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deck;

    /**
     * @ORM\OneToMany(targetEntity=PositionCarte::class, mappedBy="carte", orphanRemoval=true)
     */
    private $positionCartes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_question;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_reponse;

    public function __construct()
    {
        $this->positionCartes = new ArrayCollection();
    }





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

    /**
     * @return Collection<int, PositionCarte>
     */
    public function getPositionCartes(): Collection
    {
        return $this->positionCartes;
    }

    public function addPositionCarte(PositionCarte $positionCarte): self
    {
        if (!$this->positionCartes->contains($positionCarte)) {
            $this->positionCartes[] = $positionCarte;
            $positionCarte->setCarte($this);
        }

        return $this;
    }

    public function removePositionCarte(PositionCarte $positionCarte): self
    {
        if ($this->positionCartes->removeElement($positionCarte)) {
            // set the owning side to null (unless already changed)
            if ($positionCarte->getCarte() === $this) {
                $positionCarte->setCarte(null);
            }
        }

        return $this;
    }

    public function getImageQuestion(): ?string
    {
        return $this->image_question;
    }

    public function setImageQuestion(?string $image_question): self
    {
        $this->image_question = $image_question;

        return $this;
    }

    public function getImageReponse(): ?string
    {
        return $this->image_reponse;
    }

    public function setImageReponse(?string $image_reponse): self
    {
        $this->image_reponse = $image_reponse;

        return $this;
    }


    public function validateOneFieldFilled(ExecutionContextInterface $context, $payload)
{
    if (!$this->reponse && !$this->question) {
        $context->buildViolation('Au moins un champ doit être rempli')
            ->atPath('reponse')
            ->addViolation();
        $context->buildViolation('Au moins un champ doit être rempli')
            ->atPath('question')
            ->addViolation();
    }
}

}

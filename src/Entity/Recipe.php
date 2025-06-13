<?php

namespace App\Entity;
use App\Entity\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\RecipeRepository;
use App\Validator\InappropriateWords;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Mime\Message;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(name:"recipes")]
#[UniqueEntity('Title')]


class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Titre obligatoire")]
    #[Assert\Length(min: 10, max: 50,minMessage: "Minimum 10 caractères",maxMessage:"Maximum 50 caractères")]
    #[InappropriateWords()]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
     #[Assert\NotBlank(message: "Contenu obligatoire")]
    #[Assert\Length(min: 20,minMessage: "Minimum 20 caractères")]
    private ?string $Content = null;

   
    use Timestampable;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "Vous devez introduire une durée positive")]
    #[Assert\LessThan(1440,message: "Vous ne pouvez pas introduire de recette de plus de 24h")]
    private ?int $duration = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $imageName = "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

   

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }
}

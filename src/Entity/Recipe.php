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
    #[Assert\Length(min: 10, max: 50)]
    #[InappropriateWords()]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
     #[Assert\NotBlank()]
    #[Assert\Length(min: 20)]
    private ?string $Content = null;

   
    use Timestampable;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan()]
    private ?int $duration = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $imageName = "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

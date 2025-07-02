<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Order;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'This email is already in use.')]
#[
    ApiResource(
        normalizationContext: ['groups' => ['customer:read']],
    
    ),
    ApiFilter(
        SearchFilter::class,
        properties: [
            'name' => SearchFilter::STRATEGY_PARTIAL,
            'email' => SearchFilter::STRATEGY_PARTIAL,
            'size' => SearchFilter::STRATEGY_EXACT,
        ]
    )
]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read', 'customer:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Name cannot be blank.')]
    #[Groups(['order:read', 'customer:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Email cannot be blank.')]
    #[Groups(['order:read', 'customer:read'])]
    private ?string $email = null;

    #[ORM\Column(nullable: false)]
    #[Assert\Type(type: 'integer', message: 'Size must be an integer.')]
    #[Assert\NotBlank(message: 'Size cannot be blank.')]
    #[Assert\Positive(message: 'Size must be a positive number')]
    #[Groups(['order:read', 'customer:read'])]
    private ?int $size = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[
    ApiResource(
        normalizationContext: ['groups' => ['product:read']]
    ),
    ApiFilter(
        SearchFilter::class,
        properties: [
            'name' => SearchFilter::STRATEGY_PARTIAL,
            'category' => SearchFilter::STRATEGY_PARTIAL,
            'quantity' => SearchFilter::STRATEGY_EXACT,
        ]
    )
]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read', 'product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Name cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Name cannot exceed 255 characters.')]
    #[Groups(['order:read', 'product:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Category cannot be blank.')]
    #[Assert\Length(max: 50, maxMessage: 'Category cannot exceed 50 characters.')]
    #[Groups(['order:read', 'product:read'])]
    private ?string $category = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Quantity cannot be blank.')]
    #[Assert\Type(type: 'integer', message: 'Quantity must be an integer.')]
    #[Assert\Positive(message: 'Quantity must be a positive number.')]
    #[Groups(['order:read', 'product:read'])]
    private ?int $quantity = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['order:read', 'product:read'])]
    private float $price;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Order::class)]
    #[Groups(['product:read'])]
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getProduct() === $this) {
                $order->setProduct(null);
            }
        }

        return $this;
    }
}

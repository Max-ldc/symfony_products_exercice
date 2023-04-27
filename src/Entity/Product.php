<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $basePrice = null;

    #[ORM\Column]
    private bool $visible = true;

    #[ORM\Column]
    private bool $discount = false;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public const TVA_RATE = 0.2;
    public const DISCOUNT_RATE = 0.25;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getBasePrice(): ?float
    {
        return $this->basePrice;
    }

    public function getTTCPrice(): ?float
    {
        return round($this->basePrice * (1 + self::TVA_RATE), 2);
    }

    public function getSellPrice(): ?float
    {
        $priceTTC = $this->getTTCPrice();

        return $this->isDiscount() ?
            round($priceTTC - ($priceTTC * self::DISCOUNT_RATE), 2) :
            $priceTTC;
    }

    public function setBasePrice(float $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function isDiscount(): ?bool
    {
        return $this->discount;
    }

    public function setDiscount(bool $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}

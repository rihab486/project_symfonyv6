<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $client_name = null;

    #[ORM\Column(length: 255)]
    private ?string $client_address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $delivrey_address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $billing_address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shipping_address = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $order_cost = null;

    #[ORM\Column(nullable: true)]
    private ?int $taxe = null;

    #[ORM\Column]
    private ?int $order_cost_ttc = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPaid = false;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $carrier_price = null;

    #[ORM\Column(length: 255)]
    private ?string $carrier_name = null;

    #[ORM\Column]
    private ?int $carrier_id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(targetEntity: OrderDetails::class, mappedBy: 'myOrder')]
    private Collection $orderDetails;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripeClientSecret = null;


    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): static
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getClientAddress(): ?string
    {
        return $this->client_address;
    }

    public function setClientAddress(string $client_address): static
    {
        $this->client_address = $client_address;

        return $this;
    }

    public function getDelivreyAddress(): ?string
    {
        return $this->delivrey_address;
    }

    public function setDelivreyAddress(?string $delivrey_address): static
    {
        $this->delivrey_address = $delivrey_address;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billing_address;
    }

    public function setBillingAddress(?string $billing_address): static
    {
        $this->billing_address = $billing_address;

        return $this;
    }

    public function getShippingAddress(): ?string
    {
        return $this->shipping_address;
    }

    public function setShippingAddress(?string $shipping_address): static
    {
        $this->shipping_address = $shipping_address;

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

    public function getOrderCost(): ?int
    {
        return $this->order_cost;
    }

    public function setOrderCost(int $order_cost): static
    {
        $this->order_cost = $order_cost;

        return $this;
    }

    public function getTaxe(): ?int
    {
        return $this->taxe;
    }

    public function setTaxe(?int $taxe): static
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getOrderCostTtc(): ?int
    {
        return $this->order_cost_ttc;
    }

    public function setOrderCostTtc(int $order_cost_ttc): static
    {
        $this->order_cost_ttc = $order_cost_ttc;

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): static
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCarrierPrice(): ?int
    {
        return $this->carrier_price;
    }

    public function setCarrierPrice(int $carrier_price): static
    {
        $this->carrier_price = $carrier_price;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrier_name;
    }

    public function setCarrierName(string $carrier_name): static
    {
        $this->carrier_name = $carrier_name;

        return $this;
    }

    public function getCarrierId(): ?int
    {
        return $this->carrier_id;
    }

    public function setCarrierId(int $carrier_id): static
    {
        $this->carrier_id = $carrier_id;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setMyOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getMyOrder() === $this) {
                $orderDetail->setMyOrder(null);
            }
        }

        return $this;
    }

    public function getStripeClientSecret(): ?string
    {
        return $this->stripeClientSecret;
    }

    public function setStripeClientSecret(?string $stripeClientSecret): static
    {
        $this->stripeClientSecret = $stripeClientSecret;

        return $this;
    }

   




}

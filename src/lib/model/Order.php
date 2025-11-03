<?php

declare(strict_types=1);

require_once "OrderStatus.php";

class OrderDTO
{
    private string $orderId;
    private DateTimeImmutable $createdAt;
    private OrderStatus $status;
    private ?string $userEmail;
    private int $lineItemCount;
    private float $orderValue;

    public static function fromArray(array $data): OrderDTO
    {
        $orderDTO = new self();
        $orderDTO->orderId = $data["orderId"];
        $orderDTO->createdAt = new DateTimeImmutable($data["orderCreatedAt"]);
        $orderDTO->status = OrderStatus::from($data["orderStatus"]);
        $orderDTO->userEmail = $data['email'] ?? null;
        $orderDTO->lineItemCount = $data['orderLineItems'];
        $orderDTO->orderValue = (float) $data['orderValue'];

        return $orderDTO;
    }

// can't assign int to OrderStatus
    public function computeStatus(OrderStatus $status): string
    {
        return match ($status) {
            OrderStatus::CANCELLED => 'cancelled',
            OrderStatus::PROCESSING => 'processing',
            OrderStatus::COMPLETED => 'finished',
            default => 'Invalid'
        };
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getStatusText(): string
    {
        return $this->computeStatus($this->status);
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getLineItemCount(): int
    {
        return $this->lineItemCount;
    }

    public function getValue(): float
    {
        return $this->orderValue;
    }

    public function isFinished(): bool
    {
        return $this->status === OrderStatus::COMPLETED;
    }
}
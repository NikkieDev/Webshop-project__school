<?php

class OrderDTO
{
    private string $orderId;
    private DateTimeImmutable $createdAt;
    private string $status;
    private string $userEmail;
    private int $lineItemCount;
    private float $orderValue;

    public static function fromArray(array $data): OrderDTO
    {
        $orderDTO = new self();
        $orderDTO->orderId = $data["orderId"];
        $orderDTO->createdAt = new DateTimeImmutable($data["orderCreatedAt"]);
        $orderDTO->status = self::computeStatus($data["orderStatus"]);
        $orderDTO->userEmail = $data['email'];
        $orderDTO->lineItemCount = $data['orderLineItems'];
        $orderDTO->orderValue = $data['orderValue'];

        return $orderDTO;
    }

    public static function computeStatus(int $status): string
    {
        return match ($status) {
            -1 => 'cancelled',
            0 => 'processing',
            1 => 'finished'
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

    public function getStatus(): string
    {
        return $this->status;
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
}
<?php

declare(strict_types= 1);

class OrderLineItemDTO
{
    private string $id;
    private float $price;
    private string $title;
    private int $quantity;
    private int $stockQuantity;

    public static function fromArray(array $data): OrderLineItemDTO
    {
        $orderLineItem = new self();
        $orderLineItem->id = $data["lineItemId"];
        $orderLineItem->price = $data["productPrice"];
        $orderLineItem->title = $data["productName"];
        $orderLineItem->quantity = $data["quantity"];
        $orderLineItem->stockQuantity = $data["stockQuantity"];

        return $orderLineItem;
    }
}
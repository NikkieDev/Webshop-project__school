<?php

declare(strict_types= 1);

enum OrderStatus: int
{
    case CANCELLED = -1;
    case PROCESSING = 0;
    case COMPLETED = 1;
}
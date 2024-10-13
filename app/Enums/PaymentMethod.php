<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case MOMO = "1";
    case VNPAY = "2";
    case ATM = "3";
    case VISA = "4";
}

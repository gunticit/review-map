<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case MOMO = "1";
    case VNPAY = "2";
    case ATM = "3";
    case VISA = "4";

    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::MOMO->value => 'MoMo',
            self::VNPAY->value => 'VNPay',
            self::ATM->value => 'Ngân hàng',
            self::VISA->value => 'Visa',
            default => 'Không xác định',
        };
    }
}




<?php

namespace App\Domain\Payment\Enums;

enum PaymentMethod: string
{
    case PIX = 'PIX';
    case CREDIT_CARD_ONE_TIME = 'CREDIT_CARD_ONE_TIME';
    case CREDIT_CARD_INSTALLMENTS = 'CREDIT_CARD_INSTALLMENTS';

    /**
     * @return class-string<\App\Domain\Payment\Interfaces\PaymentMethodInterface>
     */
    public function getStrategy(): string
    {
        return match ($this) {
            self::PIX => \App\Domain\Payment\Methods\PixPayment::class,
            self::CREDIT_CARD_ONE_TIME => \App\Domain\Payment\Methods\CreditCardOneTime::class,
            self::CREDIT_CARD_INSTALLMENTS => \App\Domain\Payment\Methods\CreditCardInstallments::class,
        };
    }
}

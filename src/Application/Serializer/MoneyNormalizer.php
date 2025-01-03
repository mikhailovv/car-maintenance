<?php

namespace App\Application\Serializer;

use Money\Currency;
use Money\Money;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MoneyNormalizer implements NormalizerInterface
{
    public function getSupportedTypes(?string $format): array
    {
        return [
            Money::class => true,
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Money;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /** @var Money $object */
        return [
            'amount' => $object->getAmount(),
            'currency' => $object->getCurrency(),
        ];
    }

    public function denormalize($data, string $type, string $format = null, array $context = []): mixed
    {
        return new Money($data['amount'], new Currency($data['currency']));
    }
}

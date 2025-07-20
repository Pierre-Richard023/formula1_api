<?php

namespace App\Serializer\Normalizer;

use App\Entity\EntrantsDrivers;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EntrantsDriversNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        if (!$object instanceof EntrantsDrivers) {
            throw new \InvalidArgumentException();
        }
        $entrantsDrivers = $this->normalizer->normalize($object, $format, $context);
        $entrantsDrivers['drivers']=$object->getDrivers()->getDriverId();

        return $entrantsDrivers;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof EntrantsDrivers;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [EntrantsDrivers::class => true];
    }
}

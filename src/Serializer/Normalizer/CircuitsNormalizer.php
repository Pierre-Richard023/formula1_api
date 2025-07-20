<?php

namespace App\Serializer\Normalizer;

use App\Entity\Circuits;
use App\Entity\Constructors;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CircuitsNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        if (!$object instanceof Circuits) {
            throw new \InvalidArgumentException();
        }

        $circuits = $this->normalizer->normalize($object, $format, $context);
        $circuits['country'] = [
            'name' => $object->getCountry()->getName(),
            'continent' => $object->getCountry()->getContinent(),
        ];

        return $circuits;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Circuits;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Circuits::class => true];
    }
}

<?php

namespace App\Serializer\Normalizer;

use App\Entity\Constructors;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConstructorsNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        if (!$object instanceof Constructors) {
            throw new \InvalidArgumentException();
        }

        $constructors = $this->normalizer->normalize($object, $format, $context);

        $constructors['country'] = [
            'name' => $object->getCountry()->getName(),
            'continent' => $object->getCountry()->getContinent(),
        ];
        return $constructors;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Constructors;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Constructors::class => true];
    }
}

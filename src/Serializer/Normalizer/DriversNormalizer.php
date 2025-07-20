<?php

namespace App\Serializer\Normalizer;

use App\Entity\Drivers;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DriversNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        if (!$object instanceof Drivers) {
            throw new \InvalidArgumentException();
        }
        $drivers = $this->normalizer->normalize($object, $format, $context);


        if ($object->getCountryOfBirth()) {
            $countryOfBirth = $object->getCountryOfBirth();
            $drivers['countryOfBirth'] = [
                'country' => $countryOfBirth->getName(),
                'continent' => $countryOfBirth->getContinent(),
            ];
        }
        if ($object->getNationality()) {
            $nationality = $object->getNationality();
            $drivers['nationality'] = [
                'nationality' => $nationality->getDemonym(),
                'country' => $nationality->getName(),
            ];
        }
        if ($object->getSecondNationality()) {
            $nationality = $object->getSecondNationality();
            $drivers['secondNationality'] = [
                'nationality' => $nationality->getDemonym(),
                'country' => $nationality->getName(),
            ];
        }

        return $drivers;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Drivers;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Drivers::class => true,
        ];
    }

}

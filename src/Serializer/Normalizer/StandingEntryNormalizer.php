<?php

namespace App\Serializer\Normalizer;

use App\Entity\Races;
use App\Entity\StandingEntry;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class StandingEntryNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer
    )
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        if (!$object instanceof StandingEntry) {
            return $object;
        }

        $entry = $this->normalizer->normalize($object, $format, $context);

        $session = $object->getStandings()->getSession();
        if ($session) {
            $entry['position'] = $object->getPosition();
            if ($session->getName() === "race")
                $entry['points'] = $object->getPoints();

            $entry['raceTime'] = $object->getRaceTime();
        }

        if (!$session) {

            if ($object->getConstructor()) {
                $entry['constructorId'] = $object->getConstructor()->getId();
                $entry['name'] = $object->getConstructor()->getFullName();
            }

            if ($object->getDriver()) {
                $entry['driverId'] = $object->getDriver()->getId();
                $entry['name'] = $object->getDriver()->getFullName();
            }

            $entry['position'] = $object->getPosition();
            $entry['points'] = $object->getPoints();
        }
        
        return $entry;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof StandingEntry;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            StandingEntry::class => true,
        ];
    }
}

<?php

namespace App\Serializer\Normalizer;

use App\Entity\Circuits;
use App\Entity\Constructors;
use App\Entity\Drivers;
use App\Entity\EntrantsDrivers;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer implements NormalizerInterface
{

    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface       $normalizer,
        private readonly DriversNormalizer         $driversNormalizer,
        private readonly ConstructorsNormalizer    $constructorsNormalizer,
        private readonly CircuitsNormalizer        $circuitsNormalizer,
        private readonly EntrantsDriversNormalizer $entrantsDriversNormalizer,
    )
    {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        if (!($object instanceof Paginator)) {
            throw new \InvalidArgumentException('$object must be an instance of Paginator');
        }

        $totalItems = count($object);
        $itemsPerPage = $context['itemsPerPage'];
        $currentPage = $context['currentPage'];
        $totalPages = (int)ceil($totalItems / $itemsPerPage);
        $results = [];
        foreach ($object as $item) {

            if ($item instanceof Drivers) {
                $results[] = $this->driversNormalizer->normalize($item, $format, $context);
            } else
                if ($item instanceof Constructors) {
                    $results[] = $this->constructorsNormalizer->normalize($item, $format, $context);
                } else
                    if ($item instanceof Circuits) {
                        $results[] = $this->circuitsNormalizer->normalize($item, $format, $context);
                    } else
                        if ($item instanceof EntrantsDrivers) {
                            $results[] = $this->entrantsDriversNormalizer->normalize($item, $format, $context);
                        } else {
                            $results[] = $this->normalizer->normalize($item, $format, $context);
                        }
        }

        return [
            'results' => $results,
            'totalItems' => $totalItems,
            'currentPage' => $currentPage,
            'itemsPerPage' => $itemsPerPage,
            'totalPages' => $totalPages,
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Paginator;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Paginator::class => true
        ];
    }
}
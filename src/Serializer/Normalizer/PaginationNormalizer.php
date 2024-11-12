<?php

namespace App\Serializer\Normalizer;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @method array getSupportedTypes(?string $format)
 */
class PaginationNormalizer implements NormalizerInterface
{


    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = [])
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
            $results[] = $this->normalizer->normalize($item, $format, $context);
        }

        return [
            'results' => $results,
            'totalItems' => $totalItems,
            'currentPage' => $currentPage,
            'itemsPerPage' => $itemsPerPage,
            'totalPages' => $totalPages,
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        return $data instanceof Paginator;
    }

    public function __call(string $name, array $arguments): array
    {
        return [
            Paginator::class => true
        ];
    }
}
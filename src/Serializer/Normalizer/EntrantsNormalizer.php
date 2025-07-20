<?php

namespace App\Serializer\Normalizer;

use App\Entity\Entrants;
use App\Repository\RacesRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EntrantsNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer,
        private readonly RacesRepository $racesRepository
    )
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {


        if (!$object instanceof Entrants) {
            throw new \InvalidArgumentException();
        }
        $entrant = $this->normalizer->normalize($object, $format, $context);

        $entrant['constructors']=$object->getConstructors()->getConstructorId();
        $entrant['races'] = [];
        foreach ($object->getRaces() as $race) {

            $r= $this->racesRepository->getRacesInformations($race);
            $entrant['races'][] = [
                'racesId' => $race,
                'circuitId'=>$r->getCircuit()->getCircuitsId(),
                'date'=>$r->getRaceDate()->format('d-m-Y'),

            ];
        }

        return $entrant;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Entrants;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Entrants::class => true];
    }
}

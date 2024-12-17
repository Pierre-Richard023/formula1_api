<?php

namespace App\Controller;

use App\Entity\Races;
use App\Repository\RacesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


#[Route('/api/seasons/races')]
class RacesController extends AbstractController
{

    public function __construct(private readonly TagAwareCacheInterface $myCachePool)
    {
    }


    #[Route('/', methods: ['GET'])]
    public function findRaces(Request $request, RacesRepository $racesRepository, SerializerInterface $serializer): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);
        $country = $request->query->get('country');
        $circuit = $request->query->getInt('circuit', -1);
        $minLaps = $request->query->getInt('min_laps', -1);
        $maxLaps = $request->query->getInt('max_laps', -1);

        $key = 'getAllRacesBy_' . $country . '_' . $circuit . '_' . $minLaps . '_' . $maxLaps . '_' . $limit . '_' . $page;
        $races = $this->myCachePool->get($key, function (ItemInterface $item) use ($racesRepository, $country, $circuit, $minLaps, $maxLaps, $limit, $page, $serializer) {
            $item->get('racesCaches');
            $item->expiresAfter(3600);
            $racesLists = $racesRepository->findRacesAndPaginate($country, $circuit, $minLaps, $maxLaps, $page, $limit);
            $context = [
                'currentPage' => $page,
                'itemsPerPage' => $limit,
                "groups" => ["races.search"],
                'datetime_format' => 'd-m-Y',
            ];

            return $serializer->serialize($racesLists, 'json', $context);
        });

        return new JsonResponse($races, Response::HTTP_OK, [], true);
    }


    #[Route('/{id}', requirements: ['id' => Requirement::DIGITS], methods: ['GET'])]
    public function show(Races $race, SerializerInterface $serializer): JsonResponse
    {

        $cacheKey = 'race_' . $race->getId();
        $cacheTag = 'race_' . $race->getId();
        $data = $this->myCachePool->get($cacheKey, function (ItemInterface $item) use ($race, $cacheTag, $serializer) {
            $item->get($cacheTag);
            $item->expiresAfter(3600);
            $context = [
                "groups" => ["races.show"],
                'datetime_format' => 'd-m-Y',
            ];

            return $serializer->serialize($race, 'json', $context);
        });

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}

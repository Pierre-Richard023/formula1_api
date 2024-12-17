<?php

namespace App\Controller;

use App\Entity\Circuits;
use App\Repository\CircuitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/circuits')]
class CircuitsController extends AbstractController
{

    public function __construct(private readonly TagAwareCacheInterface $myCachePool)
    {
    }

    #[Route('/', methods: ['GET'])]
    public function index(Request $request, CircuitsRepository $circuitsRepository, SerializerInterface $serializer): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);
        $season = $request->query->getInt('season', 0);
        $country = $request->query->get('country');
        $key = 'getAllCircuits_' . $country . '_' . $season . '_' . $page . '_' . $limit;

        $circuits = $this->myCachePool->get($key, function (ItemInterface $item) use ($circuitsRepository, $country, $season, $page, $limit, $serializer) {
            $item->get('circuitsCaches');
            $item->expiresAfter(3600);
            $circuitsLists = $circuitsRepository->SearchAndPaginateCircuits($country, $season, $page, $limit);
            $context = [
                'currentPage' => $page,
                'itemsPerPage' => $limit,
                "groups" => ["circuits.search"],
                'datetime_format' => 'd-m-Y',
            ];

            return $serializer->serialize($circuitsLists, "json", $context);
        });
        return new JsonResponse($circuits, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', requirements: ['id' => Requirement::DIGITS], methods: ['GET'])]
    public function show(Circuits $circuit, SerializerInterface $serializer): JsonResponse
    {
        $cacheKey = 'circuit_' . $circuit->getId();
        $cacheTag = 'circuit_' . $circuit->getId();
        $data = $this->myCachePool->get($cacheKey, function (ItemInterface $item) use ($cacheTag, $circuit, $serializer) {
            $item->get($cacheTag);
            $item->expiresAfter(3600);
            $context = [
                "groups" => ["circuits.show"],
                'datetime_format' => 'd-m-Y',
            ];
            return $serializer->serialize($circuit, "json", $context);
        });

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}

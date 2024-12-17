<?php

namespace App\Controller;

use App\Entity\Seasons;
use App\Repository\SeasonsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/seasons')]
class SeasonsController extends AbstractController
{
    public function __construct(private readonly TagAwareCacheInterface $myCachePool)
    {
    }

    #[Route('/', name: 'seasons', methods: ['GET'])]
    public function index(Request $request, SeasonsRepository $seasonsRepository, SerializerInterface $serializer): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);

        $key = 'getAllSeasons_' . $page . '_' . $limit;
        $seasons = $this->myCachePool->get($key,
            function (ItemInterface $item) use ($seasonsRepository, $page, $limit, $serializer) {
                $item->get("seasonsCache");
                $item->expiresAfter(3600);
                $s = $seasonsRepository->paginateSeasons($page, $limit);

                $context = [
                    'currentPage' => $page,
                    'itemsPerPage' => $limit,
                    "groups" => ["seasons.index"],
                ];
                return $serializer->serialize($s, "json", $context);
            });

        return new JsonResponse($seasons, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', requirements: ['id' => Requirement::DIGITS], methods: ['GET'])]
    public function show(Seasons $season, SerializerInterface $serializer): JsonResponse
    {
        $cacheKey = 'season_' . $season->getId();
        $cacheTag = 'season_' . $season->getId();

        $data = $this->myCachePool->get($cacheKey, function (ItemInterface $item) use ($season, $cacheTag, $serializer) {
            $item->get($cacheTag);
            $item->expiresAfter(3600);
            $context = [
                "groups" => ["seasons.show", "seasons.show.standing.driver", "seasons.show.standing.constructor"],
                'datetime_format' => 'd-m-Y',
            ];
            return $serializer->serialize($season, 'json', $context);
        });

        return new JsonResponse($data, Response::HTTP_OK, [], true);

    }

}

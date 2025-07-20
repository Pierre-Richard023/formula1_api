<?php

namespace App\Controller;

use App\Entity\Drivers;
use App\Repository\DriversRepository;
use App\Repository\EntrantsDriversRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/drivers')]
class DriversController extends AbstractController
{

    public function __construct(private readonly TagAwareCacheInterface $myCachePool)
    {
    }

    #[Route('/', methods: ['GET'])]
    public function index(Request $request, DriversRepository $driversRepository, SerializerInterface $serializer): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);
        $nationality = $request->query->get('nationality');
        $key = 'getAllDrivers_' . $nationality . '_' . $page . '_' . $limit;
        $drivers = $this->myCachePool->get($key, function (ItemInterface $item) use ($nationality, $driversRepository, $page, $limit, $serializer) {
            $item->get('driversCache');
            $item->expiresAfter(3600);

            $driversLists = $driversRepository->paginateDrivers($nationality, $page, $limit);
            $context = [
                'currentPage' => $page,
                'itemsPerPage' => $limit,
                "groups" => ["drivers.search"],
                'datetime_format' => 'd-m-Y',
            ];

            return $serializer->serialize($driversLists, 'json', $context);
        });
        return new JsonResponse($drivers, Response::HTTP_OK, [], true);
    }


    #[Route('/{id}', requirements: ['id' => '[a-z0-9\-]+'], methods: ['GET'])]
    public function show(string $id, SerializerInterface $serializer, DriversRepository $driversRepository): JsonResponse
    {

        $drivers = $driversRepository->getDriverInformation($id);

        $cacheKey = 'driver_' . $drivers->getDriverId();
        $cacheTag = 'driver_' . $drivers->getDriverId();

        $data = $this->myCachePool->get($cacheKey, function (ItemInterface $item) use ($drivers, $cacheTag, $serializer) {
            $item->get($cacheTag);
            $item->expiresAfter(3600);
            $context = [
                "groups" => ["drivers.show"],
                'datetime_format' => 'd-m-Y',
            ];

            return $serializer->serialize($drivers, 'json', $context);
        });
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}/career', requirements: ['id' => '[a-z0-9\-]+'], methods: ['GET'])]
    public function career(string $id, Request $request, SerializerInterface $serializer, DriversRepository $driversRepository, EntrantsDriversRepository $entrantsDriversRepository)
    {
        $drivers = $driversRepository->getDriverInformation($id);

        $cacheKey = 'driver_career' . $drivers->getDriverId();
        $cacheTag = 'driver_career' . $drivers->getDriverId();

        $data = $this->myCachePool->get($cacheKey, function (ItemInterface $item) use ($entrantsDriversRepository, $drivers, $cacheTag, $serializer) {
            $item->get($cacheTag);
            $item->expiresAfter(3600);
            $context = [

                "groups" => ["drivers.career"],
                'datetime_format' => 'd-m-Y',
            ];

            $entrants = $entrantsDriversRepository->getDriversEntrants($drivers);
            return $serializer->serialize($entrants, 'json', $context);
        });
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}

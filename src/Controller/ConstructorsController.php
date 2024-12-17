<?php

namespace App\Controller;

use App\Entity\Constructors;
use App\Repository\ConstructorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/constructors')]
class ConstructorsController extends AbstractController
{

    public function __construct(private readonly TagAwareCacheInterface $myCachePool)
    {
    }


    #[Route('/', methods: ['GET'])]
    public function index(Request $request, ConstructorsRepository $constructorsRepository, SerializerInterface $serializer): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);
        $country = $request->query->get('country');
        $key = 'getAllConstructors_' . $country . '_' . $page . '_' . $limit;
        $constructors = $this->myCachePool->get($key, function (ItemInterface $item) use ($constructorsRepository, $page, $limit, $country, $serializer) {
            $item->get('constructorsCache');
            $item->expiresAfter(3600);
            $constructorsLists = $constructorsRepository->searchAndPaginatConstructor($country, $page, $limit);
            $context = [
                'currentPage' => $page,
                'itemsPerPage' => $limit,
                "groups" => ["constructors.search"],
                'datetime_format' => 'd-m-Y',
            ];
            return $serializer->serialize($constructorsLists, 'json', $context);
        });

        return new JsonResponse($constructors, Response::HTTP_OK, [], true);

    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Constructors $constructors, SerializerInterface $serializer): JsonResponse
    {

        $cacheKey = 'constructor_' . $constructors->getId();
        $cacheTag = 'constructor_' . $constructors->getId();

        $data = $this->myCachePool->get($cacheKey, function (ItemInterface $item) use ($cacheTag, $constructors, $serializer) {
            $item->get($cacheTag);
            $item->expiresAfter(3600);

            $context = [
                "groups" => ["constructors.show"],
                'datetime_format' => 'd-m-Y',
            ];
            return $serializer->serialize($constructors, 'json', $context);
        });
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

}


<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use App\Service\StoreService;
use Doctrine\Common\Cache\FilesystemCache;
use Redis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class StoreController extends AbstractController
{
    /**
     * @param Request      $request
     * @param StoreService $storeService
     *
     * @return JsonResponse
     */
    public function getList(Request $request, StoreService $storeService)
    {
        try {
            $data = $storeService->getList(
                $request->query->get('x', null),
                $request->query->get('y', null),
                (float)$request->query->get('r', 10)
            );
            return $this->json($data, 200);
        } catch (\Exception $e) {
            return $this->json(['error_message' => $e->getMessage(), 'error_code' => $e->getCode()], 400);
        }
    }
}
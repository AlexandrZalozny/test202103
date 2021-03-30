<?php
namespace App\Service;

use App\Repository\StoreRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class StoreService
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function getList($x,$y,$r)
    {
        if (is_null($x) || is_null($y)) {
            throw new \Exception('bad coordinates');
        }

        if ($r < 5) {
            $r = 5;
        } elseif ($r > 25) {
            $r = 25;
        }
        $storeRepository= $this->storeRepository;
        $cache = new FilesystemAdapter();

        $stores = $cache->get(
            $x."_".$y."_".$r,
            function (ItemInterface $item) use ($storeRepository, $x, $y, $r) {
                $item->expiresAfter(3600);
                $stores = $storeRepository->findByCoordinates($x, $y, $r);

                return $stores;
            }
        );

        return ['data' => $stores];
    }
}
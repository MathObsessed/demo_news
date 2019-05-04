<?php

namespace App\Service;

use App\Entity\News;
use App\Exception\NewsNotFound;
use App\Repository\NewsRepository;

class NewsService {
    private $repository;

    public function __construct(NewsRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @return News[]
     */
    public function findAll():array {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * @return News
     * @throws NewsNotFound
     */
    public function findById(int $id):News {
        $item = $this->repository->find($id);

        if (empty($item)) {
            throw new NewsNotFound($id);
        }

        return $item;
    }
}

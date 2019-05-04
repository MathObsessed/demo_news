<?php

namespace App\Service;

use App\Exception\NewsNotFound;
use App\Repository\NewsRepository;

class News {
    private $repository;

    public function __construct(NewsRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @return \App\Entity\News[]
     */
    public function fetchAll():array {
        return $this->repository->findAll();
    }

    public function fetchById(int $id) {
        return $this->repository->find($id);
    }
}

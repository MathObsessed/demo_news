<?php

namespace App\Service;

use App\Entity\News;
use App\Exception\NewsNotFound;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewsService {
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, NewsRepository $repository) {
        $entityManager->getFilters()->enable('soft_deleteable');

        $this->entityManager = $entityManager;
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

    /**
     * @param int $id
     * @throws NewsNotFound
     */
    public function deleteById(int $id):void {
        $item = $this->findById($id);

        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

    /**
     * @param News $item
     */
    public function persist(News $item):void {
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }
}

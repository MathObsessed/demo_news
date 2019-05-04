<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {
    private $newsService;

    public function __construct(NewsService $newsService) {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index() {
        return $this->render('default/index.html.twig', [
            'news' => $this->newsService->findAll()
        ]);
    }

    /**
     * @Route("/news/{id<\d+>}", name="news_show")
     */
    public function newsShow($id) {
        return $this->render('default/news.html.twig', [
            'item' => $this->newsService->findById($id)
        ]);
    }

    /**
     * @Route("/news/delete/{id<\d+>}", name="news_delete")
     */
    public function newsDelete($id) {
        //TODO: Implement delete logic!

        return $this->redirectToRoute('homepage');
    }
}

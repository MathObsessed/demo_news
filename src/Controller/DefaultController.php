<?php

namespace App\Controller;

use App\Exception\NewsNotFound;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {
    private $newsService;

    public function __construct(NewsService $newsService) {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/", name="homepage")
     * @Route("/news", methods={"GET"}, name="get_all_news")
     */
    public function index() {
        $items = $this->newsService->findAll();

        return $this->render('default/index.html.twig', ['items' => $items]);
    }

    /**
     * @Route("/form", name="news_form")
     */
    public function newsForm() {
        return $this->render('default/form.html.twig');
    }

    /**
     * @Route("/news/{id<\d+>}", methods={"GET"}, name="get_news_by_id")
     */
    public function newsGet($id) {
        try {
            $item = $this->newsService->findById($id);
        }
        catch (NewsNotFound $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->render('default/item.html.twig', ['item' => $item]);
    }

    /**
     * @Route("/news/{id<\d+>}", methods={"DELETE"}, name="delete_news_by_id")
     */
    public function newsDelete($id) {
        try {
            $this->newsService->deleteById($id);
        }
        catch (NewsNotFound $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/news", methods={"POST"}, name="post_news")
     */
    public function newsPost(Request $request) {
        //TODO: Implement logic!

        dump($request->files);
        dump($request->request);

        return new Response('', Response::HTTP_OK);
    }
}

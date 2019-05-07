<?php

namespace App\Controller;

use App\Exception\NewsNotFound;
use App\Service\AssetService;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {
    private $newsService;
    private $assetService;

    public function __construct(NewsService $newsService, AssetService $assetService) {
        $this->newsService = $newsService;
        $this->assetService = $assetService;
    }

    /**
     * @Route("/", name="homepage")
     * @Route("/news", methods={"GET"}, name="get_all_news")
     */
    public function index() {
        $items = $this->newsService->findAll();

        return $this->render('default/index.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @Route("/form", name="news_form_create")
     * @Route("/form/{id<\d+>}", name="news_form_edit")
     */
    public function newsForm($id = '') {
        $item = null;

        if (!empty($id)) {
            try {
                $item = $this->newsService->findById($id);
            }
            catch (NewsNotFound $e) {
                throw $this->createNotFoundException($e->getMessage());
            }
        }

        return $this->render('default/form.html.twig', [
            'item' => $item
        ]);
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

        return $this->render('default/item.html.twig', [
            'item' => $item
        ]);
    }

    /**
     * @Route("/assets/{fileName}", name="fetch_asset")
     */
    public function fetchAsset($fileName) {
        BinaryFileResponse::trustXSendfileTypeHeader();

        try {
            $response = new BinaryFileResponse($this->assetService->filePathByName($fileName));
            $fileMimeType = $this->assetService->fileByName($fileName)->getMimeType();
        }
        catch (FileNotFoundException $e) {
            throw $this->createNotFoundException();
        }

        $response->headers->set('Content-Type', $fileMimeType);
        $response->headers->set('Content-Disposition', HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_INLINE, $fileName));

        return $response;
    }
}

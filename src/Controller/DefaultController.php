<?php

namespace App\Controller;

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
     * @Route("/images/{fileName}", name="fetch_images")
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

    /**
     * @Route("/", name="homepage")
     * @Route("/{route}", name="vue_router", requirements={"route"="^(?!.*images|_wdt|_profiler).+"})
     */
    public function index() {
        $items = $this->newsService->findAll();

        return $this->render('default/index.html.twig', [
            'imagePrefix' => AssetService::DIRECTORY.DIRECTORY_SEPARATOR,
            'items' => $items
        ]);
    }
}

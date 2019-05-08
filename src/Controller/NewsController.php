<?php

namespace App\Controller;

use App\Entity\News;
use App\Exception\NewsNotFound;
use App\Form\NewsType;
use App\Service\AssetService;
use App\Service\NewsService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/news")
 */
class NewsController extends AbstractFOSRestController implements ClassResourceInterface {
    private $assetService;
    private $newsService;

    public function __construct(AssetService $assetService, NewsService $newsService) {
        $this->assetService = $assetService;
        $this->newsService = $newsService;
    }

    /**
     * @Route("/", methods={"GET"}, name="api_news_cget")
     */
    public function cgetAction() {
        return $this->view($this->findNews(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id<\d+>}", methods={"GET"}, name="api_news_get")
     */
    public function getAction($id) {
        return $this->view($this->findNewsById($id), Response::HTTP_OK);
    }

    /**
     * @Route("/", methods={"POST"}, name="api_news_post")
     */
    public function postAction(Request $request) {
        $form = $this->createForm(NewsType::class);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form);
        }

        /** @var News $item */
        $item = $form->getData();

        $item->setCreated(new \DateTimeImmutable());
        $item->setThumbnail($this->handleFileUpload($form->get(NewsType::THUMBNAIL)->getData()));
        $item->setImage($this->handleFileUpload($form->get(NewsType::IMAGE)->getData()));

        $this->persistNews($item);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id<\d+>}", methods={"POST"}, name="api_news_put")
     */
    public function putAction(Request $request, $id) {
        $item = $this->findNewsById($id);

        $thumbnailValue = $item->getThumbnail();
        $imageValue = $item->getImage();

        $item->setThumbnail($this->fileByName($thumbnailValue));
        $item->setImage($this->fileByName($imageValue));

        $form = $this->createForm(NewsType::class, $item);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form);
        }

        if ($uploadedThumbnail = $form->get(NewsType::THUMBNAIL)->getData()) {
            $thumbnailValue = $this->handleFileUpload($uploadedThumbnail);
        }

        if ($uploadedImage = $form->get(NewsType::IMAGE)->getData()) {
            $imageValue = $this->handleFileUpload($uploadedImage);
        }

        $item->setThumbnail($thumbnailValue);
        $item->setImage($imageValue);

        $this->persistNews($item);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id<\d+>}", methods={"DELETE"}, name="api_news_delete")
     */
    public function deleteAction($id) {
        $this->deleteNewsById($id);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function findNews() {
        return $this->newsService->findAll();
    }

    private function findNewsById($id) {
        try {
            $item = $this->newsService->findById($id);
        }
        catch (NewsNotFound $e) {
            throw new NotFoundHttpException();
        }

        return $item;
    }

    private function persistNews($item) {
        $this->newsService->persist($item);
    }

    private function deleteNewsById($id) {
        try {
            $this->newsService->deleteById($id);
        }
        catch (NewsNotFound $e) {
            throw new NotFoundHttpException();
        }
    }

    private function handleFileUpload($data) {
        return $this->assetService->handleUpload($data);
    }

    private function fileByName($fileName) {
        return $this->assetService->fileByName($fileName);
    }
}

<?php

namespace App\Controller;

use App\Entity\News;
use App\Exception\NewsNotFound;
use App\Form\NewsType;
use App\Service\AssetService;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $now = new \DateTimeImmutable();

        $form = $this->createForm(NewsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var News $item */
            $item = $form->getData();

            $item->setCreated($now);
            $item->setThumbnail($this->assetService->handleUpload($form->get(NewsType::THUMBNAIL)->getData()));
            $item->setImage($this->assetService->handleUpload($form->get(NewsType::IMAGE)->getData()));

            $this->newsService->persist($item);

            return new Response('', Response::HTTP_OK);
        }

        return $this->json($this->extractErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/news/{id<\d+>}", methods={"POST"}, name="put_news_by_id")
     */
    public function newsPut(Request $request, $id) {
        try {
            $item = $this->newsService->findById($id);

            $thumbnailValue = $item->getThumbnail();
            $imageValue = $item->getImage();

            $item->setThumbnail($this->assetService->fileByName($thumbnailValue));
            $item->setImage($this->assetService->fileByName($imageValue));
        }
        catch (NewsNotFound $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(NewsType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($uploadedThumbnail = $form->get(NewsType::THUMBNAIL)->getData()) {
                $thumbnailValue = $this->assetService->handleUpload($uploadedThumbnail);
            }
            if ($uploadedImage = $form->get(NewsType::IMAGE)->getData()) {
                $imageValue = $this->assetService->handleUpload($uploadedImage);
            }

            $item->setThumbnail($thumbnailValue);
            $item->setImage($imageValue);

            $this->newsService->persist($item);

            return new Response('', Response::HTTP_OK);
        }

        return $this->json($this->extractErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function extractErrorsFromForm(FormInterface $form):array {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->extractErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}

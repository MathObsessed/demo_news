<?php

namespace App\Controller;

use App\Exception\NewsNotFound;
use App\Form\NewsType;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        return $this->render('default/form.html.twig', ['item' => $item]);
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
        $now = new \DateTimeImmutable();

        $form = $this->createForm(NewsType::class, null, [
            NewsType::CREATED => $now
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $item->setThumbnail(
                $this->moveUploadedImage($form->get(NewsType::THUMBNAIL)->getData())
            );
            $item->setImage(
                $this->moveUploadedImage($form->get(NewsType::IMAGE)->getData())
            );

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

    private function moveUploadedImage(UploadedFile $file):string {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getParameter('images_upload_directory'), $fileName);

        return $this->getParameter('images_directory').$fileName;
    }
}

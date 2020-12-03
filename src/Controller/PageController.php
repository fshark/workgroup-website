<?php
namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/")
     * @Template("main/start.html.twig")
     */
    public function start(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findLatest();

        return $this->render('main/start.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/contact")
     * @Template("main/contact.html.twig")
     */
    public function contact(): void {}

    /**
     * @Route("/imprint")
     * @Template("main/imprint.html.twig")
     */
    public function imprint(): void {}

    /**
     * @Route("/security")
     * @Template("main/security.html.twig")
     */
    public function security(): void {}
}

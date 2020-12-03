<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news")
     * @param int $page
     * @param int $limit
     * @return Response
     */
    public function list(int $page = 1, int $limit = 8): Response
    {
        setlocale(LC_TIME, 'de_DE');

        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findList($page, $limit);

        return $this->render('news/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{id}")
     * @param int $id
     * @return Response
     */
    public function detail(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findOneById($id);
        return $this->render('news/article.html.twig', [
            'article' => $article,
        ]);
    }
}

<?php
namespace App\Controller;

use App\Entity\Contributor;
use App\Entity\Production;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductionController extends AbstractController
{
    /**
     * @Route("/productions")
     * @return Response
     */
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Production::class);
        $productions = $repository->findList();
        return $this->render('main/productions.html.twig', [
            'productions' => $productions,
        ]);
    }

    /**
     * @Route("/production/{id}")
     * @param int $id
     * @return Response
     */
    public function detail(int $id): Response
    {
        $repoProductions = $this->getDoctrine()->getRepository(Production::class);
        $production = $repoProductions->find($id);
        $more = $repoProductions->findAny(4, $id);

        $repoContributors = $this->getDoctrine()->getRepository(Contributor::class);
        $actors = $repoContributors->findActorsByProduction($id);
        $contributors = $repoContributors->findContributorsByProduction($id);

        return $this->render('main/production.html.twig', [
            'production' => $production,
            'actors' => $actors,
            'contributors' => $contributors,
            'more' => $more,
        ]);
    }
}

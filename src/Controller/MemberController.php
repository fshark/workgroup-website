<?php
namespace App\Controller;

use App\Entity\Contributor;
use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/members")
     * @return Response
     */
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Member::class);
        $members = $repository->findList();
        shuffle($members);

        return $this->render('main/members.html.twig', [
            'members' => $members,
        ]);
    }

    /**
     * @Route("/member/{id}")
     * @param int $id
     * @return Response
     */
    public function detail(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Member::class);
        $member = $repository->find($id);

        $repository = $this->getDoctrine()->getRepository(Contributor::class);
        $actings = $repository->findActorByMemberId($id);
        $contributions = $repository->findContributionsByMemberId($id);

        return $this->render('main/member.html.twig', [
            'member' => $member,
            'actings' => $actings,
            'contributions' => $this->formatContributions($contributions),
        ]);
    }

    /**
     * @param Contributor[] $contributions
     * @return array
     */
    protected function formatContributions(array $contributions): array
    {
        $result = [];

        foreach ($contributions as $contribution) {
            $production = $contribution->getProduction();
            $key = $production->getId();
            if (isset($result[$key])) {
                $result[$key]['roles'][] = $contribution->getRole()->getTitle();
            } else {
                $result[$key] = [
                    'title' => $production->getPlay()->getTitle(),
                    'year' => $production->getYear(),
                    'roles' => [$contribution->getRole()->getTitle()],
                    'link_id' => $production->getId(),
                ];
            }
        }

        return $result;
    }
}

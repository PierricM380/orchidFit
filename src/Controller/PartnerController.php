<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartnerController extends AbstractController
{
    /**
     * this controller display all partner
     * 
     * @param PartnerRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/partenaire', name: 'partner.index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PartnerRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $partners = $paginator->paginate(
            $repository->findAll(), /* query */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/partner/index.html.twig', [
            'partners' => $partners
        ]);
    }

    /**
     * This controller alow to create a partner
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/partenaire/nouveau', name: 'partner.new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();

            $manager->persist($partner);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le partenaire a bien été créé'
            );

            return $this->redirectToRoute('partner.index');
        }

        return $this->render('pages/partner/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allow us to edit a partner
     *
     * @param Partner $partner
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/partenaire/edition/{id}', name: 'partner.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(EntityManagerInterface $manager, Request $request, Partner $partner): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();

            $manager->persist($partner);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le partenaire a bien été modifié'
            );

            return $this->redirectToRoute('partner.index');
        }

        return $this->render('pages/partner/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete a partner
     *
     * @param EntityManagerInterface $manager
     * @param Partner $partner
     * @return Response
     */
    #[Route('/partenaire/suppression/{id}', 'partner.delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(EntityManagerInterface $manager, Partner $structure): Response
    {
        $manager->remove($structure);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le partenaire a bien été supprimé'
        );

        return $this->redirectToRoute('partner.index');
    }
}

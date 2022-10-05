<?php

namespace App\Controller;

use App\Data\SearchPartner;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Form\PartnerStatusType;
use App\Form\SearchPartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire', name: 'partner.index', methods: ['GET'])]
    public function index(PartnerRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $data = new SearchPartner();
        $form = $this->createForm(SearchPartnerType::class, $data);
        $form->handleRequest($request);

        $partners = $paginator->paginate(
            $repository->searchPartner($data), /* query */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/partner/index.html.twig', [
            'partners' => $partners,
            'searchPartnerForm' => $form->createView()
        ]);
    }
    
    /**
     * This controller alow to create a partner
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire/nouveau', name: 'partner.new', methods: ['GET', 'POST'])]
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire/edition/{id}', name: 'partner.edit', methods: ['GET', 'POST'])]
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire/suppression/{id}', 'partner.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Partner $partner): Response
    {
        $manager->remove($partner);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le partenaire a bien été supprimé'
        );

        return $this->redirectToRoute('partner.index');
    }

    /**
     * 
     * This controller allows us to show a partner details
     * @param Partner $partner
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_PARTNER") or (user === partner.getUsers())')]
    #[Route('partenaire/consulter/{id}', name: 'partner.show', methods: ['GET', 'POST'])]
    public function show(Partner $partner, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PartnerStatusType::class, $partner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();

            $manager->persist($partner);
            $manager->flush();
        }
        
        return $this->render('pages/partner/showPartner.html.twig', [
            'partner' => $partner,
            'partnerStatus' => $form->createView()
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Data\SearchStructure;
use App\Form\SearchStructureType;
use App\Form\StructureStatusType;
use App\Repository\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StructureController extends AbstractController
{
    /**
     * this controller display all structures
     * 
     * @param StructureRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/structure', name: 'structure.index', methods: ['GET'])]
    public function index(StructureRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = new SearchStructure();
        $form = $this->createForm(SearchStructureType::class, $data);
        $form->handleRequest($request);

        $structures = $paginator->paginate(
            $repository->searchStructure($data), /* query */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/structure/index.html.twig', [
            'structures' => $structures,
            'searchStructureForm' => $form->createView()
        ]);
    }

    /**
     * This controller alow to create a structure
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/structure/nouveau', name: 'structure.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $structure = $form->getData();

            $manager->persist($structure);
            $manager->flush();

            $this->addFlash(
                'success',
                'La structure a bien été créée'
            );

            return $this->redirectToRoute('structure.index');
        }

        return $this->render('pages/structure/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allow us to edit a structure
     *
     * @param Structure $structure
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/structure/edition/{id}', name: 'structure.edit', methods: ['GET', 'POST'])]
    public function edit(EntityManagerInterface $manager, Request $request, Structure $structure): Response
    {
        $form = $this->createForm(StructureType::class, $structure);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $structure = $form->getData();

            $manager->persist($structure);
            $manager->flush();

            $this->addFlash(
                'success',
                'La structure a bien été modifiée'
            );

            return $this->redirectToRoute('structure.index');
        }

        return $this->render('pages/structure/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete a structure
     *
     * @param EntityManagerInterface $manager
     * @param Structure $service
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/structure/suppression/{id}', 'structure.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        Structure $structure
    ): Response {
        $manager->remove($structure);
        $manager->flush();

        $this->addFlash(
            'success',
            'La structure a bien été supprimée'
        );

        return $this->redirectToRoute('structure.index');
    }

    /**
     * 
     * This controller allows us to show a structure details
     * @param Structure $structure
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Security('is_granted("ROLE_USER") or user === structure.getUsers()')]
    #[Route('structure/consulter/{id}', name: 'structure.show', methods: ['GET', 'POST'])]
    public function show(Structure $structure, Request $request, EntityManagerInterface $manager): Response {
        $formStructureStatus = $this->createForm(StructureStatusType::class, $structure);

        $formStructureStatus->handleRequest($request);
        if ($formStructureStatus->isSubmitted() && $formStructureStatus->isValid()) {
            $structure = $formStructureStatus->getData();

            $manager->persist($structure);
            $manager->flush();
        }

        return $this->render('pages/structure/showStructure.html.twig', [
            'structure' => $structure,
            'structureStatus' => $formStructureStatus->createView(),
        ]);
    }
}

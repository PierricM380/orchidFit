<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Data\SearchService;
use App\Form\SearchServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ServiceController extends AbstractController
{
    /**
     * this controller display all services
     * 
     * @param ServiceRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service', name: 'service.index', methods: ['GET'])]
    public function index(ServiceRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = new SearchService();
        $form = $this->createForm(SearchServiceType::class, $data);
        $form->handleRequest($request);

        $services = $paginator->paginate(
            $repository->searchService($data), /* query */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/service/index.html.twig', [
            'services' => $services,
            'searchServiceForm' => $form->createView()
        ]);
    }

    /**
     * This controller alow to create a service
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/nouveau', name: 'service.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();

            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le service a bien été créé'
            );

            return $this->redirectToRoute('service.index');
        }

        return $this->render('pages/service/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allow us to edit a service
     *
     * @param Service $service
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/edition/{id}', name: 'service.edit', methods: ['GET', 'POST'])]
    public function edit(EntityManagerInterface $manager, Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();

            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le service a bien été modifié'
            );

            return $this->redirectToRoute('service.index');
        }

        return $this->render('pages/service/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete an ingredient
     *
     * @param EntityManagerInterface $manager
     * @param Ingredient $service
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/suppression/{id}', 'service.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        Service $service
    ): Response {
        $manager->remove($service);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le service a bien été supprimé'
        );

        return $this->redirectToRoute('service.index');
    }
}

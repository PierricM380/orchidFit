<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends AbstractController
{
/**
 * this function display all services
 * 
 * @param ServiceRepository $repository
 * @param PaginatorInterface $paginator
 * @param Request $request
 * @return Response
 */
    #[Route('/service', name: 'service.index', methods: ['GET'])]
    public function index(ServiceRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $services = $paginator->paginate(
            $repository->findAll(), /* query */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/service/index.html.twig', [
            'services' => $services
        ]);
    }

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
}

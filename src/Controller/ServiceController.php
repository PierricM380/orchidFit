<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
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
    #[Route('/service', name: 'service', methods: ['GET'])]
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
}

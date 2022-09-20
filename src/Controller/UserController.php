<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/utilisateur', name: 'user.index', methods: ['GET'])]
    public function index(UserRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $repository->findAll(), /* query */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * This controller allow us to register 
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/utilisateur/nouveau', name: 'user.new', methods: ['POST', 'GET'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles([]);
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->addFlash(
                'success',
                'le compte a bien été créé.'
            );

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user.index');
        }

        return $this->render('pages/user/new.html.twig', [
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
    #[Route('/utilisateur/suppression/{id}', 'user.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, User $user): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le compte a bien été supprimé'
        );

        return $this->redirectToRoute('user.index');
    }

    #[Route('/utilisateur/edition-mot-de-passe/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setPlainPassword(
                    $form->getData()['newPassword']
                );

                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'le mot a été modifié'
                );

               return $this->redirectToRoute(('user.index'));
            } else {
                $this->addFlash(
                    'warning',
                    'le mot de passe renseigné est incorrect'
                );
            }
        }

        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

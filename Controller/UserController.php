<?php

declare(strict_types=1);

namespace Ria\Bundle\UserBundle\Controller;

use Ria\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ria\Bundle\UserBundle\Command\User\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class UserController
 * @package Ria\Bundle\UserBundle\Controller
 *
 * @Route("/users", name="users.")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="index")
     * @return Response
     */
    public function index(): Response
    {
        return new Response("<h1>Welcome to users !</h1>");
    }

    /**
     * @Route("/create", methods={"GET, POST"}, name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $command = new CreateUserCommand();
        $form = $this->createForm(UserType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $this->bus->handle($command);
            return $this->redirectToRoute('users.index');
        }

        return $this->render('@RiaUser/users/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
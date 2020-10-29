<?php

declare(strict_types=1);

namespace Ria\Bundle\UserBundle\Controller;

use League\Tactician\CommandBus;
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
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route("/", methods={"GET"}, name="index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('@RiaUser/users/index.html.twig');
    }

    /**
     * @Route("/create", methods={"GET", "POST"}, name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $command = new CreateUserCommand();
        $form = $this->createForm(UserType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->handle($command);
            return $this->redirectToRoute('users.index');
        }

        return $this->render('@RiaUser/users/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
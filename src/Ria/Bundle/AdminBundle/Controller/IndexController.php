<?php
declare(strict_types=1);

namespace Ria\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class IndexController
 * @package Ria\Bundle\AdminBundle\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="admin.index")
     */
    public function index(): Response
    {
        return new Response('<h1>Welcome to the admin panel !</h1>');
    }
}
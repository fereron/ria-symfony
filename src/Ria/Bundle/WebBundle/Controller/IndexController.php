<?php
declare(strict_types=1);

namespace Ria\Bundle\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class IndexController
 * @package Ria\Bundle\WebBundle\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return new Response("<h1>Welcome to the homepage !</h1>");
    }
}
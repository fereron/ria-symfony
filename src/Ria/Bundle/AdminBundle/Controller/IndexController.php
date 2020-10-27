<?php
declare(strict_types=1);

namespace Ria\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index()
    {
        dd('This is main backend page');
    }

}
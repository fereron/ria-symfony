<?php
declare(strict_types=1);

namespace Ria\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        dd('This is main frontend page');
    }

}
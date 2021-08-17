<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ExceptionController extends AbstractController
{
    /**
     * @Route("/exception", name="app_exception")
     */
    public function showException(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('main/404.html.twig');
    }
}

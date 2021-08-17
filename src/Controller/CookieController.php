<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CookieController extends AbstractController
{
    /**
     * @Route("/cookies/", name="cookies")
     * @return Response
     */
    public function index(): Response
    {
        $cookies = $_COOKIE;

        return $this->render('main/cookies.html.twig',
        [
            'cookies' => $cookies
        ]);
    }

}

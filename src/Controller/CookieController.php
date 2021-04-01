<?php

namespace App\Controller;

use App\Entity\ContactDouane;
use App\Form\ContactDouaneFormType;
use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


class CookieController extends AbstractController
{
    /**
     * @Route("/cookies/", name="cookies")
     * @return Response
     */
    public function index()
    {
        $cookies = $_COOKIE;

        return $this->render('main/cookies.html.twig',
        [
            'cookies' => $cookies
        ]);
    }

}

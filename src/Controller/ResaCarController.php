<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ResaCarController extends AbstractController
{
    /**
     * @Route("/resacar/", name="resacar")
     * @return Response
     */
    public function index(): Response
    {

        return $this->render('resacar/index.html.twig');
    }

    /**
     * @Route("/resacar_search/", name="resacar_search")
     * @return Response
     */
    public function searchResult(): Response
    {

        return $this->render('resacar/searchResult.html.twig');
    }

}

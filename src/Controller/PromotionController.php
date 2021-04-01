<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Promotions;
use App\Entity\Range;
use App\Entity\User;
use App\Form\EditPromoFormType;
use App\Form\PromotionFormType;
use App\Form\UserEditFormType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PromotionController extends AbstractController
{
    /**
     * @Route("/index_promotion", name="index_promotion")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Promotions::class);

        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('main/promotions.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/manage_promotion", name="manage_promotion")
     */
    public function managePromo(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Promotions::class);
        $promotions = $repository->findAll();


        return $this->render('admin/manage_promotions.html.twig', [
            'promotions' => $promotions
        ]);
    }

    /**
     * @Route("/create_promotion", name="create_promotion")
     * @param Request $request
     * @return Response
     */
    public function createPromotion(Request $request): Response
    {
        $promo = new Promotions();

        $form = $this->createForm(
            PromotionFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_promotion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_range_promo/{id}", name="create_range_promo")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function createRangePromo(Request $request, $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Range::class);

        $range = $repository->findOneBy(
            ['id' => $id]
        );

        $promo = new Promotions();

        $form = $this->createForm(
            PromotionFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $promo->addRangePromo($range);

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_promotion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_mark_promo/{id}", name="create_mark_promo")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function createMarkPromo(Request $request, $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Mark::class);

        $mark = $repository->findOneBy(
            ['id' => $id]
        );

        $promo = new Promotions();

        $form = $this->createForm(
            PromotionFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $promo->setMark($mark);

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_promotion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit_promo/{id}", name="edit_promo")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editPromo(Request $request, $id): Response
    {
        $promo = $this->getDoctrine()
            ->getRepository(Promotions::class)
            ->find($id);

        $form = $this->createForm(
            EditPromoFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('index_promotion');
        }
        return $this->render('form/edit_promo.html.twig', [
            'promo' =>$promo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_promo/{id}", name="delete_promo")
     * @param $id
     * @return RedirectResponse
     */
    public function deletePromo($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Promotions::class);
        $promo = $repository->find($id);

        $entityManager->remove($promo);
        $entityManager->flush();

        return $this->redirectToRoute('index_promotion');
    }
}

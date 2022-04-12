<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Place;
use App\Entity\PromoCode;
use App\Entity\Promotions;
use App\Entity\Range;
use App\Entity\Newsletter;
use DateTime;
use App\Form\EditPromoCodeFormType;
use App\Form\EditPromoFormType;
use App\Form\PromoCodeFormType;
use App\Form\PromotionFormType;
use App\Form\NewsletterFormType;
use App\Form\PromotionPlaceFormType;
use App\Form\SimplePromoFormType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /**
     * @Route("/promotions", name="promotions")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function Promotion(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Promotions::class);
        $today = new DateTime('@'.strtotime('now'));
        $today_format = $today->format('Y-m-d');

        $pagination = $paginator->paginate(
            $repository->findByDate($today_format),
            $request->query->getInt('page', 1),
            12
        );

        $newsletter = new Newsletter();

        $form_newsletter = $this->createForm(
            NewsletterFormType::class,
            $newsletter);

        $form_newsletter->handleRequest($request);
        if ($form_newsletter->isSubmitted() && $form_newsletter->isValid()) {

            $newsletter->setFollowDate($today);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            $this->addFlash(
                'success',
                'Newsletter suivie'
            );

            return $this->redirectToRoute('promotion');
        }

        return $this->render('main/promotion.html.twig', [
            'pagination' => $pagination,
            'form_newsletter' => $form_newsletter->createView()
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

            $promo->setPlaceDelivery(null);
            $promo->setPlaceDeparture(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            $this->addFlash(
                'success',
                'Promotion ajoutée'
            );

            return $this->redirectToRoute('manage_promotion');
        }

        return $this->render('form/create_promotion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_promotion_place", name="create_promotion_place")
     * @param Request $request
     * @return Response
     */
    public function createPromotionPlace(Request $request): Response
    {
        $promo = new Promotions();

        $form = $this->createForm(
            PromotionPlaceFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            $this->addFlash(
                'success',
                'Promotion ajoutée'
            );

            return $this->redirectToRoute('manage_promotion');
        }

        return $this->render('form/create_promo_place.html.twig', [
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

            $this->addFlash(
                'success',
                'Promotion gamme créé'
            );

            return $this->redirectToRoute('manage_promotion');
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
            SimplePromoFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $promo->setMark($mark);

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            $this->addFlash(
                'success',
                'Promotion marque ajouté'
            );

            return $this->redirectToRoute('manage_promotion');
        }

        return $this->render('form/create_simple_promo.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/create_place_promo/{id}", name="create_place_promo")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function createPlacePromo(Request $request, $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);

        $place = $repository->findOneBy(
            ['id' => $id]
        );

        $promo = new Promotions();

        $form = $this->createForm(
            PromotionFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            $this->addFlash(
                'success',
                'Promotion place ajouté'
            );

            return $this->redirectToRoute('manage_promotion');
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

            $this->addFlash(
                'success',
                'Promotion modifié'
            );

            return $this->redirectToRoute('manage_promotion');
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

        $this->addFlash(
            'success',
            'Promotion supprimé'
        );

        return $this->redirectToRoute('manage_promotion');
    }

    /**
     * @Route("/admin/copyPromo/{id}", name="copyPromo")
     * @param $id
     * @return RedirectResponse
     */
    public function copy($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $originalPromo = $this->getDoctrine()
            ->getRepository(Promotions::class)
            ->find($id);

        $newPromo = clone $originalPromo;

        $entityManager->persist($newPromo);
        $entityManager->flush();

        return $this->redirectToRoute('edit_promo', ['id' => $newPromo->getId()]);
    }

    /**
     * @Route("/admin/create_code_promo", name="create_code_promo")
     * @param Request $request
     * @return Response
     */
    public function codePromo(Request $request): Response
    {
        $codePromo = new PromoCode();

        $form = $this->createForm(
            PromoCodeFormType::class,
            $codePromo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($codePromo);
            $em->flush();

            $this->addFlash(
                'success',
                'Promotion marque ajouté'
            );

            return $this->redirectToRoute('manage_promotion');
        }

        return $this->render('form/promoCode.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/manage_code_promotion", name="manage_code_promotion")
     */
    public function manageCodePromo(): Response
    {
        $repository = $this->getDoctrine()->getRepository(PromoCode::class);
        $promotions = $repository->findAll();


        return $this->render('admin/manage_code_promo.html.twig', [
            'promotions' => $promotions
        ]);
    }

    /**
     * @Route("/admin/edit_promo_code/{id}", name="edit_promo_code")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editPromoCode(Request $request, $id): Response
    {
        $promo = $this->getDoctrine()
            ->getRepository(PromoCode::class)
            ->find($id);

        $form = $this->createForm(
            EditPromoCodeFormType::class,
            $promo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            $this->addFlash(
                'success',
                'Code Promotion modifié'
            );

            return $this->redirectToRoute('manage_code_promotion');
        }
        return $this->render('form/promoCode.html.twig', [
            'promo' =>$promo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_promo_code/{id}", name="delete_promo_code")
     * @param $id
     * @return RedirectResponse
     */
    public function deletePromoCode($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(PromoCode::class);
        $promo = $repository->find($id);
        

        $entityManager->remove($promo);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Code Promotion supprimé'
        );

        return $this->redirectToRoute('manage_promotion');
    }
}

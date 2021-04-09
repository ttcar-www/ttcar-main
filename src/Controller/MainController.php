<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Cars;
use App\Entity\Mark;
use App\Entity\Newsletter;
use App\Entity\Place;
use App\Entity\Price;
use App\Entity\Promotions;
use App\Entity\User;
use App\Form\EditMeUserFormType;
use App\Form\NewsletterFormType;
use App\Repository\BlogRepository;
use App\Service\PriceService;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;



class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param TranslatorInterface $translator
     * @param $request
     * @return Response
     * @throws Exception
     */
    public function index(TranslatorInterface $translator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);
        $today = new \DateTime('@'.strtotime('now'));
        $repository_blog = $this->getDoctrine()->getRepository(Blog::class);
        $repository_promotions = $this->getDoctrine()->getRepository(Promotions::class);

        $posts = $repository_blog->findThreeLast();

        $cars = $repository->findBy(
            ["is_online" => true]
        );
        $cars_promo = [];
        foreach ($cars as $car) {
            $promos = $repository_promotions->findBy(
                ["mark" => $car->getMark()]
            );
            foreach ($promos as $promo) {
                if ($car->getMark() == $promo->getMark()) {
                    array_push($cars_promo, $car);
                }
            }
        }

        $formSearch= $this->getFormSearch($request);

        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $data = $this->getDataSearch($formSearch->getData());
            return $this->redirectToRoute('listing');

        }

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

            return $this->redirectToRoute('main');
        }

        return $this->render('main/index.html.twig', [
            'cars' =>$cars,
            'posts' => $posts,
            'cars_promo' => $cars_promo,
            'form_newsletter' => $form_newsletter->createView(),
            'formSearch' => $formSearch->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return FormInterface
     * @throws Exception
     *
     */
    private function getFormSearch(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('mark_1', ChoiceType::class, [
                'choices' => ['Renault' => 'renault'],
                'expanded' => true,
                'required' => false,
                'multiple' => true,
                'label' => false
            ])
            ->add('mark_2', ChoiceType::class, [
                'choices' => ['Peugeot' => 'peugeot'],
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'required' => false
            ])
            ->add('mark_3', ChoiceType::class, [
                'choices' => ['Citroën' => 'citroen'],
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'required' => false
            ])
            ->add('mark_4', ChoiceType::class, [
                'choices' => ['DS Auto' => 'ds auto'],
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'required' => false
            ])
            ->add('placeDepart', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('date_start', DateType::class, array(
                'widget' => 'single_text',
                'label' => false,
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'datepicker-dateStart'],
                'format' => 'dd/MM/yyyy'
            ))
            ->add('placeReturn', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('date_end', DateType::class, array(
                'widget' => 'single_text',
                'label' => false,
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'datepicker-dateEnd'],
                'format' => 'dd/MM/yyyy'
            ))
            ->add('promo', NumberType::class, array(
                'label' => 'promo',
                'required' => false
            ))

            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return FormInterface
     * @throws Exception
     *
     */
    private function getFormSearchListing(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);

        $placeDepart = $repository->findOneBy(['libelle' => $_SESSION['searchResult']['placeDepart']]);
        $placeReturn = $repository->findOneBy(['libelle' => $_SESSION['searchResult']['placeReturn']]);

        return $this->createFormBuilder()
            ->add('mark', ChoiceType::class, [
                'choices' => [
                    'Renault' => 'Renault',
                    'Peugeot' => 'Peugeot',
                    'Citroën' => 'Citroën',
                    'DS Auto' => 'DS Automobile'
                ],
                'data' => $_SESSION['searchResult']['mark'],
                'required' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('placeDepart', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'data' => $placeDepart,
                'label' => false
            ])
            ->add('date_start', DateType::class, array(
                'label' => false,
                'data' => $_SESSION['searchResult']['dateStart'],
                'widget' => 'single_text'
            ))
            ->add('placeReturn', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'data' => $placeReturn,
                'label' => false
            ])
            ->add('date_end', DateType::class, array(
                'label' => false,
                'data' => $_SESSION['searchResult']['dateEnd'],
                'widget' => 'single_text'
            ))
            ->add('promo', NumberType::class, array(
                'label' => 'promo',
                'required' => false
            ))

            ->getForm();
    }

    /**
     * @return mixed
     * Retourne la différence entre deux date en int
     */
    public function getPriceDeparture()
    {
        $place_depart = $this->getDoctrine()
            ->getRepository(Place::class)
            ->findOneBy(['libelle' => $_SESSION['searchResult']['placeDepart']]);

        $total = $place_depart->getPrice();

        return $total;
    }

    /**
     * @return mixed
     * Retourne la différence entre deux date en int
     */
    public function getPriceReturn()
    {
        $place_return = $this->getDoctrine()
            ->getRepository(Place::class)
            ->findOneBy(['libelle' => $_SESSION['searchResult']['placeReturn']]);

        $total = $place_return->getPrice();

        return $total;
    }

    /**
     * @Route("/listing", name="listing")
     * @param Request $request
     * @param PriceService $PriceService
     * @param PaginatorInterface $paginator
     * @return Response
     * @throws Exception
     */
    public function listingResult(Request $request, PriceService $PriceService, PaginatorInterface $paginator): Response
    {
        $today = new \DateTime('@'.strtotime('now'));
        $nb_days = $this->betdweenDate($_SESSION['searchResult']['dateStart'], $_SESSION['searchResult']['dateEnd']);

        $price_depart = $this->getPriceDeparture();
        $price_return = $this->getPriceReturn();

        $mark_labelle = $this->getMarkSession($_SESSION['searchResult']);

        $mark = $this->getDoctrine()
            ->getRepository(Mark::class)
            ->findOneBy(['libelle' => $mark_labelle]);

        $prices = $this->getDoctrine()
            ->getRepository(Price::class)
            ->findAll();

        $cars = $this->getDoctrine()
            ->getRepository(Cars::class)
            ->findBy(['is_online' => true,
                    'mark' => $mark->getId(),
                    'price' => $prices]
            );

        $pagination = $paginator->paginate(
            $this->getDoctrine()
                ->getRepository(Cars::class)
                ->findBy(['is_online' => true,
                        'mark' => $mark->getId(),
                        'price' => $prices]
                ),
            $request->query->getInt('page', 1),
            10
        );

        $carsResult = [];
        foreach ($cars as $car) {
            $price_car = $PriceService->getPriceOrder($car, $nb_days, $price_depart, $price_return);
            array_push($carsResult, $price_car);
        }

        $formSearch= $this->getFormSearchListing($request);
        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $data = $this->getDataSearch($formSearch->getData());

            return $this->redirectToRoute('listing');

        }


        return $this->render('main/result_listing.html.twig', [
            'cars' => $cars,
            'today' =>$today,
            'pagination' => $pagination,
            'nb_days' => $nb_days,
            'carsResult' => $carsResult,
            'formSearch' => $formSearch->createView()
        ]);
    }

    public function betdweenDate ($date_1, $date_2)
    {
        $interval = $date_1->diff($date_2);

        $days = $interval->format('%a');

        return $days;

    }


    public function getDataSearch($data) {

        $mark_labelle = $this->getMarkSession($data);

        $data = [
            'mark' =>$mark_labelle,
            'dateStart' =>$data['date_start'],
            'dateEnd' =>$data['date_end'],
            'placeDepart' =>$data['placeDepart']->getLibelle(),
            'placeReturn' =>$data['placeReturn']->getLibelle(),
            'promo' =>$data['promo'],
        ];

        $_SESSION['searchResult'] = $data;

        return $data;
    }

    public function getMarkSession($data) {

        if (isset($data['mark_1'])) {
            if ($data['mark_1'] == array('renault')) {
                $mark_labelle = 'Renault';
            }elseif ($data['mark_2'] == array('peugeot')) {
                $mark_labelle = 'Peugeot';
            }elseif ($data['mark_3'] == array('citroen')) {
                $mark_labelle = 'Citroën';
            }else {
                $mark_labelle = 'DS Automobile';
            }
        }else {
            $mark_labelle = $data['mark'];
        }

        return $mark_labelle;
    }


    /**
     * @Route("/groupe", name="groupe")
     * @param $request
     * @return Response
     */
    public function groupe(Request $request): Response
    {

        return $this->render('main/group.html.twig');
    }

    /**
     * @Route("/edit_me/{id}", name="edit_me")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editUser(Request $request, $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $form = $this->createForm(
            EditMeUserFormType::class,
            $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            $this->addFlash(
                'success',
                'Profil edité'
            );

            return $this->redirectToRoute('account');
        }
        return $this->render('form/edit_user_me.html.twig', [
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Manage Range with the front office
     * @Route("/mark_listing", name="mark_listing")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function markListing(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);

        $pagination = $paginator->paginate(
            $repository->findBy(
                ["is_online" => true]
            ),
            $request->query->getInt('page', 1),
            5
        );

        $cars = $repository->findBy(["is_online" => true]);

        return $this->render('main/mark_listing.html.twig', [
            'pagination' =>$pagination,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     * @param $locale
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }

}

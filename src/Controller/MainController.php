<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Cars;
use App\Entity\Mark;
use App\Entity\Newsletter;
use App\Entity\Place;
use App\Entity\PlaceExtra;
use App\Entity\Price;
use App\Entity\Promotions;
use App\Entity\User;
use App\Form\EditMeUserFormType;
use App\Form\NewsletterFormType;
use App\Form\SearchFormType;
use App\Service\PriceService;
use DateTime;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;



class MainController extends AbstractController
{

    /**
     * @Route("/", name="preHome")
     * @param Request $request
     * @return Response
     */
    public function home(Request $request)
    {

        return $this->render('main/preHome.html.twig');
    }


    /**
     * @Route("/home/", name="main")
     * @param TranslatorInterface $translator
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(TranslatorInterface $translator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);
        $today = new DateTime('@'.strtotime('now'));
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

        $formSearch = $this->createForm(SearchFormType::class);

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
     * @Route("/placeAjax/", name="placeAjax")
     * @param Request $request
     * @return Response
     */
    public function ajaxPlace(Request $request)
    {
        $psa = [2, 3, 4];

        if ($request->get('mark') == 1) {
            $places =  $this->getDoctrine()
                ->getRepository(Place::class)
                ->findBy(['id' => 1]);
        }else {
            $places =  $this->getDoctrine()
                ->getRepository(Place::class)
                ->findBy(['id' => $psa]);
        }

       foreach ($places as $place) {
           $output[] = array('id' => $place->getId(),'libelle' => $place->getLibelle());
       }
        return new JsonResponse($output);
    }

    /**
     * @Route("/markAjax/", name="markAjax")
     * @param Request $request
     * @return Response
     */
    public function ajaxMark(Request $request)
    {
        $mark =  $this->getDoctrine()
            ->getRepository(Mark::class)
            ->findOneBy(['id' => $request->get('mark')]);

        $output[] = array('minDate' => $mark->getMinDays(),'maxDate' => $mark->getMaxDays());


        return new JsonResponse($output);
    }

    /**
     * @return FormInterface
     */
    private function getFormSearchListing()
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);

        $placeDepart = $repository->findOneBy(['libelle' => $_SESSION['searchResult']['placeDepart']->getLibelle()]);
        $placeReturn = $repository->findOneBy(['libelle' => $_SESSION['searchResult']['placeReturn']->getLibelle()]);

        return $this->createFormBuilder()
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
                'label' => false,
                'required' => false
            ))

            ->getForm();
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
        $today = new DateTime('@'.strtotime('now'));
        $nb_days = $this->betdweenDate($_SESSION['searchResult']['dateStart'], $_SESSION['searchResult']['dateEnd']);

        $mark_labelle = $this->getMarkSession();

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
            $price_car = $PriceService->getPriceOrder($car, $nb_days);
            array_push($carsResult, $price_car);
        }

        $formSearch= $this->getFormSearchListing();
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

        return $interval->format('%a');

    }


    public function getDataSearch($data) {

        $data = [
            'mark' =>$data['mark'],
            'dateStart' =>$data['date_start'],
            'dateEnd' =>$data['date_end'],
            'placeDepart' =>$data['placeDepart'],
            'placeReturn' =>$data['placeReturn'],
            'promo' =>$data['promo'],
        ];

        $_SESSION['searchResult'] = $data;

        return $data;
    }

    public function getMarkSession() {
        if (isset($_SESSION['searchResult']['mark'])) {
            $mark_session = $_SESSION['searchResult']['mark']->getLibelle();
        }else {
            $mark_session = 'Renault';
        }

        return $mark_session;
    }


    /**
     * @Route("/groupe", name="groupe")
     * @return Response
     */
    public function groupe(): Response
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
     * @Route("/change_mark/", name="change_mark")
     * @param Request $request
     * @return Response
     */
    public function changeMark(Request $request): Response
    {
        $mark = $this->json( $request->get('mark'));
        $_SESSION['searchResult']['Ajaxmark'] = $request->get('mark');

        return $mark;

    }


    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     * @param $locale
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeLocale($locale, Request $request): RedirectResponse
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }

}

<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Entity\Cars;
use App\Entity\Customer;
use App\Entity\Mark;
use App\Entity\Order;
use App\Entity\Place;
use App\Entity\PlaceExtra;
use App\Entity\PromoCode;
use App\Entity\Promotions;
use App\Entity\Range;
use App\Entity\TypePromo;
use App\Entity\User;
use App\Form\OrderFormType;
use App\Form\OrderSimpleFormType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\PriceService;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class OrdersController extends AbstractController
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    /**
     * @Route("/order/{id}", name="order")
     * @param Request $request
     * @param $id
     * @param PriceService $PriceService
     * @param AuthenticationUtils $authenticationUtils
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws Exception
     */
    public function index(Request $request, $id, PriceService $PriceService, AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //Gestion de l'erreur si la session est expiré
        if (empty($_SESSION['searchResult'])) {
            $this->addFlash(
                'notice',
                'Session expiré merci de refaire votre recherche'
            );
           return $this->redirectToRoute('main');
        }

        $car = $this->getDoctrine()
           ->getRepository(Cars::class)
           ->findOneBy(['id' => $id]);

        $mark = $this->getDoctrine()
            ->getRepository(Mark::class)
            ->findOneBy(['id' => $car->getMark()]);

        $range = $this->getDoctrine()
            ->getRepository(Range::class)
            ->findOneBy(['id' => $car->getRanges()]);

        $accessArray = [];
        foreach ($car->getItems() as $item) {
            $access = $this->getDoctrine()
                ->getRepository(Accessory::class)
                ->find($item->getId());
            array_push($accessArray, $access);
        }

            $today = new DateTime('@' . strtotime('now'));

            // Calcule du nombres de jours
            $betweenDate = $this->betdweenDate($_SESSION['searchResult']['dateStart'], $_SESSION['searchResult']['dateEnd']);
            $nb_days = $betweenDate +1;

            //Prix depart / retour
            $price_depart = $this->getPriceDeparture($range->getExtraCost());
            $price_return = $this->getPriceReturn($range->getExtraCost());

            // prix hors promo
            $totalService = $PriceService->getPriceOrder($car, $nb_days);

            //prix avec depart / retour
            $price = $totalService + $price_return + $price_depart;

            //promo
            $promoPrice = $this->getPricePromo($car, $price, $nb_days);
            $promos = null;


        // codePromo
        /*    if (isset($_SESSION['searchResult']['promo'])) {
                $codePromo = $this->getDoctrine()
                    ->getRepository(PromoCode::class)
                    ->findOneBy(['code' => $_SESSION['searchResult']['promo']]);

                if (isset($codePromo)) {
                    switch ($codePromo->getTypePromo()) {
                        case '%':
                           return $price + ($price * ($codePromo->getValue()/100));
                            break;
                        case '€':
                            return $price - $codePromo->getValue();
                            break;
                        case 'Jour':
                           return $nb_days - $codePromo->getValue();
                            break;
                    }
                }
            }*/


        $order = new Order();

            // Utilisateur
            if ($this->getUser()) {
                $user = $this->getDoctrine()
                    ->getRepository(Customer::class)
                    ->findOneBy(['user' => $this->getUser()->getId()]);

                if ($user == null) {
                    $formOrder = $this->createForm(
                        OrderFormType::class,
                        $order);
                } else {
                    $formOrder = $this->createForm(
                        OrderSimpleFormType::class,
                        $order);
                }
            } else {

                $user = null;
                $formOrder = $this->createForm(
                    OrderFormType::class,
                    $order);
            }

            //form Order
            $formOrder->handleRequest($request);
            if ($formOrder->isSubmitted() && $formOrder->isValid()) {

                $_SESSION['orderId'] = $formOrder->get('id')->getData();

                $order->setCarLibelle($car->getName());
                $order->setCreateDate($today);
                $order->setDepartPlace($_SESSION['searchResult']['placeDepart']->getlibelle());
                $order->setDepartPrice($price_depart);
                $order->setDepartDate($_SESSION['searchResult']['dateStart']);
                $order->setReturnPlace($_SESSION['searchResult']['placeReturn']->getlibelle());
                $order->setReturnPrice($price_return);
                $order->setReturnDate($_SESSION['searchResult']['dateEnd']);
                $order->setBasicPrice($price);
                $order->setPromotions($promoPrice);
                $order->setPrice($price);
                $order->setItems($_SESSION['itemsOrder'] ?? null);
                $order->setCountItems($_SESSION['countItems'] ?? null);
                $order->setLang($request->getLocale());
                $order->setCountDays($nb_days);
                $order->setMark($mark->getLibelle());
                if ($promos != null) {
                    $order->setPromoLibelle($promos->getLibelle());
                }else {
                    $order->setPromoLibelle('null');
                }

                if ($user) {
                    $order->setCustomerName($user->getName());
                    $order->setCustomerType('null');
                    $order->setCustomerUsername($user->getUsername());
                    $order->setAdress($user->getAdressUe());
                    $order->setCity($user->getAdressCity());
                    $order->setPostalCode($user->getAdressCode());
                    $order->setCountry($user->getAdressCountry());
                    $order->setPhone($user->getPhone());
                    $order->setNationality($user->getNationality());
                    $order->setBirthDate($user->getBirthdaysDate());
                    $order->setBirthPostal($user->getAdressCode());
                    $order->setBirthCity($user->getAdressUe());
                    $order->setBirthCountry($user->getCountryBirth());
                    $order->setReason($user->getReason());
                    $order->setPassportNumber($user->getNumberPiece());
                    $order->setPassportDate($user->getDatePiece());
                    $order->setPassportPlace($user->getDeliveryPiece());
                    $order->setEmail($user->getEmail());
                    $order->setAdressNoUe($user->getAdressNoUe());
                    $order->setAdressCountryHue($user->getAdressCountryHue());
                    $order->setAdressCityHue($user->getAdressCityHue());
                    $order->setAdressCodeHue($user->getAdressCodeHue());
                    $order->setProfession($user->getProfession());
                }else {
                    $order->setPassword($formOrder->get('plainPassword')->getData());
                }


                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                return $this->redirect($this->generateUrl('createOrder', array(
                    'id' => $order->getId()
                )));
            }

            // Connexion
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/order.html.twig', [
          'car' => $car,
          'nb_days' => $nb_days,
          'promos' => $promos,
          'promoPrice' => $promoPrice,
          'user' => $user,
          'accessArray' => $accessArray,
          'id' => $id,
          'price_depart'=> $price_depart,
          'price_return'=> $price_return,
          'price' =>$price,
          'last_username' => $lastUsername,
          'error' => $error,
          'formOrder' => $formOrder->createView()
      ]);
  }

    /**
     * @param $id
     * @return object|null
     * Calcule des promotions
     */
    public function getPromoOrder($id): ?array
    {
        /*       $promotions = $this->getDoctrine()
                   ->getRepository(Promotions::class)
                   ->findBy(['mark' => $id]);

               foreach ($promotions as $promo) {
                   if ($promo->getStartDate() <= $_SESSION['searchResult']['dateStart'] and $promo->getEndDate() >= $_SESSION['searchResult']['dateEnd']) {
                       $promotions = $promo;
                   }
               }*/

        return null;
    }

    /**
     * @param $car
     * @param $price
     * @param $nb_day
     * @return float|int|object|null
     * Calcule des promotions
     */
    public function getPricePromo($car, $price, $nb_day)
    {
        $promotionsMark = $this->getDoctrine()
            ->getRepository(Promotions::class)
            ->findBy(['mark' => $car->getMark()->getId()]);

        $promoRange = $this->getDoctrine()
            ->getRepository(Range::class)
            ->findBy(['id' => $car->getRanges()->getId()]);

        if (isset($promotionsMark)) {
            // 1. promotions sur marque OK

            foreach ( $promotionsMark as $promo ) {

                if ($promo->getStartDelivery() <= $_SESSION['searchResult']['dateStart'] and $promo->getEndDelivery() >= $_SESSION['searchResult']['dateEnd']) {
                    if ($promo->getType()->getType() == 'Jour' and $nb_day < 21) {
                        return $this->getCounDays($promo, $nb_day);
                    } else {
                        return $this->getType($promo, $price);
                    }
                }
            }
        } elseif ( isset( $promoRange) ) {
            // 2. promotions sur gammes OK

            foreach ( $promoRange as $itemRange) {
                if ($itemRange->getStartDelivery() <= $_SESSION['searchResult']['dateStart'] and $itemRange->getEndDelivery() >= $_SESSION['searchResult']['dateEnd']) {

                    foreach ($itemRange->getPromotions() as $rangePromo ) {
                        if ($rangePromo->getType()->getType() == 'Jour' and $nb_day < 21) {
                            return $this->getCounDays($promo, $nb_day);
                        }else {
                            return $this->getType($rangePromo, $price);
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param $operator
     * @return string|null
     */
    public function getOperators($operator) {

        $operator_calcul = null;
        switch ($operator) {
            case '<':
                return '<';
            case '>':
                return '>';
            case '≥':
                return '>=';
            case '≤':
                return '=<';
        }
    }


    /**
     * @param $type
     * @param $price
     * @return float|int|void
     */
    public function getType($promo, $price) {

        switch ($promo->getType()->getType()) {
            case '€':
                return $price - $promo->getValue();
            case '%':
                return $price - $price*($promo->getValue()/100);
        }
    }


    /**
     * @param $countDays
     * @param $car
     * @return mixed
     * Retourne le nombres de jours en cas de promotions
     */
    public function getCounDays($nb_day, $promo) {
        $countDays = $countDays - $promo->getValue();
        if ($countDays > 21 ) {
            return 21;
        }
        return $countDays;
    }

    /**
     * @param $slices
     * @return object|null
     * Calcule des slices
     */
    public function getPriceBySlice($slices): ?object
    {
        $price = null;

        foreach ($slices as $slice) {
            return $slice->getValue();
        }

        return $price;
    }

    /**
     * @param $date_1
     * @param $date_2
     * @return mixed
     * Retourne la différence entre deux date en int
     */
    public function betdweenDate ($date_1, $date_2)
    {
        $interval = $date_1->diff($date_2);

        return $interval->format('%a');
    }

    /**
     * @param $extra
     * @return mixed
     * Retourne la différence entre deux date en int
     */
    public function getPriceDeparture($extra)
    {
        $place_depart = $this->getDoctrine()
            ->getRepository(Place::class)
            ->findOneBy(['libelle' => $_SESSION['searchResult']['placeDepart']->getLibelle()]);

        $extraPlaces = $this->getDoctrine()->getRepository(PlaceExtra::class)->findBy(['deleted_at' => null]);
        $priceExtra = 0;

        foreach ($extraPlaces as $justPlace) {
            if ($justPlace->getFree()) {
                return 0;
            } else {
                $placeMany = $justPlace->getPlace();
                foreach ($placeMany as $onePlace) {
                    if ($onePlace->getLibelle() == $place_depart->getLibelle()) {
                        foreach ($onePlace->getPlace() as $extraCost) {
                            if ($extra == true) {
                                $priceExtra = $extraCost->getExtra1();
                            }else {
                                $priceExtra = $extraCost->getExtra2();
                            }
                        }
                    }
                }
            }
        }

        return $priceExtra;
    }

    /**
     * @param $extra
     * @return mixed
     * Retourne la différence entre deux date en int
     */
    public function getPriceReturn($extra)
    {
        $place_return = $this->getDoctrine()
            ->getRepository(Place::class)
            ->findOneBy(['libelle' => $_SESSION['searchResult']['placeReturn']->getLibelle()]);

        $extraPlaces = $this->getDoctrine()->getRepository(PlaceExtra::class)->findBy(['deleted_at' => null]);
        $priceExtra = 0;

        foreach ($extraPlaces as $justPlace) {
            if ($justPlace->getFree()) {
                return 0;
            } else {
                $placeMany = $justPlace->getPlace();
                foreach ($placeMany as $onePlace) {
                    if ($onePlace->getLibelle() == $place_return->getLibelle()) {
                        foreach ($onePlace->getPlace() as $extraCost) {
                            if ($extra == true) {
                                $priceExtra = $extraCost->getExtra1();
                            }else {
                                $priceExtra = $extraCost->getExtra2();
                            }
                        }
                    }
                }
            }
        }
        return $priceExtra;
    }

    /**
     * @Route("/priceAjax/", name="priceAjax")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxAction(Request $request): JsonResponse
    {
        $ajaxPrice = $this->json( $request->get('price'));

        $_SESSION['priceOrder'] = $request->get('price');

        return $ajaxPrice;

    }


    /**
     * @Route("/itemsAjax/", name="itemsAjax")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxItems(Request $request): JsonResponse
    {
        $ajaxLibelle = $this->json( $request->get('libelleItems'));

        $_SESSION['itemsOrder'] = $request->get('libelleItems');

        return $ajaxLibelle;

    }

    /**
     * @Route("/countItemAjax/", name="countItemAjax")
     * @param Request $request
     * @return JsonResponse
     */
    public function countItemAjax(Request $request): JsonResponse
    {
        $countItems = $this->json( $request->get('countItem'));

        $_SESSION['countItems'] = $request->get('countItem');

        return $countItems;

    }

    /**
     * @Route("/newCustomer/", name="newCustomer")
     * @param $order
     * @return Customer|null
     * @throws Exception
     */
    public function newUser($order): ?Customer
    {
        $today = new DateTime('@'.strtotime('now'));

        $newCustomer = null;

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $order->getEmail()]);

        if (!isset($user)) {
            $newUser = new User();

            $newUser->setEmail($order->getEmail());
            $newUser->setUsername($order->getCustomerUsername());
            $newUser->setCreateAt($today);
            $newUser->setRoles(['ROLE_USER']);
            $newUser->setIsVerified(false);
            $newUser->setPassword($this->passwordEncoder->encodePassword(
                $newUser,
                $order->getPassword()
            ));

            $newCustomer = $this->newCustomer($newUser, $order);
        }


        //envoi email creation compte
        return $newCustomer;

    }

    /**
     * @Route("/newCustomer/", name="newCustomer")
     * @param $newUser
     * @param $order
     * @return Customer|null
     * @throws Exception
     */
    public function newCustomer($newUser, $order): ?Customer
    {
        $newCustomer = null;

        if ($newUser) {
            $newCustomer = new Customer();

            $newCustomer->setEmail($order->getEmail());
            $newCustomer->setCustomerType($order->getCustomerType());
            $newCustomer->setName($order->getCustomerName());
            $newCustomer->setUsername(($order->getCustomerUsername()));
            $newCustomer->setAdressUe($order->getAdress());
            $newCustomer->setAdressCity($order->getCity());
            $newCustomer->setAdressCode($order->getPostalCode());
            $newCustomer->setAdressCountry($order->getCountry());
            $newCustomer->setPhone($order->getPhone());
            $newCustomer->setNationality($order->getNationality());
            $newCustomer->setBirthdaysDate($order->getBirthDate());
            $newCustomer->setCountryBirth($order->getBirthCountry());
            $newCustomer->setBirthPostal($order->getBirthPostal());

            $newCustomer->setPiceIdentity('Passport');
            $newCustomer->setAdressNoUe($order->getAdressNoUe());
            $newCustomer->setAdressCodeHue($order->getAdressCodeHue());
            $newCustomer->setAdressCountryHue($order->getAdressCountryHue());
            $newCustomer->setAdressCityHue($order->getAdressCityHue());

            $newCustomer->setReason($order->getReason());
            $newCustomer->setNumberPiece($order->getPassportNumber());
            $newCustomer->setDatePiece($order->getPassportDate());
            $newCustomer->setDeliveryPiece($order->getPassportPlace());
            if ($order->getCustomerOldName()) {
                $newCustomer->setNameYoung($order->getCustomerOldName());
            }else {
                $newCustomer->setNameYoung('NULL');
            }
            $newCustomer->setProfession($order->getProfession());

            $newCustomer->setUser($newUser);
            $newUser->setIsCustomer(true);
            $order->setPassword('NULL');

            $em = $this->getDoctrine()->getManager();
            $em->persist($newCustomer);
            $em->persist($newUser);
            $em->persist($order);

            $em->flush();

        }
        return $newCustomer;
    }

    /**
     * @Route("/createOrder/{id}", name="createOrder")
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function createOrder($id): Response
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy(['id' => $id]);

        $betweenDate = $this->betdweenDate($_SESSION['searchResult']['dateStart'], $_SESSION['searchResult']['dateEnd']);
        $nb_days = $betweenDate +1;

        if (isset($_SESSION['priceOrder'])) {
            $order->setPrice($_SESSION['priceOrder']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
        }

        $user = $this->newUser($order);

        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        } else {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $order->getEmail()]);
        }


        return $this->render('/main/paiement.html.twig',
            [
                'user' => $user,
                'order' => $order,
                'nb_days' => $nb_days
            ]);

    }

}

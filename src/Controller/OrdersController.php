<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Entity\Cars;
use App\Entity\Country;
use App\Entity\Customer;
use App\Entity\Mark;
use App\Entity\Order;
use App\Entity\Place;
use App\Entity\Promotions;
use App\Entity\TypePromo;
use App\Entity\User;
use App\Form\OrderFormType;
use App\Form\OrderSimpleFormType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(Request $request, $id, PriceService $PriceService, AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $passwordEncoder)
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
                ->find($id);

        $mark = $this->getDoctrine()
            ->getRepository(Mark::class)
            ->findOneBy(['id' => $car->getMark()]);

        $accessArray = [];
        foreach ($car->getItems() as $item) {
            $access = $this->getDoctrine()
                ->getRepository(Accessory::class)
                ->find($item->getId());
            array_push($accessArray, $access);
        }

            $today = new \DateTime('@' . strtotime('now'));

            // Calcule du nombres de jours
            $betweenDate = $this->betdweenDate($_SESSION['searchResult']['dateStart'], $_SESSION['searchResult']['dateEnd']);
            $nb_days = $betweenDate +1;
            //Prix depart retour
            $price_depart = $this->getPriceDeparture();
            $price_return = $this->getPriceReturn();

            $price = $PriceService->getPriceOrder($car, $nb_days, $price_depart, $price_return);

            //promo
            $promos = $this->getPromoOrder($car->getMark());
            $promoPrice = $this->getPricePromo($car->getMark(), $price);
            $user = null;

            $order = new Order();

            // Utilisateur
            if ($this->getUser()) {
                $user = $this->getDoctrine()
                    ->getRepository(Customer::class)
                    ->findOneBy(['user' => $this->getUser()->getId()]);

                $formOrder = $this->createForm(
                    OrderSimpleFormType::class,
                    $order);

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
                $order->setDepartPlace($_SESSION['searchResult']['placeDepart']);
                $order->setDepartPrice($price_depart);
                $order->setDepartDate($_SESSION['searchResult']['dateStart']);
                $order->setReturnPlace($_SESSION['searchResult']['placeReturn']);
                $order->setReturnPrice($price_return);
                $order->setReturnDate($_SESSION['searchResult']['dateEnd']);
                $order->setBasicPrice($price);
                $order->setPromotions($promoPrice);
                $order->setPrice($price);
                $order->setItems(isset($_SESSION['itemsOrder']) ? $_SESSION['itemsOrder']: null);
                $order->setCountItems(isset($_SESSION['countItems']) ? $_SESSION['countItems']: null);
                $order->setLang($request->getLocale());
                $order->setCountDays($nb_days);
                $order->setMark($mark->getLibelle());
                $order->setPromoLibelle($promos->getLibelle());

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
          'user' => $user,
          'accessArray' => $accessArray,
          'id' => $id,
          'price_depart'=> $price_depart,
          'price_return'=> $price_return,
          'price' =>$promoPrice,
          'last_username' => $lastUsername,
          'error' => $error,
          'formOrder' => $formOrder->createView()
      ]);
  }

    /**
     * @param $car
     * @param $price
     * @return object|null
     * Calcule des promotions
     */
    public function getPricePromo($car, $price) {

        $promotions = $this->getPromoOrder($car);

        if (empty($promotions)) {

            return $price;
        }

                $type = $this->getDoctrine()
                    ->getRepository(TypePromo::class)
                    ->findOneBy(['id' => $promotions->getId()]);

                switch ($type->getType()) {
                    case 'Euros':
                        $price = $price - $promotions->getValue();
                        return $price;
                        break;
                    case '%':
                        $price = $price - $price*($promotions->getValue()/100);
                        return $price;
                        break;
                }
                return $price;
    }

    /**
     * @param $operator
     * @return string|null
     */
    public function getOperators($operator) {

        $operator_calcul = null;
        switch ($operator) {
            case '<':
                $operator_calcul = '<';
                return $operator_calcul;
                break;
            case '>':
                $operator_calcul = '>';
                return $operator_calcul;
                break;
            case '≥':
                $operator_calcul = '>=';
                return $operator_calcul;
                break;
            case '≤':
                $operator_calcul = '=<';
                return $operator_calcul;
                break;
        }
    }

    /**
     * @param $slices
     * @return object|null
     * Calcule des slices
     */
    public function getPriceBySlice($slices) {
        $price = null;

        foreach ($slices as $slice) {
            $price = $slice->getValue();
            return $price;
        }


        return $price;
    }

    /**
     * @param $countDays
     * @param $car
     * @return mixed
     * Retourne le nombres de jours en cas de promotions
     */
    public function getCounDays($countDays, $car) {
        $promotions = $this->getPromoOrder($car);

        foreach ($promotions as $promo) {
            $type = $this->getDoctrine()
                ->getRepository(TypePromo::class)
                ->findOneBy(['id' => $promo->getType()]);

            if ($type->getType() == 'Jours' and $countDays < 21) {
                $countDays = $countDays - $promo->getValue();
            }

        }

        return $countDays;
    }

    /**
     * @param $id
     * @return object|null
     * Calcule des promotions
     */
    public function getPromoOrder($id) {

        $promotions = $this->getDoctrine()
            ->getRepository(Promotions::class)
            ->findBy(['mark' => $id]);

        foreach ($promotions as $promo) {
            if ($promo->getStartDate() <= $_SESSION['searchResult']['dateStart'] and $promo->getEndDate() >= $_SESSION['searchResult']['dateEnd']) {
                $promotions = $promo;
            }
        }

        return $promotions;
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

        $days = $interval->format('%a');

        return $days;
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
     * @param $car
     * @param $day_count
     * @return float|int|null
     * Calcule le prix hors promotion
     */
    public function getPriceOrder($car, $day_count)
    {
        $total = null;
        $slices = ($car->getPrice()->getSlices()) ? $car->getPrice()->getSlices() : null;
        $price = $car->getPrice()->getPrice();

        // Adition des prix par rapport au lieux de départ et retour
        $total_place = $this->getPriceDeparture() + $this->getPriceReturn();

        $margin = $car->getMargin();

        if ($day_count < 21){
            //Prix sans marge
            $total = $price + $total_place;

            if ($car->getPrice()->getLibelle() == 2) {
                // Prix avec marge
                $total = $price + $price*($margin/100) + $total_place;
            }

        }elseif ($day_count > 21 AND isset($slices)) {
            //Prix avec tranches appliquées
            $days = $day_count - 21;

            foreach ($slices as $slice) {
                $operator = $this->getOperators($slice->getOperators());
                if ($day_count.$operator.$slice->getDaysMin()) {
                    $day_price = $this->getPriceBySlice($slices);

                    //Prix sans marge
                    $total = $price + $day_price * $days + $total_place;

                    if ($car->getPrice()->getLibelle() == 2) {
                        // Prix avec marge
                        $total = $total + $price*($margin/100);
                    }
                }
            }
        }

        return $total;
    }


    /**
     * @Route("/priceAjax/", name="priceAjax")
     * @param Request $request
     * @return bool|Response
     */
    public function ajaxAction(Request $request)
    {
        $ajaxPrice = $this->json( $request->get('price'));

        $_SESSION['priceOrder'] = $request->get('price');

        return $ajaxPrice;

    }


    /**
     * @Route("/itemsAjax/", name="itemsAjax")
     * @param Request $request
     * @return bool|Response
     */
    public function ajaxItems(Request $request)
    {
        $ajaxLibelle = $this->json( $request->get('libelleItems'));

        $_SESSION['itemsOrder'] = $request->get('libelleItems');

        return $ajaxLibelle;

    }

    /**
     * @Route("/countItemAjax/", name="countItemAjax")
     * @param Request $request
     * @return bool|Response
     */
    public function countItemAjax(Request $request)
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
    public function newUser($order)
    {
        $today = new \DateTime('@'.strtotime('now'));

        $newUser = null;
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
    public function newCustomer($newUser, $order)
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
     * @return bool|Response
     * @throws Exception
     */
    public function createOrder($id)
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

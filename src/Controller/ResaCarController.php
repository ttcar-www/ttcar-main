<?php

namespace App\Controller;

use App\Entity\CategoryResacar;
use App\Entity\StationsResacar;
use App\ResacarApi\Booking\BookingManager;
use App\ResacarApi\Booking\DeleveryAddressesManager;
use App\ResacarApi\Data\AccountsManager;
use App\ResacarApi\Data\CarsByDisponibilitiesManager;
use App\ResacarApi\Data\CarsManager;
use App\ResacarApi\Data\OpeningHoursManager;
use App\ResacarApi\Data\StationsManager;
use DateTime;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ResaCarController extends AbstractController
{
    /**
     * @Route("/resacar/", name="resacar")
     * @param StationsManager $stationManager
     * @param CarsManager $carsManager
     * @param CarsByDisponibilitiesManager $carsByDisponibilityManager
     * @param OpeningHoursManager $openingHoursManager
     * @param AccountsManager $accountsManager
     * @param DeleveryAddressesManager $deleveryAddressesManager
     * @param BookingManager $bookingManager
     * @return Response
     */
    public function index(
        StationsManager $stationManager,
        CarsManager $carsManager,
        CarsByDisponibilitiesManager $carsByDisponibilityManager,
        OpeningHoursManager $openingHoursManager,
        AccountsManager $accountsManager,
        DeleveryAddressesManager $deleveryAddressesManager,
        BookingManager $bookingManager
    ): Response
    {

     //   $bookingManager->setFilter($filter);
     //   $reservation = $bookingManager->getResult();
       // var_dump($carsByDisponibilityManager);die();

        /**
         * EXEMPLE GET STATIONS LIST
         */
        $filter = [
            'country_id' => 'FR'
        ];
        $stationManager->setFilter($filter);
        $stations = $stationManager->getResult();


        /**
         * EXEMPLE GET VEHICULES LIST
         */
        $filter = [
            'station_id' => 'PUFE01'
        ];
        $carsManager->setFilter($filter);
   //     $cars = $carsManager->getResult();

        /**
         * EXEMPLE GET VEHICULES LIST BY DISPONIBILITY
         */
        $filter = [
            'station_id' => 'PUFE01',
            'date_pickup' => '10032022',
            'heure_pickup' => '0930',
            'date_return' => '16032022',
            'heure_return' => '1600',
            'veh_class' => 'T',
            'invoice_type' => 'S',
        ];
        $carsByDisponibilityManager->setFilter($filter);
      //  $carsByDisponibility = $carsByDisponibilityManager->getResult();

        /**
         * EXEMPLE GET OPENING HOURS
         */
        $filter = [
            'station_id' => 'PUFE01'
        ];
        $openingHoursManager->setFilter($filter);
  //      $hours = $openingHoursManager->getResult();


        /**
         * EXEMPLE GET DELEVERY ADDRESSES
         */
    //    $addresses = $deleveryAddressesManager->getResult();

        /**
         * EXEMPLE GET ACCOUNTS
         */
        $accounts = $accountsManager->getResult();

        $categories = $this->getDoctrine()
            ->getRepository(CategoryResacar::class)
            ->findAll();


        return $this->render('resacar/index.html.twig', [
            'stations' => $stations,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/resacar/find-stations", name="resacar_find_stations")
     * @param StationsManager $stationManager
     * @return JsonResponse
     */
    public function findStations(StationsManager $stationManager, OpeningHoursManager $openingHoursManager): JsonResponse
    {

        $filter = [
            'country_id' => 'FR'
        ];
        $stationManager->setFilter($filter);
        $stations = $stationManager->getResult();


        return new JsonResponse($stations);
    }

    /**
     * @Route("/searchResacar/", name="searchResacar")
     * @param Request $request
     * @return JsonResponse
     */
    public function orderAction(Request $request, OpeningHoursManager $openingHoursManager): JsonResponse
    {
        $startStation = $this->json( $request->get('stationStart'));
        $returnStation = $this->json( $request->get('stationEnd'));
        $departDate = $this->json( $request->get('dateStart'));
        $returnDate = $this->json( $request->get('dateEnd'));
        $plane = $this->json( $request->get('numberPlane'));
        $type = $this->json( $request->get('typeSelect'));

        $data = [
            'startStation' => $startStation,
            'returnStation' => $returnStation,
            'departDate' => $departDate,
            'returnDate' => $returnDate,
            'plane' => $plane,
            'type' => $type,
        ];

        $_SESSION['resaCarStationDepart'] = $request->get('stationStart');
        $_SESSION['resaCarStationEnd'] = $request->get('stationEnd');
        $_SESSION['resaCarDateStart'] = $request->get('dateStart');
        $_SESSION['resaCarDateEnd'] = $request->get('dateEnd');
        $_SESSION['resaCarPlane'] = $request->get('numberPlane');
        $_SESSION['tresaCarTpe'] = $request->get('typeSelect');

        $response = $this->checkSation($openingHoursManager, $request->get('stationStart'), $request->get('stationEnd'), $request->get('dateStart'), $request->get('dateEnd'));

        if ($response == false ) {
            return new JsonResponse(false);
        }else{
            $data = $this->generateUrl('resacar_search');
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/resacar_search/", name="resacar_search")
     * @param CarsManager $carsManager
     * @return Response
     */
    public function searchResult(CarsByDisponibilitiesManager $carsByDisponibilityManager, PaginatorInterface $paginator, Request $request): Response
    {

        /**
         * EXEMPLE GET VEHICULES LIST BY DISPONIBILITY
         */
        $filter = [
            'station_id' => 'PUFE01',
            'date_pickup' => '10032022',
            'heure_pickup' => '0930',
            'date_return' => '21032022',
            'heure_return' => '1600',
            'veh_class' => 'T',
            'invoice_type' => 'S',
        ];
        $carsByDisponibilityManager->setFilter($filter);
        $cars = $carsByDisponibilityManager->getResult();



        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('resacar/searchResult.html.twig',[
            'cars' => $cars,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/resacar_order/", name="resacar_order")
     * @return Response
     */
    public function orderResacar(): Response
    {


        return $this->render('resacar/order.html.twig');
    }

    /**
     * @Route("/check_station/{stationStart}/{stationEnd}/{dateStart}/{dateEnd}", name="check_station")
     * @return false
     * @throws Exception
     */
    public function checkSation($openingHoursManager, $stationStart, $stationEnd, $dateStart, $dateEnd): bool
    {
        $filter = ['station_id' => $stationStart];

        $openingHoursManager->setFilter($filter);
        $openTo = $openingHoursManager->getResult();

        $dateHours = explode("T", $dateStart);
        $dateStart = $dateHours[0];
        $hoursStart = $dateHours[1];

        foreach ($openTo as  $hour) {


          $depart =  new \DateTime($dateStart);

            $years = substr($hour['date_min'], 4);
            $month = substr($hour['date_min'], 2, 2);
            $day = substr($hour['date_min'], 0, 2);

            $dateToOpen = \DateTime::createFromFormat("d/m/Y", $day."/".$month."/".$years);


            if (isset($hour['hour_min'])) {
              if ($depart->format('Y-m-d') < $dateToOpen->format('Y-m-d') && $hour['hour_min'] < $hoursStart) {
                  return $response = true;
              }
          } else {

              if ($depart->format('Y-m-d') < $dateToOpen->format('Y-m-d')) {
                  return $response = true;
              }
          }

        }

        return $response = false;
    }

}

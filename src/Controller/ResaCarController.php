<?php

namespace App\Controller;

use App\ResacarApi\Booking\BookingManager;
use App\ResacarApi\Booking\DeleveryAddressesManager;
use App\ResacarApi\Data\AccountsManager;
use App\ResacarApi\Data\CarsByDisponibilitiesManager;
use App\ResacarApi\Data\CarsManager;
use App\ResacarApi\Data\OpeningHoursManager;
use App\ResacarApi\Data\StationsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
            'date_pickup' => '10012022',
            'heure_pickup' => '0930',
            'date_return' => '16012022',
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

        return $this->render('resacar/index.html.twig', [
            'stations' => $stations
        ]);
    }

    /**
     * @Route("/resacar/find-stations", name="resacar_find_stations")
     * @param StationsManager $stationManager
     * @return JsonResponse
     */
    public function findStations(StationsManager $stationManager): JsonResponse
    {
        $filter = [
            'country_id' => 'FR'
        ];
        $stationManager->setFilter($filter);
        $stations = $stationManager->getResult();
        return new JsonResponse($stations);
    }

    /**
     * @Route("/resacar_search/", name="resacar_search")
     * @return Response
     */
    public function searchResult(): Response
    {

        return $this->render('resacar/searchResult.html.twig');
    }

    /**
     * @Route("/resacar_order/", name="resacar_order")
     * @return Response
     */
    public function orderResacar(): Response
    {

        return $this->render('resacar/order.html.twig');
    }

}

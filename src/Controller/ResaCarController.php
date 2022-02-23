<?php

namespace App\Controller;

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

        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/resacar_search/", name="resacar_search")
     * @param OpeningHoursManager $openingHoursManager
     * @return Response
     * @throws Exception
     */
    public function searchResult(OpeningHoursManager $openingHoursManager): Response
    {
        $filter = [
            'station_id' => $_SESSION['resaCarStationDepart']
        ];
        $openingHoursManager->setFilter($filter);
        $openTo = $openingHoursManager->getResult();

        $dateHours = explode("T", $_SESSION['resaCarDateStart']);
        $dateStart = $dateHours[0];
        $hoursStart = $dateHours[1];

        foreach ($openTo as  $hour) {

          $depart =  new \DateTime($dateStart);

            var_dump($hour['date_min']); die();

          $resacar = new \DateTime($hour['date_max']);

          var_dump($depart->format('Y-m-d'), $resacar->format('Y-m-d'));
          die();
          if ($depart->format('Y-m-d') < $resacar->format('Y-m-d')) {
              var_dump('ok slothie');
          }


        }die();

        return $this->render('resacar/searchResult.html.twig');
    }

    /**
     * @Route("/resacar_order/", name="resacar_order")
     * @return Response
     */
    public function orderResacar(StationsManager $stationManager, OpeningHoursManager $openingHoursManager): Response
    {
        $today = new \DateTime();

        $filter = [
            'country_id' => 'FR'
        ];
        $stationManager->setFilter($filter);
        $stations = $stationManager->getResult();

        $result = [];


        foreach ($stations as $station) {
            $filter = ['station_id' => $station['station_id']];
            $openingHoursManager->setFilter($filter);

            $openTo = $openingHoursManager->getResult();
            $self = false;

            foreach ($openTo as  $open) {

                $yearsOpen = substr($open['date_min'], 4);
                $monthOpen = substr($open['date_min'], 2, 2);
                $dayOpen = substr($open['date_min'], 0, 2);

                $yearsEnd = substr($open['date_max'], 4);
                $monthEnd = substr($open['date_max'], 2, 2);
                $dayEnd = substr($open['date_max'], 0, 2);

                $dateMin = \DateTime::createFromFormat("d/m/Y", $dayOpen."/".$monthOpen."/".$yearsOpen);
                $dateMax = \DateTime::createFromFormat("d/m/Y", $dayEnd."/".$monthEnd."/".$yearsEnd);

                if ($dateMin->format('d-m-Y') > $today->format('d-m-Y')) {
                    if ($open['self_service'] !== 'N') {
                        $self = true;
                    }

                    $stationsOPEN= [
                        'station_id' => $station['station_id'],
                        'self_service' => $self,
                        'date_min' => $dateMin->format('d-m-Y'),
                        'date_max' => $dateMax->format('d-m-Y'),
                        'hour_min' => $open['hour_min'],
                        'hour_max' => $open['hour_max'],
                    ];
                }
            }

            if(in_array($station['station_id'], $stationsOPEN)) {


                $result[] = [
                    'station_id' => $stationsOPEN['station_id'],
                    'station_name' => $station['station_name'],
                    'station_city' => $station['station_city'],
                    'country_name' => $station['country_name'],
                    'country_id' => $station['country_id'],
                    'address_1' => $station['address_1'],
                    'phone' => $station['phone'],
                    'fax' => $station['fax'],
                    'email' => $station['email'],
                    'self_service' => $self,
                    'date_min' => $stationsOPEN['date_min'],
                    'date_max' => $stationsOPEN['date_max'],
                    'hour_min' => $stationsOPEN['hour_min'],
                    'hour_max' => $stationsOPEN['hour_max'],
                ];

                $stationResacar = New StationsResacar();
                $stationResacar->setStationsId(intval($station['station_id']));
                $stationResacar->setStationName($station['station_name']);
                $stationResacar->setStationCity($station['station_city']);
                $stationResacar->setCountryName($station['country_name']);
                $stationResacar->setCountryId(intval($station['country_id']));
                $stationResacar->setAddress1($station['address_1']);
                $stationResacar->setPhone(intval($station['phone']));
                $stationResacar->setFax($station['fax']);
                $stationResacar->setEmail($station['email']);
                $stationResacar->setSelfService($self);
                $stationResacar->setDateMin($dateMin->format('d-m-Y'));
                $stationResacar->setDateMax($dateMax->format('d-m-Y'));
                $stationResacar->setHourMin($stationsOPEN['hour_min']);
                $stationResacar->setHourMax($stationsOPEN['hour_max']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($stationResacar);
                $em->flush();


            }

        }

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

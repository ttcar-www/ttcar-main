<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Entity\Country;
use App\Entity\Nationality;
use App\Entity\Order;
use App\Entity\Reason;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PdfController extends AbstractController
{
    /**
     * @Route("/dowloadPDFXml/{id}", name="dowloadPDFXml")
     * @param $id
     */
    public function dowloadPDFXml($id)
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy(['id' => $id]);

        file_put_contents($projectDir . '/public/build/filesPdf/xfdf_20939.xfdf', $this->ttcar_order_create_xfdf($id));
        if ($order->getLang() == 'fr') {
            $path = '/public/build/filesPdf/FR/';
        }else {
            $path = '/public/build/filesPdf/EN/';
        }

        if ($order->getMark() == 'Renault') {
            $original = $projectDir.$path.'Renault.pdf';
        } elseif ($order->getMark() == 'Citroen') {
            $original = $projectDir.$path.'Citroen.pdf';
        }elseif ($order->getMark() == 'Peugeot') {
            $original = $projectDir.$path.'Peugeot.pdf';
        }else {
            $original = $projectDir.$path.'Ds.pdf';
        }
        
        exec("pdftk " . $original . " fill_form " . $projectDir ."/public/build/filesPdf/xfdf_20939.xfdf output " . $projectDir . '/assets/images/filesPdf/' .$id. ".pdf");

        $pdf = file_get_contents($projectDir . '/assets/images/filesPdf/' .$id. ".pdf");
        $size = filesize($projectDir . '/assets/images/filesPdf/' .$id. ".pdf");

        unlink($projectDir . "/public/build/filesPdf/xfdf_20939.xfdf");
        unlink($projectDir . '/assets/images/filesPdf/' .$id. ".pdf");

        $filename = $id . ".pdf";

        header("Pragma: public");
        header("Expires: 0");
        //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Length: $size");
        header("Content-Description: File Transfer");
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Transfer-Encoding: binary");
        echo $pdf;
        exit();
    }


    /**
     * @param $id
     * @return string
     */
    function ttcar_order_create_xfdf($id)
    {
        $items= null;
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy(['id' => $id]);

        $nationality = $this->getDoctrine()
            ->getRepository(Nationality::class)
            ->findOneBy(['id' => $order->getNationality()]);

        $adressCountry = $this->getDoctrine()
            ->getRepository(Country::class)
            ->findOneBy(['id' => $order->getCountry()]);

        $adressCountryHue = $this->getDoctrine()
            ->getRepository(Country::class)
            ->findOneBy(['id' => $order->getAdressCountryHue()]);

        $reason = $this->getDoctrine()
            ->getRepository(Reason::class)
            ->findOneBy(['id' => $order->getReason()]);

        if ($order->getItems()) {
            foreach ($order->getItems() as $item) {
                $items = $this->getDoctrine()
                    ->getRepository(Accessory::class)
                    ->findby(['libelle' => $item]);
            }
        }

        if( empty( $order ) ) return "";

        $xml = array();

        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<xfdf xmlns="http://ns.adobe.com/xfdf/" xml:space="preserve">';
        $xml[] = '<fields>';

        $ref_ada = "";
        $ref_sodexa = "";

        switch ($order->getMark()) {
            case 'Renault':
                $xml[] = '<field name="Nom">';
                $xml[] = '<value>' . mb_strtoupper($order->getCustomerName()) . '</value>';
                $xml[] = '</field>';
                if ($order->getCustomerOldName()) {
                    $maiden = $order->getCustomerOldName();
                }else {
                    $maiden = ' ';
                }
                $xml[] = '<field name="NomJeuneFille">';
                $xml[] = '<value>' . mb_strtoupper($maiden) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Monsieur">';
                if ($order->getCustomerType() == 'mr') {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Madame">';
                if ($order->getCustomerType() == 'mme') {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Prenom">';
                $xml[] = '<value>' . mb_strtoupper($order->getCustomerUsername()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LanguePT">';
                $xml[] = '<value>Off</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LangueES">';
                $xml[] = '<value>Off</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LangueUK">';
                $xml[] = '<value>Off</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LangueFR">';
                $xml[] = '<value>Oui</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="DateNaissance">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthDate()->format('d/m/y')) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="PaysNaissance">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthCountry()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Nationalite">';
                $xml[] = '<value>' . mb_strtoupper($nationality->getNameFr()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Profession">';
                $xml[] = '<value>' . mb_strtoupper($order->getProfession()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="CNI">';
                $xml[] = '<value>Off</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Passeport">';
                $xml[] = '<value>Off</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="CNI">';
                $xml[] = '<value>Off</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="NumPasseport">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportNumber()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LieuEmission">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="NomVoie">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->getAdress())) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="CompAdresse">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Ville">';
                $xml[] = '<value>' . mb_strtoupper($order->getCity()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="PaysRes">';
                $xml[] = '<value>' . mb_strtoupper($adressCountry->getNameFr()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Etat">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Telephone">';
                $xml[] = '<value>' . mb_strtoupper($order->getPhone()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Email">';
                $xml[] = '<value>' . mb_strtoupper($order->getEmail()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Port">';
                $xml[] = '<value>' . ' ' . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="TelDom">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="TelBur">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Journal">';
                if ($reason->getId() == 5) {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Etudiant">';
                if ($reason->getId() == 2) {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="MissUniv">';
                if ($reason->getId() == 4) {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Stage">';
                if ($reason->getId() == 3) {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Mili">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Tour">';
                if ($reason->getId() == 1) {
                    $xml[] = '<value>Oui</value>';
                } else {
                    $xml[] = '<value>Off</value>';
                }
                $xml[] = '</field>';
                $xml[] = '<field name="For">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Vehicule">';
                $xml[] = '<value>' . mb_strtoupper($order->getCarLibelle()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="DateRest">';
                $xml[] = '<value>' . mb_strtoupper($order->getDepartDate()->format('d/m/y')) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Duree">';
                $xml[] = '<value>' . mb_strtoupper($order->getCountDays()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LieuLiv">';
                $xml[] = '<value>' . mb_strtoupper($order->getDepartPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="LieuRest">';
                $xml[] = '<value>' . mb_strtoupper($order->getReturnPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="NVol">';
                $xml[] = '<value>' . mb_strtoupper($order->getNumberPlane()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="HVol">';
                $xml[] = '<value>' . mb_strtoupper($order->getPlaneDate2()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="AM">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="PM">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="DateLiv">';
                $xml[] = '<value>' . mb_strtoupper($order->getDepartDate()->format('d/m/y')) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Crypto">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="FraisRest">';
                $xml[] = '<value>' . mb_strtoupper($order->getReturnPrice()) . '</value>';
                $xml[] = '</field>';
                /*          $xml[] = '<field name="ExpCarte">';
                          $xml[] = '<value></value>';
                          $xml[] = '</field>';*/
                /*    $xml[] = '<field name="DateCont">';
                    $xml[] = '<value>'. date("d/m/Y") .'</value>';
                    $xml[] = '</field>';*/
                $xml[] = '<field name="LieuCont">';
                $xml[] = '<value>' . mb_strtoupper($order->getCity()) . '</value>';
                $xml[] = '</field>';
                   $xml[] = '<field name="RefTTCar">';
                   $xml[] = '<value>' . mb_strtoupper('T'.$order->getId()) . '</value>';
                   $xml[] = '</field>';
                $xml[] = '<field name="DateEmission">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportDate()->format('d/m/y')) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="VilleNaissance">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthCity()) . '</value>';
                $xml[] = '</field>';
                /*       $xml[] = '<field name="NumCarte">';
                       $xml[] = '<value></value>';
                       $xml[] = '</field>';
                       $xml[] = '<field name="TypeCarte">';
                       $xml[] = '<value></value>';
                       $xml[] = '</field>';*/
                $xml[] = '<field name="PrixContrat">';
                $xml[] = '<value>' . number_format($order->getPrice(),2,","," ") . '</value>';
                $xml[] = '</field>';
                /*   $xml[] = '<field name="PrixCont">';
                   $xml[] = '<value>' . number_format($order->rate,2,","," ") . '</value>';
                   $xml[] = '</field>';*/
                   $prices_acc = 0;
                   $accessories = $items;
                    foreach ($items as $item) {
                        foreach ($order->getCountItems() as $countItem) {
                            $prices_acc += $item->getPrice() * $countItem;
                        }
                    }
                   $xml[] = '<field name="PrixAccess">';
                   $xml[] = '<value>' . number_format($prices_acc,2,","," ") . '</value>';
                   $xml[] = '</field>';
                   $xml[] = '<field name="FraisLiv">';
                   $xml[] = '<value>' . number_format($order->getDepartPrice()+$order->getReturnPrice(),2,","," ") . '</value>';
                   $xml[] = '</field>';
                   $xml[] = '<field name="PrixModele">';
                   $xml[] = '<value>' . ' ' . '</value>';
                   $xml[] = '</field>';
                   $xml[] = '<field name="Texte2">';
                   $xml[] = '<value>' . ' ' . '</value>';
                   $xml[] = '</field>';

                 reset($accessories);
                   if (count($accessories)) {
                       $accessory = current($accessories);
                       foreach ($items as $item) {
                           foreach ($order->getCountItems() as $countItem) {
                               $xml[] = '<field name="Access1">';
                               $xml[] = '<value>' . mb_strtoupper($countItem . 'x ' . $item->getLibelle()) . '</value>';
                               $xml[] = '</field>';

                               $xml[] = '<field name="accessR1">';
                               $xml[] = '<value>' . $item->getLibelle() . '</value>';
                               $xml[] = '</field>';

                               $xml[] = '<field name="accessQT1">';
                               $xml[] = '<value>' . $countItem . '</value>';
                               $xml[] = '</field>';

                               $xml[] = '<field name="accessPU1">';
                               $xml[] = '<value>' . $item->getPrice() . '</value>';
                               $xml[] = '</field>';

                               $xml[] = '<field name="PrixAccess1">';
                               $xml[] = '<value>' . ($accessory->getPrice() * $countItem) . '</value>';
                               $xml[] = '</field>';
                           }
                       }


                         if (count($accessories) > 1) {
                             next($accessories);
                             $accessory = current($accessories);

                             foreach ($items as $item) {
                                 foreach ($order->getCountItems() as $countItem) {
                                     $xml[] = '<field name="access2">';
                                     $xml[] = '<value>' . mb_strtoupper($countItem . 'x ' . $item->getLibelle()) . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="accessR2">';
                                     $xml[] = '<value>' . $item->getLibelle() . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="accessQT2">';
                                     $xml[] = '<value>' . $countItem . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="accessPU2">';
                                     $xml[] = '<value>' . $item->getPrice() . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="PrixAccess2">';
                                     $xml[] = '<value>' . ($item->getPrice() * $countItem) . '</value>';
                                     $xml[] = '</field>';
                                 }
                             }
                         }

                         if (count($accessories) > 2) {
                             next($accessories);
                             $accessory = current($accessories);
                             foreach ($items as $item) {
                                 foreach ($order->getCountItems() as $countItem) {
                                     $xml[] = '<field name="Access3">';
                                     $xml[] = '<value>' . mb_strtoupper($countItem . 'x ' . $item->getLibelle()) . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="accessR3">';
                                     $xml[] = '<value>' . $item->getLibelle() . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="accessQT3">';
                                     $xml[] = '<value>' . $countItem . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="accessPU3">';
                                     $xml[] = '<value>' . $item->getPrice() . '</value>';
                                     $xml[] = '</field>';

                                     $xml[] = '<field name="PrixAccess3">';
                                     $xml[] = '<value>' . ($item->getPrice() * $countItem) . '</value>';
                                     $xml[] = '</field>';
                                 }
                             }
                         }
                         }
                       $xml[] = '<field name="postcode">';
                       $xml[] = '<value>' . mb_strtoupper($order->getPostalCode()) . '</value>';
                       $xml[] = '</field>';
                       $xml[] = '<field name="Obs1">';
                       $xml[] = '<value>' . $order->getPromoLibelle() . ', ", ", "Promotion(s): ", "" ' . '</value>';
                       $xml[] = '</field>';
                       $xml[] = '<field name="Obs2">';
                       $xml[] = '<value></value>';
                       $xml[] = '</field>';
                       $xml[] = '<field name="adeurp">';
                       $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->getAdress()) . ' ' . $order->getCity() . ' ' . $order->getPostalCode()) . '</value>';
                       $xml[] = '</field>';
                       $xml[] = '<field name="TelephoneFR">';
                       $xml[] = '<value>' . mb_strtoupper($order->getPhone()) . '</value>';
                       $xml[] = '</field>';
                       $xml[] = '<field name="datenaissancedept">';
                       $xml[] = '<value>' . mb_strtoupper($order->getBirthPostal()) . '</value>';
                       $xml[] = '</field>';
                break;
            case 'Peugeot':
            case 'Citroën':
            case 'DS Automobile':
                $xml[] = '<field name="ref_ada">';
                $xml[] = '<value>' . 'T'.$order->getId() . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ref_ada*">';
                $xml[] = '<value>' . 'T'.$order->getId() . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ref_sodexa">';
                $xml[] = '<value>' . $ref_sodexa . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ref_sodexa*">';
                $xml[] = '<value>' . $ref_sodexa . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nom">';
                $xml[] = '<value>' . mb_strtoupper($order->getCustomerName()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nom*">';
                $xml[] = '<value>' . mb_strtoupper($order->getCustomerUsername()) . '</value>';
                $xml[] = '</field>';
                if ($order->getCustomerOldName()) {
                    $maiden = $order->getCustomerOldName();
                }else {
                    $maiden = ' ';
                }
                $xml[] = '<field name="nom_jeune_fille">';
                $xml[] = '<value>' . mb_strtoupper($maiden) . '</value>';
                $xml[] = '<value>' . mb_strtoupper($maiden) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nom_jeune_fille*">';
                $xml[] = '<value>' . mb_strtoupper($maiden) . '</value>';
                $xml[] = '</field>';

                if ($order->getCustomerType() == 'mme') {
                    $tilte = '02';
                }else {
                    $tilte = '01';
                }
                $xml[] = '<field name="Title">';
                $xml[] = '<value>'.($tilte ).'</value>';	// 01: M. / 02: Mme / 03: Mlle
                $xml[] = '</field>';
                $xml[] = '<field name="Title*">';
                $xml[] = '<value>'.($tilte).'</value>';	// 01: M. / 02: Mme / 03: Mlle
                $xml[] = '</field>';
                $xml[] = '<field name="prenom">';
                $xml[] = '<value>' . mb_strtoupper($order->getCustomerUsername()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="prenom*">';
                $xml[] = '<value>' . mb_strtoupper($order->getCustomerUsername()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Language">';
                $xml[] = '<value>F</value>';			// F: français, A: Anglais, E: Espagnol, P: Portuguais
                $xml[] = '</field>';
                $xml[] = '<field name="Language*">';
                $xml[] = '<value>F</value>';			// F: français, A: Anglais, E: Espagnol, P: Portuguais
                $xml[] = '</field>';
                $birthDate = $order->getBirthDate()->format('d/m/y');
                $xml[] = '<field name="date_naissance">';
                $xml[] = '<value>' . $birthDate. '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_naissance*">';
                $xml[] = '<value>' . $birthDate . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="pays_naissance">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthCountry()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="pays_naissance*">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthCountry()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ville_naissance">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthCity()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ville_naissance*">';
                $xml[] = '<value>' . mb_strtoupper($order->getBirthCity()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nationalite">';
                $xml[] = '<value>' . mb_strtoupper($nationality->getNameFr()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nationalite*">';
                $xml[] = '<value>' . mb_strtoupper($nationality->getNameFr()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="profession">';
                $xml[] = '<value>' . mb_strtoupper($order->getProfession()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="profession*">';
                $xml[] = '<value>' . mb_strtoupper($order->getProfession()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Phone">';
                $xml[] = '<value>P</value>';		// P: portable
                $xml[] = '</field>';
                $xml[] = '<field name="Phone*">';
                $xml[] = '<value>P</value>';		// P: portable
                $xml[] = '</field>';
                $xml[] = '<field name="telephone">';
                $xml[] = '<value>' . mb_strtoupper($order->getPhone()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="telephone*">';
                $xml[] = '<value>' . mb_strtoupper($order->getPhone()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="email">';
                $xml[] = '<value>' . mb_strtoupper($order->getEmail()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="email*">';
                $xml[] = '<value>' . mb_strtoupper($order->getEmail()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Identity">';
                $xml[] = '<value>Passport</value>';		// Passport: passeport / Identity: CNI
                $xml[] = '</field>';
                $xml[] = '<field name="Identity*">';
                $xml[] = '<value>Passport</value>';		// Passport: passeport / Identity: CNI
                $xml[] = '</field>';
                $xml[] = '<field name="nr_passeport">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportNumber()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nr_passeport*">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportNumber()) . '</value>';
                $xml[] = '</field>';
                $datePaspport = $order->getPassportDate()->format('d/m/y');
                $xml[] = '<field name="date_emission">';
                $xml[] = '<value>' . mb_strtoupper($datePaspport) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_emission*">';
                $xml[] = '<value>' . mb_strtoupper($datePaspport) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_emission">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_emission*">';
                $xml[] = '<value>' . mb_strtoupper($order->getPassportPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="hors_ue">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->getAdressNoUe())) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="hors_ue*">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->getAdressNoUe())) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="complement_hors_ue">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="complement_hors_ue*">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="code_postal">';
                $xml[] = '<value>' . mb_strtoupper($order->getAdressCodeHue()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="code_postal*">';
                $xml[] = '<value>' . mb_strtoupper($order->getAdressCodeHue()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ville">';
                $xml[] = '<value>' . mb_strtoupper($order->getAdressCityHue()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ville*">';
                $xml[] = '<value>' . mb_strtoupper($order->getAdressCityHue()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="pays_hors_ue">';
                $xml[] = '<value>' . mb_strtoupper($adressCountryHue->getNameFr()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="pays_hors_ue*">';
                $xml[] = '<value>' . mb_strtoupper($adressCountryHue->getNameFr()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="adresse_ue">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->getAdress()) . ' ' . $order->getCity() . ' ' . $order->getPostalCode()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="adresse_ue*">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->getAdress()) . ' ' . $order->getCity() . ' ' . $order->getPostalCode()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Profile">';
                if( $reason->getId() == 5 ) {
                    $xml[] = '<value>Member of mission / journalist</value>';	// Journaliste
                } elseif( $reason->getId() == 2 ) {
                    $xml[] = '<value>Student</value>';							// Etudiant
                } elseif( $reason->getId() == 3 ) {
                    $xml[] = '<value>Trainee</value>';							// Stagiaire
                } elseif( $reason->getId() == 4 ) {
                    $xml[] = '<value>Project manager</value>';					// Chargés de mission
                } elseif( $reason->getId() == 1 ) {
                    $xml[] = '<value>Tourist</value>';							// Touriste
                } else {
                    $xml[] = '<value></value>';									// (absent)
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Profile*">';
                if( $reason->getId() == 5 ) {
                    $xml[] = '<value>Member of mission / journalist</value>';	// Journaliste
                } elseif( $reason->getId() == 2 ) {
                    $xml[] = '<value>Student</value>';							// Etudiant
                } elseif( $reason->getId() == 3 ) {
                    $xml[] = '<value>Trainee</value>';							// Stagiaire
                } elseif( $reason->getId() == 4 ) {
                    $xml[] = '<value>Project manager</value>';					// Chargés de mission
                } elseif( $reason->getId() == 1 ) {
                    $xml[] = '<value>Tourist</value>';							// Touriste
                } else {
                    $xml[] = '<value></value>';									// (absent)
                }
                $xml[] = '</field>';
                $xml[] = '<field name="vehicule">';
                $xml[] = '<value>' . mb_strtoupper($order->getCarLibelle()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="vehicule*">';
                $xml[] = '<value>' . mb_strtoupper($order->getCarLibelle()) . '</value>';
                $xml[] = '</field>';
                $comment = (empty($order->getComment())) ? $order->getComment() : ' ';
                $xml[] = '<field name="observations">';
                $xml[] = '<value>' .$comment  . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="observations*">';
                $xml[] = '<value>' . $comment . '</value>';
                $xml[] = '</field>';
                $dateStart = $order->getDepartDate()->format('d/m/y');
                $dateReturn = $order->getReturnDate()->format('d/m/y');
                $xml[] = '<field name="date_liv">';
                $xml[] = '<value>' . mb_strtoupper($dateStart) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_liv*">';
                $xml[] = '<value>' . mb_strtoupper($dateStart) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_res">';
                $xml[] = '<value>' . mb_strtoupper($dateReturn) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_res*">';
                $xml[] = '<value>' . mb_strtoupper($dateReturn) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="duree">';
                $xml[] = '<value>' . mb_strtoupper($order->getCountDays()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="duree*">';
                $xml[] = '<value>' . mb_strtoupper($order->getCountDays()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_liv">';
                $xml[] = '<value>' . mb_strtoupper($order->getDepartPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_liv*">';
                $xml[] = '<value>' . mb_strtoupper($order->getDepartPlace()) . '</value>';
                $xml[] = '</field>';
                // numéro de vol
                $xml[] = '<field name="nr_vol">';
                $xml[] = '<value>' .mb_strtoupper($order->getNumberPlane()).'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nr_vol*">';
                $xml[] = '<value>' .mb_strtoupper($order->getNumberPlane()).'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="heure_vol">';
                $xml[] = '<value>' . $order->getPlaneDate2() . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="heure_vol*">';
                $xml[] = '<value>' . $order->getPlaneDate2() . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="flight_time">';
                $xml[] = '<value>' . ( preg_match( "/AM/i", $order->getPlaneDate2() ) || intval( substr( $order->getPlaneDate2(), 0, 2 ) ) < 12 ? "AM" : "PM" ) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="flight_time*">';
                $xml[] = '<value>' . ( preg_match( "/AM/i", $order->getPlaneDate2() ) || intval( substr( $order->getPlaneDate2(), 0, 2 ) ) < 12 ? "AM" : "PM" ) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_res">';
                $xml[] = '<value>' . mb_strtoupper($order->getReturnPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_res*">';
                $xml[] = '<value>' . mb_strtoupper($order->getReturnPlace()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="acompte">';
                $xml[] = '<value>' . ' '. '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="acompte*">';
                $xml[] = '<value>' . ' ' . '</value>';
                $xml[] = '</field>';
                $departPrice = (empty($order->getDepartPrice())) ? $order->getDepartPrice() : '0';
                $departReturn = (empty($order->getReturnPrice())) ? $order->getReturnPrice() : '0';

                $xml[] = '<field name="frais_livraison">';
                $xml[] = '<value>' . number_format($departPrice,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_livraison*">';
                $xml[] = '<value>' . number_format($departPrice,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_restitution">';
                $xml[] = '<value>' . number_format($departReturn,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_restitution*">';
                $xml[] = '<value>' . number_format($departReturn,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="total">';
                $xml[] = '<value>' . number_format($order->getPrice(),2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="total*">';
                $xml[] = '<value>' . number_format($order->getPrice(),2,",","") . '</value>';
                $xml[] = '</field>';

            $prices_acc = 0;
            $accessories = $items;

            foreach ($items as $item) {
                foreach ($order->getCountItems() as $countItem) {
                    $prices_acc += $item->getPrice() * $countItem;
                }
            }
                $xml[] = '<field name="montant_accessoires">';
                $xml[] = '<value>' . number_format($prices_acc,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="montant_accessoires*">';
                $xml[] = '<value>' . number_format($prices_acc,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="prix_ht">';
                $xml[] = '<value>' . number_format($order->getBasicPrice(),2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="prix_ht*">';
                $xml[] = '<value>' . number_format($order->getBasicPrice(),2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="solde">';
                $xml[] = '<value>' .'' . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="solde*">';
                $xml[] = '<value>' .' ' . '</value>';
                $xml[] = '</field>';
                $idx = 1;
            foreach ($items as $item) {
                foreach ($order->getCountItems() as $countItem) {
                    $xml[] = '<field name="accessoires' . $idx . '">';
                    $xml[] = '<value>' . mb_strtoupper($countItem . 'x ' . $item->getLibelle()) . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="accessoires'.$idx.'*'.'">';
                    $xml[] = '<value>' . mb_strtoupper($countItem . 'x ' . $item->getLibelle()) . '</value>';
                    $xml[] = '</field>';
                    $idx+= 1;
                }
            }
                    if( $idx > 4 ) break;
                $i = 0;
        for( $i = $idx; $i <= 4; $i++ ) {
            $xml[] = '<field name="accessoires'.$i.'">';
            $xml[] = '<value></value>';
            $xml[] = '</field>';
            $xml[] = '<field name="accessoires'.$i.'*'.'">';
            $xml[] = '<value></value>';
            $xml[] = '</field>';
                             }

                $xml[] = '<field name="fait_le">';
                $xml[] = '<value>'. date("d/m/Y") .'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="fait_le*">';
                $xml[] = '<value>'. date("d/m/Y") .'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="fait_a">';
                $xml[] = '<value>' . mb_strtoupper($order->getCity()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="fait_a*">';
                $xml[] = '<value>' . mb_strtoupper($order->getCity()) . '</value>';
                $xml[] = '</field>';

                $xml[] = '<field name="nom_vendeur">';
                $xml[] = '<value>TTCAR</value>';
                $xml[] = '</field>';

                break;
        }

        $xml[] = '</fields>';
        $xml[] = '</xfdf>';

        return implode(PHP_EOL, $xml);
    }
}

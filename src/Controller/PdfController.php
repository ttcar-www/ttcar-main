<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Mark;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;


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

        $original = $projectDir . '/public/build/filesPdf/citroen.pdf';

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
    function ttcar_order_create_xfdf($id) {

        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy(['id' => $id]);

        $car = $this->getDoctrine()
            ->getRepository(Cars::class)
            ->findOneBy(['name' => $order->getCarLibelle()]);

        $mark = $this->getDoctrine()
            ->getRepository(Mark::class)
            ->findOneBy(['id' => $car->getMark()]);

        $country = $this->getDoctrine()
            ->getRepository(Mark::class)
            ->findOneBy(['id' => $car->getMark()]);

        if( empty( $order ) ) return "";

        $xml = array();

        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<xfdf xmlns="http://ns.adobe.com/xfdf/" xml:space="preserve">';
        $xml[] = '<fields>';

        $ref_ada = $order->getId();
        $ref_sodexa = "";

        switch ($mark->getLibelle()) {
            case 'Peugeot':
            case 'Renault':
            case 'Citroën':
            case 'DS Automobile':
                $xml[] = '<field name="ref_ada">';
                $xml[] = '<value>' . $ref_ada . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ref_ada*">';
                $xml[] = '<value>' . $ref_ada . '</value>';
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
                if ($order->getCustomerOldName() != null) {
                    $xml[] = '<field name="nom_jeune_fille">';
                    $xml[] = '<value>' . mb_strtoupper($order->getCustomerOldName()) . '</value>';
                    $xml[] = '<value>' . mb_strtoupper($order->getCustomerOldName()) . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="nom_jeune_fille*">';
                    $xml[] = '<value>' . mb_strtoupper($order->getCustomerOldName()) . '</value>';
                    $xml[] = '</field>';

                } else {
                    $xml[] = '<field name="nom_jeune_fille">';
                    $xml[] = '<value>' . ' ' . '</value>';
                    $xml[] = '<value>' . ' ' . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="nom_jeune_fille*">';
                    $xml[] = '<value>' .' ' . '</value>';
                    $xml[] = '</field>';
                }

                $xml[] = '<field name="Title">';
                $xml[] = '<value>'.('01' ).'</value>';	// 01: M. / 02: Mme / 03: Mlle
                $xml[] = '</field>';
                $xml[] = '<field name="Title*">';
                $xml[] = '<value>'.( '01' ).'</value>';	// 01: M. / 02: Mme / 03: Mlle
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
            /*    $xml[] = '<field name="date_naissance">';
                $xml[] = '<value>' . strtotime($order->getBirthDate()->format('Y-m-d H:i:s')) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_naissance*">';
                $xml[] = '<value>' . strtotime($order->getBirthDate()->format('Y-m-d H:i:s')) . '</value>';
                $xml[] = '</field>';*/
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
            /*    $xml[] = '<field name="nationalite">';
                $xml[] = '<value>' . mb_strtoupper($order->getNationality()) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nationalite*">';
                $xml[] = '<value>' . mb_strtoupper($order->getNationality()) . '</value>';
                $xml[] = '</field>';*/
         /*       $xml[] = '<field name="profession">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->job) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="profession*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->job) . '</value>';
                $xml[] = '</field>';*/
                /*if( ! empty( $order->user_info->cell_phone ) ) {
                    $xml[] = '<field name="Phone">';
                    $xml[] = '<value>P</value>';		// P: portable
                    $xml[] = '</field>';
                    $xml[] = '<field name="Phone*">';
                    $xml[] = '<value>P</value>';		// P: portable
                    $xml[] = '</field>';
                    $xml[] = '<field name="telephone">';
                    $xml[] = '<value>' . mb_strtoupper($order->user_info->cell_phone) . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="telephone*">';
                    $xml[] = '<value>' . mb_strtoupper($order->user_info->cell_phone) . '</value>';
                    $xml[] = '</field>';
                } elseif( ! empty( $order->user_info->phone ) ) {
                    $xml[] = '<field name="Phone">';
                    $xml[] = '<value>F</value>';		// F: fixe
                    $xml[] = '</field>';
                    $xml[] = '<field name="Phone*">';
                    $xml[] = '<value>F</value>';		// F: fixe
                    $xml[] = '</field>';
                    $xml[] = '<field name="telephone">';
                    $xml[] = '<value>' . mb_strtoupper($order->user_info->phone) . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="telephone*">';
                    $xml[] = '<value>' . mb_strtoupper($order->user_info->phone) . '</value>';
                    $xml[] = '</field>';
                } else {
                    $xml[] = '<field name="Phone">';
                    $xml[] = '<value></value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="Phone*">';
                    $xml[] = '<value></value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="telephone">';
                    $xml[] = '<value>Non renseigné</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="telephone*">';
                    $xml[] = '<value>Non renseigné</value>';
                    $xml[] = '</field>';
                }*/
      /*          $xml[] = '<field name="email">';
                $xml[] = '<value>' . mb_strtoupper($order->user->email) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="email*">';
                $xml[] = '<value>' . mb_strtoupper($order->user->email) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Identity">';
                $xml[] = '<value>Passport</value>';		// Passport: passeport / Identity: CNI
                $xml[] = '</field>';
                $xml[] = '<field name="Identity*">';
                $xml[] = '<value>Passport</value>';		// Passport: passeport / Identity: CNI
                $xml[] = '</field>';
                $xml[] = '<field name="nr_passeport">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->passeport) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nr_passeport*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->passeport) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_emission">';
                $xml[] = '<value>' . mb_strtoupper(human_date($order->user_info->passport_issued_at)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_emission*">';
                $xml[] = '<value>' . mb_strtoupper(human_date($order->user_info->passport_issued_at)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_emission">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->passport_city_issued) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_emission*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->passport_city_issued) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="hors_ue">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->user_info->address)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="hors_ue*">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->user_info->address)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="complement_hors_ue">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="complement_hors_ue*">';
                $xml[] = '<value></value>';
                $xml[] = '</field>';
                $xml[] = '<field name="code_postal">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->zip_code) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="code_postal*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->zip_code) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ville">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->city) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="ville*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->city) . '</value>';
                $xml[] = '</field>';*/
   /*             $xml[] = '<field name="pays_hors_ue">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->country->name_fr) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="pays_hors_ue*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->country->name_fr) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="adresse_ue">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->user_location->address) . ' ' . $order->user_location->city . ' ' . $order->user_location->zip_code) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="adresse_ue*">';
                $xml[] = '<value>' . mb_strtoupper(preg_replace("/(\r\n|\n|\r)/", " ", $order->user_location->address) . ' ' . $order->user_location->city . ' ' . $order->user_location->zip_code) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="Profile">';
                if( $order->user_info->situation == 5 ) {
                    $xml[] = '<value>Member of mission / journalist</value>';	// Journaliste
                } elseif( $order->user_info->situation == 2 ) {
                    $xml[] = '<value>Student</value>';							// Etudiant
                } elseif( $order->user_info->situation == 3 ) {
                    $xml[] = '<value>Trainee</value>';							// Stagiaire
                } elseif( $order->user_info->situation == 4 ) {
                    $xml[] = '<value>Project manager</value>';					// Chargés de mission
                } elseif( $order->user_info->situation == 1 ) {
                    $xml[] = '<value>Tourist</value>';							// Touriste
                } else {
                    $xml[] = '<value></value>';									// (absent)
                }
                $xml[] = '</field>';
                $xml[] = '<field name="Profile*">';
                if( $order->user_info->situation == 5 ) {
                    $xml[] = '<value>Member of mission / journalist</value>';	// Journaliste
                } elseif( $order->user_info->situation == 2 ) {
                    $xml[] = '<value>Student</value>';							// Etudiant
                } elseif( $order->user_info->situation == 3 ) {
                    $xml[] = '<value>Trainee</value>';							// Stagiaire
                } elseif( $order->user_info->situation == 4 ) {
                    $xml[] = '<value>Project manager</value>';					// Chargés de mission
                } elseif( $order->user_info->situation == 1 ) {
                    $xml[] = '<value>Tourist</value>';							// Touriste
                } else {
                    $xml[] = '<value></value>';									// (absent)
                }
                $xml[] = '</field>';
                $xml[] = '<field name="vehicule">';
                $xml[] = '<value>' . mb_strtoupper($order->car->name_fr) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="vehicule*">';
                $xml[] = '<value>' . mb_strtoupper($order->car->name_fr) . '</value>';
                $xml[] = '</field>';
                $promotions = ttcar_order_get_promotions_labels( $order->id, ", ", "Promotions: ", "" );
                $xml[] = '<field name="observations">';
                $xml[] = '<value>' . $promotions . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="observations*">';
                $xml[] = '<value>' . $promotions . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_liv">';
                $xml[] = '<value>' . mb_strtoupper(human_date($order->starting_time_at)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_liv*">';
                $xml[] = '<value>' . mb_strtoupper(human_date($order->starting_time_at)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_res">';
                $xml[] = '<value>' . mb_strtoupper(human_date($order->finishing_time_at)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="date_res*">';
                $xml[] = '<value>' . mb_strtoupper(human_date($order->finishing_time_at)) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="duree">';
                $xml[] = '<value>' . mb_strtoupper($order->day) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="duree*">';
                $xml[] = '<value>' . mb_strtoupper($order->day) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_liv">';
                //$xml[] = '<value>' . mb_strtoupper($order->starting_location->Citroen_name) . '</value>';
                $xml[] = '<value>' . mb_strtoupper($order->starting_location->name_fr) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_liv*">';
                $xml[] = '<value>' . mb_strtoupper($order->starting_location->name_fr) . '</value>';
                $xml[] = '</field>';*/
                // numéro de vol
     /*           $xml[] = '<field name="nr_vol">';
                $xml[] = '<value>' .mb_strtoupper($order->flight).'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="nr_vol*">';
                $xml[] = '<value>' .mb_strtoupper($order->flight).'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="heure_vol">';
                $hour = $order->flight_hour;
                $hour = trim( str_replace( array( "am", "AM", "Am", "aM", "pm", "PM", "Pm", "pM" ), "", $hour ) );
                if( preg_match( "/h/i", $hour ) ) $hour = preg_replace( "/h/i", ":", $hour );
                if( ! preg_match( "/\:/", $hour ) ) {
                    if( strlen( $hour ) == 1 ) {
                        $hour = "0" . $hour . ":00";
                    } elseif( strlen( $hour ) == 2 ) {
                        $hour = $hour . ":00";
                    } elseif( strlen( $hour ) == 3 ) {
                        $hour = "0" . substr( $hour, 0, 1 ) . ":" . substr( $hour, 1, 2 );
                    } elseif( strlen( $hour ) == 4 ) {
                        $hour = substr( $hour, 0, 2 ) . ":" . substr( $hour, 2, 2 );
                    } else {
                        $hour = $hour;
                    }
                } elseif( strlen( $hour ) == 4 ) {
                    $hour = "0" . $hour;
                }*/
       /*         $xml[] = '<value>' . $hour . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="heure_vol*">';
                $hour = $order->flight_hour;*/
/*                $hour = trim( str_replace( array( "am", "AM", "Am", "aM", "pm", "PM", "Pm", "pM" ), "", $hour ) );*/
 /*               if( preg_match( "/h/i", $hour ) ) $hour = preg_replace( "/h/i", ":", $hour );
                if( ! preg_match( "/\:/", $hour ) ) {
                    if( strlen( $hour ) == 1 ) {
                        $hour = "0" . $hour . ":00";
                    } elseif( strlen( $hour ) == 2 ) {
                        $hour = $hour . ":00";
                    } elseif( strlen( $hour ) == 3 ) {
                        $hour = "0" . substr( $hour, 0, 1 ) . ":" . substr( $hour, 1, 2 );
                    } elseif( strlen( $hour ) == 4 ) {
                        $hour = substr( $hour, 0, 2 ) . ":" . substr( $hour, 2, 2 );
                    } else {
                        $hour = $hour;
                    }
                } elseif( strlen( $hour ) == 4 ) {
                    $hour = "0" . $hour;
                }*/
/*                $xml[] = '<value>' . $hour . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="flight_time">';
                $xml[] = '<value>' . ( preg_match( "/AM/i", $order->flight_hour ) || intval( substr( $order->flight_hour, 0, 2 ) ) < 12 ? "AM" : "PM" ) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="flight_time*">';
                $xml[] = '<value>' . ( preg_match( "/AM/i", $order->flight_hour ) || intval( substr( $order->flight_hour, 0, 2 ) ) < 12 ? "AM" : "PM" ) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_res">';
                $xml[] = '<value>' . mb_strtoupper($order->finishing_location->name_fr) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="lieu_res*">';
                $xml[] = '<value>' . mb_strtoupper($order->finishing_location->name_fr) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="acompte">';
                $xml[] = '<value>' . number_format($order->package,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="acompte*">';
                $xml[] = '<value>' . number_format($order->package,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_livraison">';
                $xml[] = '<value>' . number_format($order->delivery,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_livraison*">';
                $xml[] = '<value>' . number_format($order->delivery,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_restitution">';
                $xml[] = '<value>' . number_format($order->return_delivery,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="frais_restitution*">';
                $xml[] = '<value>' . number_format($order->return_delivery,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="total">';
                $xml[] = '<value>' . number_format($order->rate,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="total*">';
                $xml[] = '<value>' . number_format($order->rate,2,",","") . '</value>';
                $xml[] = '</field>';*/
/*
                $prices_acc = 0;
                foreach( $order->accessories as $accessory ) {
                    $prices_acc += $accessory->price * $accessory->quantity;
                }*/
    /*            $xml[] = '<field name="montant_accessoires">';
                $xml[] = '<value>' . number_format($prices_acc,2,",","") . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="montant_accessoires*">';
                $xml[] = '<value>' . number_format($prices_acc,2,",","") . '</value>';
                $xml[] = '</field>';*/

    /*            if( $order->rebuy_price > 0 ) {
                    $xml[] = '<field name="prix_ht">';
                    $xml[] = '<value>' . number_format($order->rebuy_price,2,",","") . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="prix_ht*">';
                    $xml[] = '<value>' . number_format($order->rebuy_price,2,",","") . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="solde">';
                    $xml[] = '<value>' . number_format($order->rebuy_price - $order->rate,2,",","") . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="solde*">';
                    $xml[] = '<value>' . number_format($order->rebuy_price - $order->rate,2,",","") . '</value>';
                    $xml[] = '</field>';
                }*/
/*
                $idx = 1;
                foreach( $order->accessories as $accessory ) {
                    $xml[] = '<field name="accessoires'.$idx.'">';
                    $xml[] = '<value>' . mb_strtoupper($accessory->quantity . 'x ' . $accessory->name_fr) . '</value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="accessoires'.$idx.'*'.'">';
                    $xml[] = '<value>' . mb_strtoupper($accessory->quantity . 'x ' . $accessory->name_fr) . '</value>';
                    $xml[] = '</field>';
                    $idx+= 1;
                    if( $idx > 4 ) break;
                }*/
   /*             $i = 0;
                for( $i = $idx; $i <= 4; $i++ ) {
                    $xml[] = '<field name="accessoires'.$i.'">';
                    $xml[] = '<value></value>';
                    $xml[] = '</field>';
                    $xml[] = '<field name="accessoires'.$i.'*'.'">';
                    $xml[] = '<value></value>';
                    $xml[] = '</field>';
                }*/

 /*               $xml[] = '<field name="fait_le">';
                $xml[] = '<value>'. date("d/m/Y") .'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="fait_le*">';
                $xml[] = '<value>'. date("d/m/Y") .'</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="fait_a">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->city) . '</value>';
                $xml[] = '</field>';
                $xml[] = '<field name="fait_a*">';
                $xml[] = '<value>' . mb_strtoupper($order->user_info->city) . '</value>';
                $xml[] = '</field>';

                $xml[] = '<field name="nom_vendeur">';
                $xml[] = '<value>TTCAR</value>';
                $xml[] = '</field>';*/

                break;
        }

        $xml[] = '</fields>';
        $xml[] = '</xfdf>';

        return implode(PHP_EOL, $xml);
    }
}

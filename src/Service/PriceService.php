<?php

// src/Service/FileUploader.php
namespace App\Service;

use App\Entity\Place;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class PriceService
{

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
     * @param $car
     * @param $day_count
     * @param $priceDepart
     * @param $priceReturn
     * @return float|int|null
     * Calcule le prix hors promotion
     */
    public function getPriceOrder($car, $day_count, $priceDepart, $priceReturn)
    {
        $total = null;
        $slices = ($car->getPrice()->getSlices()) ? $car->getPrice()->getSlices() : null;
        $price = $car->getPrice()->getPrice();


        // Addition des prix par rapport au lieux de départ et retour
        $total_place = $priceDepart + $priceReturn;

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

                if ($day_count > $slice->getDays()) {
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

}

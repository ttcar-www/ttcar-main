<?php

// src/Service/FileUploader.php
namespace App\Service;

use App\Entity\Cars;
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
    public function getPriceOrder($car, $day_count)
    {
        $total = null;
        $margin = $car->getMargin();
        $days = $day_count - 21;
        $i = 0;

        if ($car->getPrice()->getLibelle() == 2) {
            //PRIX FOURNISSEUR ACTIVE SANS MARGE
            $slices = $car->getPriceSupplier()->getSlices();
            $price = $car->getPriceSupplier()->getPrice();

            foreach ($slices as $slice) {
                if ($i == 1) {
                    if ($slice->getDays() > $day_count && $day_count < $slice->getDays()) {
                        $day_price = $slice->getValue();

                        //Prix sans marge
                        $totalSlice = $day_price * $days;
                        $total = $totalSlice + $price;

                        return $total;
                    }
                }
                $i ++;
            }
        } elseif ($car->getPrice()->getLibelle() == 1){
            $slices = $car->getPrice()->getSlices();
            $price = $car->getPrice()->getPrice();
            foreach ($slices as $slice) {
                    if ($slice->getDays() >= $day_count && $day_count < $slice->getDays()) {
                        $day_price = $slice->getValue();

                        //Prix sans marge
                        $totalSlice = $day_price * $days;
                        $total = $totalSlice + $price;

                        return $total;

                    }
                }
            }
        return $price;
    }

}

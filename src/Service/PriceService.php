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

            switch ($slice->getType()) {
                case '€':
                    $price = $slice->getValue();
                    return $price;
                    break;
                case '%':
                    $price =  $slice->getValue()*($slice->getValue()/100);
                    return $price;
                    break;
            }
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

        // Adition des prix par rapport au lieux de départ et retour
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

}

<?php

namespace App\Service;

class CartService
{
    public function getCartSum(?array $movies) {
        $priceSum = 0;
        foreach($movies as $movie)
        {
            $priceSum += $movie->getPrice();
        }
        return $priceSum;
    }
}
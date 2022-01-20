<?php

namespace App\Tests\CartTests;

use App\Entity\Movies;
use App\Service\CartService;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    public function testReturningSumOfAllMoviesInCart()
    {
        $firstMovie = (new Movies())->setPrice(10);
        $secondMovie = (new Movies())->setPrice(20);
        $thirdMovie = (new Movies())->setPrice(30);

        $movies = [$firstMovie, $secondMovie, $thirdMovie];

        $cartService = new CartService();
        $cartSum = $cartService->getCartSum($movies);
        $predictedAmount = (float)60;

        $this->assertSame($predictedAmount, $cartSum);
    }
}
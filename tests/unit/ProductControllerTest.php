<?php

namespace unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class ProductControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testGetProductsReturns200()
    {
        $result = $this->call('get', 'getProducts');

        $result->assertStatus(200);
        $result->assertJSONFragment(['message' => 'Product obtenidos.']);
    }




}
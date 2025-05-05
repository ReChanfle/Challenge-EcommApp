<?php

namespace unit;

use App\Models\ProductModel;
use CodeIgniter\Test\CIUnitTestCase;

class ProductModelTest extends CIUnitTestCase
{



    public function testEditProduct()
    {
        $productData = [
            'id' => 1,
            'title' => 'Producto Editado',
            'price' => 200
        ];

        $result = ProductModel::editFromJson($productData);
        $this->assertTrue($result);


    }

}
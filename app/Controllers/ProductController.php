<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function index(): string
    {

        $products = ProductModel::getFromJson();

        return view('products/index',[
            'products' => $products,
        ]);

    }

    public function delete($id):  ResponseInterface
    {

        try{
            ProductModel::deleteFromJson($id);
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Product eliminado correctamente.'],
                );
        }
        catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }


    }

    public function edit($id): ResponseInterface
    {

        $data = [
            'status' => 'success',
            'message' => "Producto con ID $id editado correctamente.",
            'id' => $id,
        ];

        return $this->response->setJSON($data);
    }
}

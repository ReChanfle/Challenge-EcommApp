<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{

    public function index(): string
    {

        return view('products/index');

    }

    public function getProducts(): ResponseInterface
    {

        try {
            $products = ProductModel::getFromJson();
            return $this->response->setStatusCode(200)->setJSON(['payload' => $products, 'message' => 'Product eliminado correctamente.'],
            );
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }


    }

    public function delete($id): ResponseInterface
    {

        try {
            ProductModel::deleteFromJson($id);
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Product eliminado correctamente.'],
            );
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }


    }

    public function edit(): ResponseInterface
    {
        //agregar validacion


        $product = $this->request->getJSON(true);

        log_message('info', 'Request body: ' . json_encode($this->request->getRawInput()));

        try {
            ProductModel::editFromJson($product);
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Producto con ID $id editado correctamente.'],
            );
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }
    }
}

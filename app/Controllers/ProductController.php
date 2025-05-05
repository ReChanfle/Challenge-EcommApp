<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{

    /**
     * Displays the main products view.
     *
     * @return string
     */
    public function index(): string
    {

        return view('products/index');

    }

    /**
     * Retrieves a list of products from a JSON file, with optional filters.
     *
     * @return ResponseInterface
     */
    public function getProducts(): ResponseInterface
    {

        try {

            $filters = $this->request->getGet();

            $products = ProductModel::getFromJson( $filters);
            return $this->response->setStatusCode(200)->setJSON(['payload' => $products, 'message' => 'Product obtenidos.'],
            );
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(400)
                ->setHeader('Content-Type', 'application/json')
                ->setBody(json_encode(['message' => $e->getMessage()]));
        }


    }

    /**
     * Deletes a specific product by ID from the JSON file.
     *
     * @param int $id The ID of the product to delete.
     * @return ResponseInterface
     */
    public function delete(int $id): ResponseInterface
    {

        try {
            ProductModel::deleteFromJson($id);
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Producto eliminado correctamente.'],
            );
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }


    }

    /**
     * Updates an existing product in the JSON file.
     * Validates the data before updating.
     *
     * @return ResponseInterface
     */
    public function update(): ResponseInterface
    {

        if (! $this->validate(ProductModel::$rules)) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $this->validator->getErrors()]);
        }


        $product = $this->request->getJSON(true);


        try {
            ProductModel::editFromJson($product);
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Producto con ID: '.  $product['id'].' editado correctamente.'],
            );
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }
    }

    /**
     * Creates a new product and saves it to the JSON file.
     * Validates the data before creation.
     *
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {

        if (! $this->validate(ProductModel::$rules)) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $this->validator->getErrors()]);
        }

        $product = $this->request->getJSON(true);


        try {
            ProductModel::createFromJson($product);
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Producto creado correctamente.'],
            );
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON(['message' => $e->getMessage()]);
        }

    }
}

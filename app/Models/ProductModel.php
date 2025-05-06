<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ProductModel extends Model
{


    protected $table = 'products';
    protected $primaryKey = 'id';

    public static $rules = [
        'title' => 'required|min_length[3]|string',
        'price' => 'required|numeric|min_length[1]'
    ];


    /**
     * Retrieves products from a JSON file, optionally applying filters.
     *
     * Filters can include 'id', 'title', or 'price' to narrow down the results.
     *
     * @param array $filters Optional associative array of filters (e.g., ['id' => 1, 'title' => 'Book']).
     * @return array|null Returns an array of products or null if the file does not exist.
     * @throws Exception If an error occurs while reading or decoding the JSON file.
     */
    public static function getFromJson(array $filters = []): ?array
    {
        $path = WRITEPATH . 'products.json';
        if (!file_exists($path)) {
            return null;
        }

        try {
            $json = file_get_contents($path);
            $products = json_decode($json, true);


            if (empty($filters)) {
                return $products;
            }

            $filtered = array_filter($products, function ($product) use ($filters) {
                if (isset($filters['id']) && $filters['id'] !== '' && $product['id'] != $filters['id']) {
                    return false;
                }

                if (isset($filters['title']) && $filters['title'] !== '' &&
                    stripos($product['title'], $filters['title']) === false) {
                    return false;
                }

                if (isset($filters['price']) && $filters['price'] !== '' && $product['price'] != $filters['price']) {
                    return false;
                }

                return true;
            });

            return array_values($filtered);
        }catch(Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }

    }

    /**
     * Deletes a product by ID from the JSON file.
     *
     * Reads the existing products from the JSON file, removes the product with the specified ID,
     * and rewrites the updated list back to the file.
     *
     * @param int $id The ID of the product to delete.
     * @return bool|null Returns true if the product was deleted, null if the file does not exist.
     * @throws Exception If the product is not found or there is an error during processing.
     */
    public static function deleteFromJson(int $id): ?bool
    {


        $path = WRITEPATH . './products.json';
        $logFile = WRITEPATH . 'logs/product_deletions.log';

        if (!file_exists($path)) {
            return null;
        }

        try {

            $json = file_get_contents($path);
            $products = json_decode($json, true);


            $filtered = array_filter($products, fn($p) => $p['id'] != $id);

            if (count($products) === count($filtered)) {
                throw new Exception('Producto no encontrado', 500);
            }

            $filtered = array_values($filtered);

            file_put_contents($path, json_encode($filtered, JSON_PRETTY_PRINT));

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Deleting product ID: {$id}\n", FILE_APPEND);

            return true;
        }
        catch(Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }

    }

    /**
     * Updates an existing product in the JSON file based on the provided data.
     *
     * Searches for the product by ID and updates its title and/or price if found.
     * Saves the modified list of products back to the JSON file.
     *
     * @param array $productData An associative array containing 'id', and optionally 'title' and 'price'.
     * @return bool|null Returns true if the product was successfully updated, null if the file does not exist.
     * @throws Exception If the product is not found or if an error occurs during file processing.
     */
    public static function editFromJson(array $productData): ?bool
    {
        $path = WRITEPATH . './products.json';
        $logFile = WRITEPATH . 'logs/product_editions.log';

        if (!file_exists($path)) {
            return null;
        }

        try {
            $json = file_get_contents($path);
            $products = json_decode($json, true);

            $found = false;

            foreach ($products as &$product) {
                if ($productData['id'] == $product['id']) {
                    $product['title'] = $productData['title'] ?? $product['title'];
                    $product['price'] = $productData['price'] ?? $product['price'];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                throw new Exception('Producto no encontrado', 404);
            }

            file_put_contents($path, json_encode($products, JSON_PRETTY_PRINT));

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Editing product ID: {$productData['id']}\n", FILE_APPEND);

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }
    }

    /**
     * Creates a new product and appends it to the JSON file.
     *
     * Generates a new unique ID, sets the creation timestamp, and stores the new product
     * along with existing ones. If the file doesn't exist, returns null.
     *
     * @param array $productData An associative array containing 'title' and 'price' keys.
     * @return bool|null Returns true if the product was successfully created, null if the file does not exist.
     * @throws Exception If an error occurs while reading or writing the file.
     */
    public static function createFromJson(array $productData): ?bool
    {
        $path = WRITEPATH . './products.json';
        $logFile = WRITEPATH . 'logs/product_creations.log';

        if (!file_exists($path)) {
            return null;
        }

        try {
            $json = file_get_contents($path);
            $products = json_decode($json, true);

            if (!is_array($products)) {
                $products = [];
            }

            $lastId = 0;
            foreach ($products as $product) {
                if (isset($product['id']) && $product['id'] > $lastId) {
                    $lastId = $product['id'];
                }
            }

            $newProduct = [
                'id'    => $lastId + 1,
                'title' => $productData['title'],
                'price' => $productData['price'],
                'created_at' => date('Y-m-d H:i')
            ];

            $products[] = $newProduct;

            file_put_contents($path, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Creating product ID: {$newProduct['id']}\n", FILE_APPEND);

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }
    }



}
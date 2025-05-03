<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ProductModel extends Model
{


    protected $table = 'products';
    protected $primaryKey = 'id';

    public static function getFromJson()
    {
        $path = WRITEPATH . '../app/Database/products.json';
        if (!file_exists($path)) {
            return null;
        }

        $json = file_get_contents($path);
        return json_decode($json, false);
    }

    /**
     * @throws Exception
     */
    public static function deleteFromJson($id): ?bool
    {


        $path = WRITEPATH . '../app/Database/products.json';

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

            //file_put_contents($path, json_encode($filtered, JSON_PRETTY_PRINT));

            return true;
        }
        catch(Exception $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }




    }



}
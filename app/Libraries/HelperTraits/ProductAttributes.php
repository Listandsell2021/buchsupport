<?php


namespace App\Libraries\HelperTraits;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait ProductAttributes
{
    public function convertToFormularAttributes($userProductAttributes)
    {
        $array = [];

        if (count($userProductAttributes) > 0) {

            $index = 0;

            foreach ($userProductAttributes->groupBy(['form_id']) as $formularId => $formular) {

                $array[$index]['id'] = $formularId;
                $array[$index]['purchase_date'] = $formular->first()->purchased_date;
                $array[$index]['status'] = $formular->first()->status;
                $array[$index]['form_order_no'] = $formular->first()->form_order_no;
                $array[$index]['products'] = $this->getProducts($formular);

                $index++;
            }
        }

        return $array;
    }


    public function getProducts($products): array
    {
        $array = [];
        $index = 0;
        foreach ($products as $product) {

            $array[$index]['id'] = $product->id;
            $array[$index]['user_id'] = $product->user_id;
            $array[$index]['product_id'] = $product->product_id;
            $array[$index]['price'] = $product->price;
            $array[$index]['quantity'] = $product->quantity;
            $array[$index]['condition'] = $product->condition;
            $array[$index]['note'] = $product->note;
            $array[$index]['position'] = $product->position;
            $array[$index]['is_hidden'] = $product->is_hidden;
            $array[$index]['show_price'] = $product->show_price;
            $array[$index]['show_purchase_date'] = $product->show_purchase_date;
            $array[$index]['price'] = $product->price;

            $index++;
        }

        return $array;
    }


    /**
     * Get Update Formular Attributes
     *
     * @param $formulars
     * @param $userId
     * @return void
     */
    public function updateUserProducts($formulars, $userId)
    {
        $newUserProducts = [];

        $formularOrderNo = 1;
        foreach ($formulars as $formular) {

            if (count($formular['products']) > 0) {
                foreach ($formular['products'] as $product) {
                    $newUserProducts[] = [
                        'id' => $product['id'],
                        'form_id' => $formular['id'],
                        'user_id' => $userId,
                        'product_id' => $product['product_id'],
                        'note' => $product['note'],
                        'price' => floatValue($product['price']),
                        'quantity' => $product['quantity'],
                        'condition' => $product['condition'],
                        'position' => $product['position'],
                        'form_order_no' => $formularOrderNo,
                        'is_hidden' => 0,
                        'show_price' => $product['show_price'],
                        'show_purchase_date' => $product['show_purchase_date'],
                        'purchased_date' => date('Y-m-d', strtotime($formular['purchase_date'])),
                        'status' => $formular['status'],
                    ];
                }
            }
        }

        $userProducts = $this->getInArray($this->getUserProducts($userId));
        $userProductIds = $this->getUserProductIds($userProducts);
        $newUserProductIds = $this->getUserProductIds($newUserProducts);

        $existingUserProducts = $this->getExistingProducts($newUserProducts, $userProductIds);
        $newlyFormedUserProducts = $this->getNewProducts($newUserProducts, $userProductIds);
        $removeUserIds = $this->getDeletedUserProductIds($userProductIds, $newUserProductIds);


        if (count($existingUserProducts) > 0) {
            foreach ($existingUserProducts as $existingUserProduct) {
                $userProductId = $existingUserProduct['id'];
                unset($existingUserProduct['id']);
                DB::table('user_products')
                    ->where('id', $userProductId)
                    ->update($existingUserProduct);
            }
        }

        if (count($removeUserIds) > 0) {
            DB::table('user_products')->whereIn('id', $removeUserIds)->delete();
        }

        if (count($newlyFormedUserProducts) > 0) {
            $groupedUserProducts = arrayGroupBy($newlyFormedUserProducts, 'form_id');
            $array = [];
            foreach ($groupedUserProducts as $formId => $userProducts) {
                if (strpos($formId, 'new_formular_') !== false) {
                    $formId = (string) Str::orderedUuid();
                    foreach ($userProducts as $userProduct) {
                        $newArray = array_merge($userProduct, ['form_id' => $formId]);
                        unset($newArray['id']);
                        $array[] = $newArray;
                    }
                } else {
                    foreach ($userProducts as $userProduct) {
                        unset($userProduct['id']);
                        $array[] = $userProduct;
                    }
                }
            }
            if (count($array) > 0) {
                DB::table('user_products')->insert($array);
            }
        }


    }

    /**
     * Delete User Products
     *
     * @param $userId
     * @return int
     */
    public function deleteUserProducts($userId): int
    {
        return DB::table('user_products')->where('user_id', $userId)->delete();
    }

    /**
     * Get User Products
     *
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public function getUserProducts($userId)
    {
        return DB::table('user_products')->where('user_id', $userId)->get();
    }


    /**
     * Get Existing User Products
     */
    public function getExistingProducts($newUserProducts, $existingUserProductIds): array
    {
        $array = [];
        foreach ($newUserProducts as $newUserProduct) {
            if (in_array($newUserProduct['id'], $existingUserProductIds)) {
                $array[] = $newUserProduct;
            }
        }
        return $array;
    }

    /**
     * Get New User Products
     */
    public function getNewProducts($newUserProducts, $existingUserProductIds): array
    {
        $array = [];
        foreach ($newUserProducts as $newUserProduct) {
            if (!in_array($newUserProduct['id'], $existingUserProductIds)) {
                $array[] = $newUserProduct;
            }
        }
        return $array;
    }


    /**
     * Get User Product Ids
     *
     * @param $userProducts
     * @return array
     */
    public function getUserProductIds($userProducts)
    {
        return array_map(function($userProduct) {
            return $userProduct['id'];
        }, $userProducts);
    }


    /**
     * Get Deleted User Product Ids
     */
    public function getDeletedUserProductIds($userProductIds, $newUserProductIds): array
    {
        return array_diff($userProductIds, $newUserProductIds);
    }

    /**
     * Get Object Collection In Array
     */
    public function getInArray($userProducts)
    {
        $array = [];

        foreach ($userProducts as $userProduct) {
            $array[] = (array) $userProduct;
        }

        return $array;
    }
}

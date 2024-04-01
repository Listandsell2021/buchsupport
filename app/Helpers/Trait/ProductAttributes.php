<?php


namespace App\Helpers\Trait;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait ProductAttributes
{
    public function convertToFormAttributes($userProductAttributes): array
    {
        $array = [];

        if (count($userProductAttributes) > 0) {

            $index = 0;

            foreach ($userProductAttributes->groupBy(['form_id']) as $formId => $form) {

                $array[$index]['id'] = $formId;
                $array[$index]['purchase_date'] = getDateByLocale($form->first()->purchased_date);
                $array[$index]['status'] = $form->first()->status;
                $array[$index]['form_order_no'] = $form->first()->form_order_no;
                $array[$index]['products'] = $this->getProducts($form);

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
     * Get Update Form Attributes
     *
     * @param int $userId
     * @param array $forms
     * @return void
     */
    public function updateUserProducts(int $userId, array $forms): void
    {
        $newUserProducts = [];

        $formOrderNo = 1;
        foreach ($forms as $form) {

            if (count($form['products']) > 0) {
                foreach ($form['products'] as $product) {
                    $newUserProducts[] = [
                        'id' => $product['id'],
                        'form_id' => $form['id'],
                        'user_id' => $userId,
                        'product_id' => $product['product_id'],
                        'note' => $product['note'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'condition' => $product['condition'],
                        'position' => $product['position'],
                        'form_order_no' => $formOrderNo,
                        'is_hidden' => 0,
                        'show_price' => $product['show_price'],
                        'show_purchase_date' => $product['show_purchase_date'],
                        'purchased_date' => date('Y-m-d', strtotime($form['purchase_date'])),
                        'status' => $form['status'],
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
                if (str_contains($formId, 'new_form_')) {
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
     * Get User Products
     *
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public function getUserProducts($userId): \Illuminate\Support\Collection
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
    public function getUserProductIds($userProducts): array
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
    public function getInArray($userProducts): array
    {
        $array = [];

        foreach ($userProducts as $userProduct) {
            $array[] = (array) $userProduct;
        }

        return $array;
    }
}

<?php

namespace App\Exports\Frontend;

use App\Models\Product;
use App\Models\UserProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return ['Product', 'Category', 'Price', 'Images', 'Images Path', 'Youtube ID', 'Description', 'Created At'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('images', 'category')->get();
    }
    public function map($product): array
    {
        $images = ['name' => '', 'path' => ''];

        $total_images = $product->images->count();
        $i = 1;
        foreach ($product->images as $image) {
            $images['name'] .= $image->name.($i != $total_images ? ', ' : '');
            $images['path'] .= $image->image_path.($i != $total_images ? ', ' : '');
            $i++;
        }

        $price = UserProduct::where('user_products.product_id', $product->id)->max('price');

        $category = !empty($product->category) ? $product->category->title : '';

        return [
            $product->title,
            $category,
            $price,
            $images['name'],
            $images['path'],
            $product->yt_link,
            $product->note,
            $product->created_at,
        ];
    }
}

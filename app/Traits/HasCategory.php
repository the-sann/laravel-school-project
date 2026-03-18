<?php

namespace App\Traits;

trait HasCategory
{
    public function getCategory()
    {
        return [
            'Electronics',
            'Clothing',
            'Accessories',
            'Furniture',
            'Food',
        ];
    }
}

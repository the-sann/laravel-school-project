<?php

namespace App\Traits;

trait HasNavs
{
    public function getNavs()
    {
        return [
            ['title' => 'Dashboard', 'url' => '/dashboard'],
            ['title' => 'Sale', 'url' => '/sales'],
            ['title' => 'Products', 'url' => '/products'],
            ['title' => 'Category', 'url' => '/categories'],
            ['title' => 'Supplier', 'url' => '/suppliers'],
            ['title' => 'Customer', 'url' => '/customers'],
            // ['title' => 'Setting', 'url' => '/settings'],
        ];
    }
}

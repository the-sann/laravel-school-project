<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    use \App\Traits\HasNavs;

    public function page($page = 'dashboard')
    {
        $navs = $this->getNavs();

        $page = strtolower($page);



        return view("home.$page", ['navs' => $navs]);
    }


    public function posts()
    {

        $navs = $this->getNavs();
        return view('home.posts', compact('navs'));
    }

    public function setting()
    {
        $navs = $this->getNavs();
        return view('home.setting', compact('navs'));
    }



    public function dashboard()
    {
        $products = Product::orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $availableStock = Product::sum('stock');
        $totalProducts = Product::count();
        $totalRevenue = Sale::sum('total_amount');
        $pendingRevenue = 0;
        $navs = $this->getNavs();

        return view('home.dashboard', compact(
            'navs',
            'products',
            'totalProducts',
            'availableStock',
            'totalRevenue',
            'pendingRevenue'
        ));
    }
}

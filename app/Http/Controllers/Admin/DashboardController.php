<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $title = 'dashboard';
        $total_purchases = Purchase::count();
        $total_categories = Category::count();
        $total_suppliers = Supplier::count();
        $count_ordrs=Order::count();
        $total_sales = Sale::count();

        $pieChart = app()->chartjs
                ->name('pieChart')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['اجمالي المشتريات', 'اجمالي الموردين','اجمالي المبيعات'])
                ->datasets([
                    [
                        'backgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'data' => [$total_purchases, $total_suppliers,$total_sales]
                    ]
                ])
                ->options([]);

        $total_expired_products = Purchase::count();
        $latest_sales = Sale::whereDate('created_at','=',Carbon::now())->get();
        $today_sales = Sale::whereDate('created_at','=',Carbon::now())->sum('total');
        return view('admin.dashboard',compact(
            'title','pieChart','total_expired_products',
            'latest_sales','today_sales','total_categories','count_ordrs'
        ));
    }
}

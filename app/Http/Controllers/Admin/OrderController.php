<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Orders';
        if ($request->ajax()) {
            $products = Order::with('user')->latest();
            return DataTables::of($products)
                ->addColumn('product',function($product){
                    $image = '';
                    if(!empty($product->purchase)){
                        $image = null;
                        if(!empty($product->purchase->image)){
                            $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->purchase->image).'" alt="image">
                            </span>';
                        }
                        return $product->purchase->product. ' ' . $image;
                    }
                })
                ->addColumn('user',function($product){
                    return $product->user->name;
                })

                ->addColumn('total_price',function($product){
                    return $product->total_price;
                })
//                ->addColumn('quantity',function($product){
//                    if(!empty($product->purchase)){
//                        return $product->quantity;
//                    }
//                })
//                ->addColumn('exp_date',function($product){
//                    if(!empty($product->purchase)){
//                        return date_format(date_create($product->exp_date),'d M, Y');
//                    }
//                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    $showDetailsbtn = '<a href="'.route("orders.show", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
//                    $showDetailsbtn = '<a data-id="'.$row->id.'" data-route="'.route('orders.show', $row->id).'" href="javascript:void(0)" id="showbtn"><button class="btn btn-primary"><i class="fas fa-eye-dropper"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-product')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn.' '.$showDetailsbtn;
                    return $btn;
                })
                ->rawColumns(['product','action'])
                ->make(true);
        }
        return view('admin.orders.index',compact(
            'title'
        ));
    }



    public function show(Order $order)
    {
//        dd($order);
        $title = 'Orders';
//        if ($request->ajax()) {
//            $products = Order::find($order);
//            dd($products);
//            return DataTables::of($order->details)
//                ->addColumn('product',function($product){
//                    $image = '';
//                    if(!empty($product->purchase)){
//                        $image = null;
//                        if(!empty($product->purchase->image)){
//                            $image = '<span class="avatar avatar-sm mr-2">
//                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->purchase->image).'" alt="image">
//                            </span>';
//                        }
//                        return $product->purchase->product. ' ' . $image;
//                    }
//                })
//                ->addColumn('user',function($product){
//                    return $product->user->name??"";
//                })
//
//                ->addColumn('total_price',function($product){
//                    return $product->total_price;
//                })
//                ->addColumn('quantity',function($product){
//                    if(!empty($product->purchase)){
//                        return $product->quantity;
//                    }
//                })
//                ->addColumn('exp_date',function($product){
//                    if(!empty($product->purchase)){
//                        return date_format(date_create($product->exp_date),'d M, Y');
//                    }
//                })
//                ->addColumn('action', function ($row) {
//                    $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
//                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
//                    $showDetailsbtn = '<a data-id="'.$row->id.'" data-route="'.route('orders.show', $row->id).'" href="javascript:void(0)" id="showbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
//                    if (!auth()->user()->hasPermissionTo('edit-product')) {
//                        $editbtn = '';
//                    }
//                    if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
//                        $deletebtn = '';
//                    }
//                    $btn = $editbtn.' '.$deletebtn.' '.$showDetailsbtn;
//                    return $btn;
//                })
//                ->rawColumns(['product','action'])
//                ->make(true);
//        }
        return view('admin.orders.details',compact(
            'title','order'
        ));
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Details;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\PurchaseOutStock;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'sales';
        if($request->ajax()){
            $sales = Sale::latest();
            return DataTables::of($sales)
                    ->addIndexColumn()
                    ->addColumn('product',function($sale){
                        $image = '';
                        if(!empty($sale->product)){
                            $image = null;
                            if(!empty($sale->product->image)){
                                $image = '<span class="avatar avatar-sm mr-2">
                                <img class="avatar-img" src="'.asset("storage/purchases/".$sale->product->purchase->image).'" alt="image">
                                </span>';
                            }
                            return $sale->product. ' ' . $image;
                        }
                    })
                    ->addColumn('total',function($sale){
                        return settings('app_currency','$').' '. $sale->total;
                    })
                    ->addColumn('date',function($row){
                        return date_format(date_create($row->created_at),'d M, Y');
                    })
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a href="'.route("sales.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sales.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                        if (!auth()->user()->hasPermissionTo('edit-sale')) {
                            $editbtn = '';
                        }
                        if (!auth()->user()->hasPermissionTo('destroy-sale')) {
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['product','action'])
                    ->make(true);

        }
        $products = Product::get();
        return view('admin.sales.index',compact(
            'title','products',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create sales';
        $products = Product::where('qty','>=',1)->get();
//        $products = Product::get();
        $customers =User::where('type','=','customer')->get();
        return view('admin.sales.create',compact(
            'title','products','customers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
//            'product'=>'required',
//            'quantity'=>'required|integer|min:1'
        ]);
//        $sold_product = Product::find($request->product);

        /**update quantity of
            sold item from
         purchases
        **/
//        $purchased_item = Purchase::find($sold_product->purchase->id);
//        $new_quantity = ($purchased_item->quantity) - ($request->quantity);
        $notification = '';
//        if (!($new_quantity < 0)){
//
//            $purchased_item->update([
//                'quantity'=>$new_quantity,
//            ]);
//
//            /**
//             * calcualting item's total price
//            **/
//            $total_price = ($request->quantity) * ($sold_product->price);
//            Sale::create([
//                'product_id'=>$request->product,
//                'quantity'=>$request->quantity,
//                'total_price'=>$total_price,
//            ]);
//
//            $notification = notify("تم بيع المنتج");
//        }


//        if($new_quantity <=1 && $new_quantity !=0){
            // send notification
//            $product = Purchase::where('quantity', '<=', 1)->first();
//            event(new PurchaseOutStock($product));
            // end of notification
//            $notification = notify("المنتج نفذ من المخزون!!!");

//        }
        $notification = notify("المنتج نفذ من المخزون!!!");
        $sal=  new   Sale();
        $sal->customer_id=$request->supplier;
        $sal->total=$request->total;
        $sal->doc_date=$request->doc_date;
        $sal->save();
        $products=$request->product_id;
        $qty=$request->qty;
        $price=$request->price;

        for($i=0 ;$i<count($products);$i++){
            $details= new Details();
            $details->doc_id=$sal->id;
            $details->is_sales=1;
            $details->product_id=$products[$i];
            $details->qty=$qty[$i];
            $details->price=$price[$i];
            $pro=Product::where('id','=',$products[$i])->get()->first();
            $pro->qty-=$qty[$i];
//            $pro->price = $price[$i] ;
            $pro->save();
            $details->save();
        }

        return redirect()->route('sales.index')->with($notification);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $title = 'edit sale';
        $products = Product::get();
        return view('admin.sales.edit',compact(
            'title','sale','products'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $this->validate($request,[
            'product'=>'required',
            'quantity'=>'required|integer|min:1'
        ]);
        $sold_product = Product::find($request->product);
        /**
         * update quantity of sold item from purchases
        **/
        $purchased_item = Purchase::find($sold_product->purchase->id);
        if(!empty($request->quantity)){
            $new_quantity = ($purchased_item->quantity) - ($request->quantity);
        }
        $new_quantity = $sale->quantity;
        $notification = '';
        if (!($new_quantity < 0)){
            $purchased_item->update([
                'quantity'=>$new_quantity,
            ]);

            /**
             * calcualting item's total price
            **/
            if(!empty($request->quantity)){
                $total_price = ($request->quantity) * ($sold_product->price);
            }
            $total_price = $sale->total_price;
            $sale->update([
                'product_id'=>$request->product,
                'quantity'=>$request->quantity,
                'total_price'=>$total_price,
            ]);

            $notification = notify("تم تحديث المنتج");
        }
        if($new_quantity <=1 && $new_quantity !=0){
            // send notification
            $product = Purchase::where('quantity', '<=', 1)->first();
            event(new PurchaseOutStock($product));
            // end of notification
            $notification = notify("المنتج ينفد من المخزون!!!");

        }
        return redirect()->route('sales.index')->with($notification);
    }

    /**
     * Generate sales reports index
     *
     * @return \Illuminate\Http\Response
     */
    public function reports(Request $request){
        $title = 'sales reports';
        return view('admin.sales.reports',compact(
            'title'
        ));
    }

    /**
     * Generate sales report form post
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $title = 'sales reports';
        $sales = Details::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->where('is_sales','=',1)->get();
        if ($sales->isEmpty()) {
            // Handle empty results (e.g., return an empty array or a message)
            $sales= []; // Or your desired empty response
        }
//        $sales = $sales->with('product');
        return view('admin.sales.reports',compact(
            'sales','title'
        ));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): \Illuminate\Http\Response
    {
        return Sale::findOrFail($request->id)->delete();
    }
}

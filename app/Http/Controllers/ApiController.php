<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public  function getCategories(): \Illuminate\Http\JsonResponse
    {
        $category['data']=Category::all();
        return response()->json($category);
    }
    public  function getProductByCategory(Request  $request): \Illuminate\Http\JsonResponse
    {

//        where('category_id','=',$request->cat_id)
if($request->has('cat_id')&&$request->cat_id!=0){
    $data['data']=Product::where('category_id','=',$request->cat_id)->get();
    return response()->json($data);
}else{


        $data['data']=Product::get();
        return response()->json($data);
}
    }

    public function getProductLast(): \Illuminate\Http\JsonResponse
    {
        // Assuming you want the 10 most recently created products
        $data['data'] = Product::latest()->take(5)->get();
        return response()->json($data);
    }

    public  function addToCart(Request  $request): \Illuminate\Http\JsonResponse
    {

        // return response()->json(Auth::user());
        if($request->id) {
            $id=$request->id;
            $qty=$request->qty;
            $product=Product::find($id);
            if ($request->qty) {
                $userId = Auth::id();
                // Assuming user is authenticated
                // Find the existing cart item for the user and product
              if($request->qty==0){
                $cartItem = Cart::where('product_id', $id)
                ->where('user_id', $userId)->delete();
           return response()->json(["message"=>"Deleted from cart"]);
              }
                if($id){
                $cartItem = Cart::where('product_id', $id)
                    ->where('user_id', $userId)
                    ->first();
                }
                if ($cartItem) {
                    // Update existing cart item quantity
                    $cartItem->quantity = $qty;
                    if($product){
                        $cartItem->total_price=$product->price*$qty;
                    }
                } else {
                    // Create a new cart item

                    $cartItem = new Cart;
                    $cartItem->product_id = $id;
                    $cartItem->user_id = $userId;
                    $cartItem->quantity = $qty;
                    if($product){
                        $cartItem->total_price=$product->price*$qty;
                    }
                   else{
                    return response()->json(['message'=>'No such product found'],422);
                   }
                }
                $cartItem->save();
                return response()->json($cartItem);
            }

        }else{
            $data['data']="not found  product";
            return response()->json( $data,422);
        }
        $data['data']="not found  product";
        return response()->json( $data,422);
    }
//        $validator = Validator::make(compact('id', 'quantity'), [
//            'id' => 'required|integer|exists:products,id',
//            'quantity' => 'required|integer|min:1',
//        ]);
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422); // Unprocessable Entity
//        }


    public  function getCart(): \Illuminate\Http\JsonResponse
    {
        $data=Cart::where('user_id','=',Auth::user()->id)->get();
        return response()->json($data);
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Additional validation for other fields (phone, address, etc.)
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'customer',
            // Other fields from the request
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(compact('user', 'token'), 200);
    }
    public function checkout(){

//        Auth::user()->id
        $carts=Cart::where('user_id','=',Auth::user()->id)->get();
        $total_price=0;
        if($carts!=null){
            $order=new Order();
            $order->user_id= Auth::user()->id;
            $order->total_price= $total_price;
            $order->status='new';
            $order->save();
            foreach ($carts as $item){
                $orderDetail=new OrderDetail();
                $orderDetail->order_id=$order->id;
                $orderDetail->product_id=$item->product_id;
                $product=Product::find($item->product_id);
                $product->qty-=$item->quantity;
                $product->save();
                $orderDetail->quantity=$item->quantity;
                $orderDetail->total_price=$item->total_price;
                $orderDetail->save();
                $item->delete();
                $total_price+=$item->total_price;
            }
            $order->total_price= $total_price;
            $order->save();
            // $carts->delete();
            $data['success']=true;
            $data['message']='order created successfully';
            return response()->json($data);
        }
//        dd()

    }

    public function getOrder(): \Illuminate\Http\JsonResponse
    {
        $orders=Order::where('user_id','=',Auth::user()->id)->get();
        $data[
            'data'
        ]=$orders;
        return response()->json($data);

    }
}

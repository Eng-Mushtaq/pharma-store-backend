<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
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
        $data['data']=Product::get();
        return response()->json($data);
    }

    public  function addToCart(Request  $request): \Illuminate\Http\JsonResponse
    {

        if($request->id) {
            $id=$request->id;
            $qty=$request->qty;
            if ($request->qty) {
                $userId = Auth::user()->id; // Assuming user is authenticated
                // Find the existing cart item for the user and product
                $cartItem = Cart::where('product_id', $id)
                    ->where('user_id', $userId)
                    ->first();

                if ($cartItem) {
                    // Update existing cart item quantity
                    $cartItem->quantity = $qty;
                } else {
                    // Create a new cart item
                    $cartItem = new Cart;
                    $cartItem->product_id = $id;
                    $cartItem->user_id = $userId;
                    $cartItem->quantity = $qty;
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



}

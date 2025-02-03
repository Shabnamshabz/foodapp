<?php
namespace App\Http\Controllers;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\category;
use App\Models\fooditems;
use App\Models\carttabledata;
use App\Models\payment;
use App\Models\orders;
use Illuminate\Support\Facades\DB; 


class customercontroller extends Controller
{
    public function customeregistration(Request $req)
    {
        $insert=new customer;
        $insert->customer_name=$req->post('c_name');
        $insert->customer_email=$req->post('c_email');
        $insert->customer_pass=$req->post('c_pass');
        $insert->customer_phno=$req->post('c_phno');
        $insert->save();
        // $user = customer::create($req->all());


        
        return response()->json(['status'=>'Success','message'=>'Customer registration succesfull','data'=>$insert]);


    }
    public function customerlogin(Request $req)
     {
        $logincredential=customer::where([['customer_email',$req->post('c_email')],['customer_pass',$req->post('c_pass')]])->first();
       if(!$logincredential)
       {
        return response()->json([
         'status'=>'failed',
         'message'=>'Incorrect email and password',
         'data'=>$logincredential
        ]);
       }
        $token=$logincredential->createToken('foodapp')->plainTextToken;
        return response()->json([
         'status'=>'success',
         'message'=>'customer login successfull',
         'data'=>$logincredential,
         'token'=>$token
        ]);

    }
    public function fetchauthcustomerdetails()
    {
        $custid=Auth()->user()->customer_id;
        $fetchcustomerdata=customer::where([['customer_id',$custid]])->first();
        return response()->json([
         'status'=>'success',
         'message'=>'current user details fetched',
         'data'=>$fetchcustomerdata
        ]);

    }

     public function fetchcategory() //to display all category
    {

       $fetchdata=category::all(); //accessed all content in model(table created)
        return response()->json([
            'status'=>true,
            'message'=>'fetchdata successfull',
            'data'=>$fetchdata
        ]);
    }
    public function fetchproductunder_category($categ_id)
    {
        $fetchproduct=fooditems::where([['categ_id',$categ_id]])->get();
         return response()->json([
            'status'=>true,
            'message'=>'fetchdata successfull',
            'data'=>$fetchproduct
        ]);
    }
    public function productdisplaymainpage($prod_id)
    {
        $fetchproduct=fooditems::where([['item_id',$prod_id]])->get();
         return response()->json([
            'status'=>true,
            'message'=>'fetchdata successfull',
            'data'=>$fetchproduct
        ]);
    }
    public function addtocart($prod_id, Request $req)
{
    // Fetch item details
    $fooditemdata = fooditems::where('item_id', $prod_id)->first();
    if (!$fooditemdata) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found'
        ], 404);
    }

    $custdata = Auth()->user();
    $cust_id = $custdata->customer_id;
    $quantity = $req->post('quantity');
    $price = $fooditemdata->item_price;
    $totalprice = $price * $quantity;

    // Check if item is already in cart
    $existingCartItem = carttabledata::where([
        ['item_id', '=', $prod_id],
        ['cust_id', '=', $cust_id]
    ])->first();

    if ($existingCartItem) {
        // Update existing item quantity and total price
        $existingCartItem->quantity += $quantity;
        $existingCartItem->totalprice = $existingCartItem->quantity * $price;
        $existingCartItem->save();

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully',
            'data' => $existingCartItem
        ]);
    } else {
        // Add new item to cart
        $insert = new carttabledata;
        $insert->item_id = $prod_id;
        $insert->cust_id = $cust_id;
        $insert->quantity = $quantity;
        $insert->totalprice = $totalprice;
        $insert->save();

        return response()->json([
            'status' => true,
            'message' => 'Item added to cart',
            'data' => $insert
        ]);
    }
}


public function decrementCartQuantity($prod_id)
{
    $cust_id = Auth()->user()->customer_id;

    // Find the cart item for the logged-in user and given product ID
    $cartItem = carttabledata::where([
        ['cust_id', $cust_id],
        ['item_id', $prod_id]
    ])->first();

    if (!$cartItem) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found in cart'
        ]);
    }

    if ($cartItem->quantity > 1) {
        // Decrease quantity by 1
        $cartItem->quantity -= 1;

        // Fetch item price
        $item = fooditems::where('item_id', $prod_id)->first();
        $cartItem->totalprice = $cartItem->quantity * $item->item_price;

        $cartItem->save();

        return response()->json([
            'status' => true,
            'message' => 'Quantity updated successfully',
            'data' => $cartItem
        ]);
    } else {
        // Remove item from cart if quantity is 1
        $cartItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}
public function incrementCartQuantity($prod_id)
{
    $cust_id = Auth()->user()->customer_id;

    // Find the cart item for the logged-in user and given product ID
    $cartItem = carttabledata::where([
        ['cust_id', $cust_id],
        ['item_id', $prod_id]
    ])->first();

    if (!$cartItem) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found in cart'
        ]);
    }

    if ($cartItem->quantity > 1) {
        // Decrease quantity by 1
        $cartItem->quantity += 1;

        // Fetch item price
        $item = fooditems::where('item_id', $prod_id)->first();
        $cartItem->totalprice = $cartItem->quantity * $item->item_price;

        $cartItem->save();

        return response()->json([
            'status' => true,
            'message' => 'Quantity updated successfully',
            'data' => $cartItem
        ]);
    } else {
        // Remove item from cart if quantity is 1
        $cartItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}


 public function displaycartofuser()
 {
    $custid=Auth()->user()->customer_id;
    $cartdata=DB::table('carttabledatas')->join('fooditems','carttabledatas.item_id','=','fooditems.item_id')->where([['cust_id',$custid]])->get();
    $totalprice=DB::table('carttabledatas')->where([['cust_id',$custid]])->sum('totalprice');
    return response()->json([
            'status'=>true,
            'message'=>'carttable fetch successfull',
            'data'=>$cartdata,
            'granttotal'=>$totalprice
        ]);
    
 }   


public function deletecartdata($cartid)
{
    $cartdata=carttabledata::where([['cart_id',$cartid]])->first();
     $cartdata->delete();
     return response()->json([
            'status'=>true,
            'message'=>'productdeleted',
            'data'=>$cartdata
        ]);

}
 public function signout()
    {
        $custdata=Auth()->user();
        $custdata->tokens()->delete();
        return response()->json([
            'status'=>'true',
            'message'=>'signout successfull',
            'data'=>$custdata
           ]);
    }

    public function updatecustomerdata(Request $req)
 {
    $custdata=Auth()->user();
    $custdata->customer_phno=$req->post('customer_phno');
    $custdata->save();
return response()->json([
            'status'=>'true',
            'message'=>'customer data updated successfully',
            'data'=>$custdata
           ]);

 }

 //from cartpage ,when we press proceed button to the payment page

 public function paymentpage(Request $req)
 {$insert=new payment;
  $c_id=Auth()->user()->customer_id;
  $insert->cust_id=$c_id;
  $insert->Totalprice=DB::table('carttabledatas')->where('cust_id',$c_id)->sum('totalprice');
  $insert->cardnumber=$req->post('card_no');
  $insert->expirydate=$req->post('exp_date');
  $insert->securitycode=$req->post('cvv');
  $insert->save();
  return response()->json([
            'status'=>'true',
            'message'=>'payment successfull',
            'data'=>$insert
           ]);

 }
 public function getPayments()
{
    $c_id = Auth()->user()->customer_id;
    $payments = Payment::where('cust_id', $c_id)->get();

    return response()->json([
        'status' => 'true',
        'message' => 'Payments fetched successfully',
        'data' => $payments
    ]);
}
 public function saveOrderDetailss()
{ $insert=new orders;
    // Retrieve the authenticated user’s customer_id
    $custid = Auth()->user()->customer_id;
    $insert->cust_id=$cust_id;
    $cartdata = DB::table('carttabledatas')
                  ->join('fooditems', 'carttabledatas.item_id', '=', 'fooditems.item_id')
                  ->where('cust_id', $custid)
                  ->get();
    $totalprice = DB::table('carttabledatas')->where('cust_id', $custid)->sum('totalprice');
     $insert->total_price=$totalprice;
     return response()->json([
            'status'=>'true',
            'message'=>'order successfull',
            'data'=>$insert,
            'fooditems'=> $cartdata
           ]);
    
}
public function saveOrderDetails()
{
    // Create a new order instance
    $insert = new orders; 

    // Retrieve the authenticated user’s customer_id
    $custid = Auth()->user()->customer_id;
    $insert->cust_id = $custid;

    // Fetch cart data
    $cartdata = DB::table('carttabledatas')
                  ->join('fooditems', 'carttabledatas.item_id', '=', 'fooditems.item_id')
                  ->where('cust_id', $custid)
                  ->get();

    // Calculate total price of the cart
    $totalprice = DB::table('carttabledatas')->where('cust_id', $custid)->sum('totalprice');
    $insert->total_price = $totalprice;

    // Save the order to the database
    $insert->save();

    // Optionally, you can delete cart items after placing the order
    DB::table('carttabledatas')->where('cust_id', $custid)->delete();

    // Return the response with order details and cart items
    return response()->json([
        'status' => 'true',
        'message' => 'Order placed successfully',
        'data' => $insert, // Order data (including order id)
        'fooditems' => $cartdata // Cart items being ordered
    ]);
}



}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\fooditems;

class admincontroller extends Controller
{
    public function categoryinsertion(Request $req)
    {
        

        $insert = new Category;
    $insert->category_name = $req->post('categ_name');

    // Check if the file exists
    if ($req->hasFile('categ_image')) {
        // Get the uploaded file
        $file = $req->file('categ_image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        // Store the file in the storage folder (public)
        $file->storeAs('public/category', $filename);

        // Copy the file to the public/category folder (accessible via the browser)
        $destinationPath = public_path('category');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true); // Create the folder if it doesn't exist
        }
        $file->move($destinationPath, $filename);

        // Generate the public URL for the file (accessible by the browser)
        $insert->category_image = asset('category/' . $filename);
    }

    // Save the category to the database
    $insert->save();
    $insert->save();
        return response()->json([
         'status'=>'success',
         'message'=>'category insertion successfull',
         'data'=>$insert
        ]);
    }

    public function categorydisplay()
    {
        $fetchdata=category::all();
        return response()->json([
         'status'=>'success',
         'message'=>'category insertion successfull',
         'data'=>$fetchdata
        ]);
    }
    public function fooditem_insertion(Request $req)
    {  
       $itemsdata=new fooditems;
       $itemsdata->categ_id=$req->post('categ_id');
       $itemsdata->item_name=$req->post('item_name');
       $itemsdata->item_price=$req->post('item_price');
       if($req->hasfile('item_image'))
       {
        $file=$req->file('item_image');
        $extension=$file->getClientOriginalExtension();
        $filename=time().'.'.$extension;
         $file->storeAs('public/fooditems',$filename);
        $destinationPath = public_path('fooditems');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true); 
        }
        $file->move($destinationPath, $filename);
        $itemsdata->item_image=asset('fooditems/' . $filename);
        }
        $itemsdata->save();
        $itemsdata->save();
        return response()->json([
         'status'=>'success',
         'message'=>'category insertion successfull',
         'data'=>$itemsdata
        ]);
       }
public function fetchallproducts()
    {
       $fetchallproducts=fooditems::all(); 
       return response()->json([
        'status'=>'true',
        'message'=>'successfully fetched',
        'data'=>$fetchallproducts
       ]);
    }
        
    }


 

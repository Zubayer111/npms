<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
           $fileName = $request->file('image')->getClientOriginalName();
           $request->file('image')->store('uploads', 
        ["disk" => "s3", "visibility" => "public"]);
            return response()->json(
                [
                    "message" => "Image uploaded successfully",
                    "url" => "https://s3.amazonaws.com/".env('AWS_BUCKET')."/uploads/".$fileName
                ]
            );
        }
    }
}

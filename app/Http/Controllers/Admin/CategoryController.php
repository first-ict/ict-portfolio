<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $category = new Category();
        $slug = Str::of($request->name)->slug('-');
        $category->name = $request->name;
        $category->slug = $slug;
        $category->order_by = rand(0 , 10);
        if ($request->status == 'true') {
            $category->status = true;
        }
        else{
            $category->status = false;
        }

        $category->save();

        return response()->json([
            "condition" => true,
            "message" => "The category has been created successfully.",
            "data" => $category
        ] , 200);
    }

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show($slug)
    {
        $category = Category::where('slug' , $slug)->first();
        return response()->json([
            "condition" => true,
            "data" => $category
        ] , 200);
    }

    public function update(Request $request , $slug)
    {

        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $category = Category::where('slug' , $slug)->first();

        if ($category) {
            $slug = Str::of($request->name)->slug('-');
            $category->name = $request->name;
            $category->slug = $slug;
            $category->order_by = rand(0 , 10);

            if ($request->status == 'true') {
                $category->status = true;
            }
            else{
                $category->status = false;
            }

            $category->update();

            return response()->json([
                "condition" => true,
                "message" => "The category has been updated successfully.",
                "data" => $category
            ] , 200);
        }
        else{
            return 'Error! Data not found.';
        }
    }

    public function destroy($slug)
    {
        $category = Category::where('slug' , $slug)->first();
        $category->delete();
        return response()->json([
            "condition" => true,
            "message" => "The category has been deleted successfully.",
        ] , 200);
    }
}

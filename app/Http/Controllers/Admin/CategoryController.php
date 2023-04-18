<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;
use Exception;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }
        $category = new Category();
        $category->slug = Str::of($request->name)->slug();
        $category->name = $request->name;
        $category->status = $request->status;
        if ($request->image_id) {
            $category->image_id = $request->image_id;
        }

        $category->save();

        return $this->success(new CategoryResource($category));
    }

    public function index()
    {
        return $this->success(CategoryResource::collection(Category::with('image')->get()), "All Cateogries");
    }

    public function show($slug)
    {
        try {
            $category = Category::where('slug' , $slug)->firstOrFail();
        } catch (Exception $e){
            return $this->error(["message"=> $e->getMessage()], 404);
        }
        $category = new CategoryResource(Category::where('slug' , $slug)->with('image')->first());
        return $this->success($category, "Category Detail");
    }

    public function update(Request $request , $category)
    {
        // return ;
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }

        $categoryData = Category::where('slug' , $category)->first();
        // $categoryData
        if ($categoryData) {
            $slug = Str::of($request->name)->slug('-');
            $categoryData->name = $request->name;
            $categoryData->status = $request->status;
            $categoryData->image_id = (int)$request->image_id;
            
            $categoryData->slug = $slug;
            if ($request->image_id) {
                $category->image_id = $request->image_id;
            }
            $categoryData->update();

            return $this->success(new CategoryResource($categoryData));
        }
        else{
            return $this->error(['message'=> "Category not found", 404]);
        }
    }

    public function destroy($slug)
    {
        try {
            $category = Category::where('slug' , $slug)->firstOrFail();
        } catch (Exception $e){
            return $this->error(["message"=> $e->getMessage()], 404);
        }
        $category->delete();
        return $this->response(null, [], 204, true);
    }
}

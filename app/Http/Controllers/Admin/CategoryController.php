<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
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
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 403);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->order_by = rand(0 , 10);
        $category->status = (bool)$request->status;

        $category->save();

        return $this->success(new CategoryResource($category));
    }

    public function index()
    {
            return $this->success(CategoryResource::collection(Category::all()));
    }

    public function show($slug)
    {
        try {
            $category = Category::where('slug' , $slug)->firstOrFail();
        } catch (Exception $e){
            return $this->error(["message"=> $e->getMessage()], 404);
        }
        $category = new CategoryResource(Category::where('slug' , $slug)->first());
        return $this->success($category);
    }

    public function update(Request $request , $slug)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'status' => 'boolean'
        ]);
        // return request()->all();
        if ($validator->fails()) {
            return $this->error($validator->errors(), 403);
        }

        $category = Category::where('slug' , $slug)->first();

        if ($category) {
            $slug = Str::of($request->name)->slug('-');
            $category->update($request->all());

            // $category->save();
            return $this->success(new CategoryResource($category));
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

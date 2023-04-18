<?php

namespace App\Http\Controllers\Admin;
use App\Models\Content;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ContentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use Exception;

class ContentController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'paragraph' => 'required',
            'image_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 403);
        }
        $content = new Content();
        $content->name = $request->name;
        $content->user_id = rand(1 , 10);
        $content->category_id = rand(1,10);
        $content->paragraph = $request->paragraph;
        $content->slug =Str::of($request->name)->slug("-");
        $content->image_id = $request->image_id;
        $content->save();
        return $this->success(new ContentResource($content), "Content Created");
    }
    public function index(){
        return $this->success(ContentResource::collection(Content::with('image')->get()),"All contents");
    }

    public function show( $slug){
        try{
            $content= Content::where('slug', $slug)->firstOrFail();
        }catch (Exception $e){
            return $this->error(["message" => $e->getMessage()]);
        }
        $content = new ContentResource(Content::where('slug',$slug)->first());
        return $this->success($content,"Content Detail");
    }

    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'paragraph' => 'required|string',
            'image_id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 403);
        }
        $content = Content::where('slug',$slug)->first();
        if($content){
            $slug = Str::of($request->name)->slug("-");
            $content->name = $request->name;
            $content->paragraph = $request->paragraph;
            $content->image_id = $request->image_id;
            $content->user_id = rand(1 , 10);
            $content->category_id = rand(1,10);
            $content->slug =$slug;
            $content->update();
            return $this->success(new ContentResource($content));
        }else{
            return $this->error(['message'=> "Category not found"],404);
        }
    }
    public function destroy($slug)
    {
        try{
            $content= Content::where('slug', $slug)->firstOrFail();
        }catch (Exception $e){
            return $this->error(["message" => $e->getMessage()],404);
        }
        $content->delete();
        return $this->response(null,[], 204, true);
    }
}

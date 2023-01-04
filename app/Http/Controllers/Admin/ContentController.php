<?php

namespace App\Http\Controllers\Admin;
use App\Models\Content;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Http\Resources\SliderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index(){
        return ContentResource::collection(Content::all());
    }

    public function show( $slug){
        $content= Content::where('slug', $slug)->first();
        return response()->json(
            [
                "con" => true,
                "data" => $content
            ],200
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "paragraph" => "required",
        ]);
        $content = new Content();
        $content->name = $request->name;
        $content->user_id = rand(1 , 10);
        $content->category_id = rand(1,10);
        $content->paragraph = $request->paragraph;
        $content->slug =Str::of($request->name)->slug("-");
        $content->save();
        return response()->json(
            [
                "con" => true,
                "message" => "Content has been created successfully"
            ],200
        );
    }
    public function update(Request $request, $slug)
    {
        $request->validate([
            "name" => "required",
            "paragraph" => "required",
        ]);

        $content = Content::where('slug',$slug)->first();

        $content->name =$request->name;
        $content->slug =Str::of($request->name)->slug("-");
        $content->user_id = $content->user_id;
        $content->category_id = $content->category_id;
        $content->paragraph = $request->paragraph;
        $content->update();

        return response()->json(
            [
                "con" => true,
                "data" => $content
            ],200
        );
    }
    public function destroy($slug)
    {
        $content = Content::where('slug', $slug)->first();
        $content->delete();
        return response()->json(
            [
                "con" => true,
                "message" => "Content has been deleted successfully"
            ],200
        );
    }
}

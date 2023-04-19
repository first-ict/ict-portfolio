<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Slider;
use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Http\Resources\ContentResource;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function getContents()
    {
        $contents = Content::with('image')->latest()->take(4)->get();
        return $this->response("Content List", $contents);
    }

    public function getAllContents()
    {
        $contents = ContentResource::collection(Content::latest()->paginate(6));
        return $this->success($contents, "All Contents");
    }
    public function getContent($slug)
    {
        try{
            $content= Content::where('slug', $slug)->firstOrFail();
        }catch (Exception $e){
            return $this->error(["message" => $e->getMessage()]);
        }
        $content = new ContentResource(Content::where('slug',$slug)->first());
        return $this->success($content,"Content Detail");
    }

    public function getCategories()
    {
        $categories = Category::with('image')->get();
        return $this->response("Categories List", $categories);
    }

    public function getSliders()
    {
        $sliders = SliderResource::collection(Slider::orderBy('order_by', 'asc')->active()->with('image')->get());
        return $this->success($sliders, "Sliders");
    }

    public function getContentsByCategory($id)
    {
        $contents = Content::latest()->where('category_id', $id)->with('image')->get();
        return $this->response("Content List", $contents);
    }

}

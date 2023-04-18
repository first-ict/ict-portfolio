<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Http\Resources\SliderResource;
use App\Models\Category;
use App\Models\Content;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function getContents()
    {
        $contents = Content::latest()->take(4)->get();
        return $this->response("Content List", $contents);
    }

    public function getAllContents()
    {
        $contents = ContentResource::collection(Content::latest()->paginate(4));
        return $this->success($contents, "All Contents");
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
        $contents = Content::latest()->where('category_id', $id)->paginate(12);
        return $this->response("Content List", $contents);
    }

}

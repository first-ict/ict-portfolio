<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
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

    public function getCategories()
    {
        $categories = Category::get();
        return $this->response("Categories List", $categories);
    }

    public function getSliders()
    {
        $sliders = Slider::orderBy('order_id', 'asc')->active()->get();
        return $this->response("Slider List", $sliders);
    }

    public function getContentsByCategory($id)
    {
        $contents = Content::latest()->where('category_id', $id)->paginate(12);
        return $this->response("Content List", $contents);   
    }

}

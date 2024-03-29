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
use App\Http\Resources\CategoryResource;
use App\Http\Resources\JobResource;
use App\Http\Resources\ServiceResource;
use App\Models\Job;
use App\Models\Service;

class HomeController extends BaseController
{
    public function getContents()
    {

        $contents = Content::with('image')->latest()->take(4)->get();
        return $this->response("Content List", $contents);
    }

    public function getAllContents()
    {
        $query = Content::latest();
        $query->when(request()->q , function($query) {
            foreach(explode(' ', request()->q) as $word) {
                $query->orWhere('name', 'like', "%$word%")->orWhere('slug', 'like', "%$word%")->orWhereHas('category', function($query) use ($word){
                    $query->where('name','like', "%$word%");
                });
            }
        });
        $contents = ContentResource::collection($query->paginate(6));
        return $this->success($contents, "All Contents");
    }
    public function getAllServices()
    {
        $services = ServiceResource::collection(Service::latest()->paginate(6));
        return $this->success($services, "All Services");
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
    public function getService($id)
    {
        try{
            $service= Service::where('id', $id)->firstOrFail();
        }catch (Exception $e){
            return $this->error(["message" => $e->getMessage()]);
        }
        $service = new ServiceResource(Service::where('id',$id)->first());
        return $this->success($service,"service Detail");
    }
    public function getCategories()
    {
        $categories = CategoryResource::collection(Category::with(['contents'=> function($query) {
            $query->orderBy('id','desc')->with('image')->get();
        }])->get());
        return $this->success($categories);
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

    public function getJobs()
    {
        return $this->success(JobResource::collection(Job::latest()->get()) , 'all jobs . . .');
    }

    public function getJob($job)
    {
        $data = Job::where('id' , $job)->first();
        if ($data) {
            return $this->success(new JobResource($data) , 'job');
        } else {
            return $this->error([] , 422 , 'not found');
        }
    }

}

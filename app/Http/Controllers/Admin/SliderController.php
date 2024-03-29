<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\File;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Resources\SliderResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use App\Http\Requests\SliderStoreRequest;

class SliderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->success(SliderResource::collection(Slider::with('image')->paginate(10)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderStoreRequest $request)
    {

                $slider = new Slider();
                $slider->image_id = $request->image_id;
                $slider->order_by = $request->order_by;
                if ($request->status == 'true') {
                    $slider->status = true;
                } else {
                    $slider->status = false;
                }
                $slider->save();

                return $this->success(new SliderResource($slider));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($slider)
    {
        try {
            $data = Slider::where('id', $slider)->firstOrFail();
        } catch (Exception $e) {
            return $this->error(["message" => $e->getMessage()], 404);
        }
        $result = new SliderResource(Slider::where('id', $slider)->first());
        return $this->success($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$slider)
    {
                $slider = Slider::where('id', $slider)->first();
                $slider->image_id = $request->image_id;
                $slider->order_by = $request->order_by;
                if ($request->status == 'true') {
                    $slider->status = true;
                } else {
                    $slider->status = false;
                }
                $slider->update();

                return response()->json([
                    'message' => 'oki',
                    'data'  => $slider
                ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($slider)
    {
        try {
            $slider = Slider::where('id', $slider)->firstOrFail();
        } catch (Exception $e) {
            return $this->error(['message' => $e->getMessage()], 404);
        }
        $slider->delete();
        return $this->success(SliderResource::collection(Slider::with('image')->paginate(10)));
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SliderStoreRequest;
use App\Http\Controllers\BaseController;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SliderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(SliderResource::collection(Slider::all()));
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
        $filename = time() . "_" . $request->file('file')->getClientOriginalName();

        
        $slider->image = request()->file('file')->storeAs('test', $filename);;
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
    public function update(SliderStoreRequest $request, $slider)
    {
        $confrim = $request->validated();

        $slider = Slider::where('id', $slider)->first();
        if ($slider) {
            $slider->update($request->all());
        } else {
            return $this->error(['message' => 'Slider not found'], 404);
        }
        return $this->response(null, [], 204, true);
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

        $path = storage_path('app/photos/' . $slider->image);
        unlink($path);
        $slider->delete();
        return $this->response(null, [], 204, true);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = SliderResource::collection(Slider::all());
        return response()->json([
            "data" => $sliders
        ], 200);
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
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'order_by' => 'required',
            'status' => 'required |'
        ]);
         $slider = new Slider();
         $filename = time()."_".$request->file('image')->getClientOriginalName();

         Storage::putFileAs(
            'photos',
            $request->file('image'),
            $filename
         );
         $slider->image = $filename;
          $slider->order_by = $request->order_by;
         if ($request->status == 'true') {
            $slider->status = true;
         }else{
            $slider->status = false;
         }
         $slider->save();
         return response()->json([
            'con' => true,
            'data'=> 'product has successfully created'
         ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {

        return response()->json([
            "data" =>$slider
        ], 200);
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
    public function update(Request $request, Slider $slider)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $path = storage_path('app/photos/'.$slider->image);
        unlink($path);
        $slider->delete();
        return response()->json([
            'con' => true,
            'data' => 'You have successfully deleted',
        ],200);
    }
}

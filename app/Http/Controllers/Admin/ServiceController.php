<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class ServiceController extends BaseController
{
    public function index()
    {
        return $this->success(ServiceResource::collection(Service::with('image')->get()) , 'fetched all services');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'paragraph' => 'required',
            'image_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }

        $service = new Service();
        $service->name = $request->name;
        $service->paragraph = $request->paragraph;
        $service->image_id = (int)$request->image_id;
        $service->save();
        return $this->success(new ServiceResource($service) , 'created');
    }

    public function show($id)
    {
        try {
            $service = Service::where('id' , $id)->firstOrFail();
        } catch (Exception $e){
            return $this->error(["message"=> 'there is no service'], 404);
        }
        $service = new ServiceResource(Service::where('id' , $id)->with('image')->first());
        return $this->success($service, "Service Detail");
    }

    public function update(Request $request , $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'paragraph' => 'required',
            'image_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }

        $serviceData = service::where('id' , $service)->first();
        if ($serviceData) {
            $serviceData->name = $request->name;
            $serviceData->paragraph = $request->paragraph;
            $serviceData->image_id = (int)$request->image_id;
            $serviceData->update();
            return $this->success(new ServiceResource($serviceData) , 'updated successfully');
        }
        else{
            return $this->error(['message'=> "service not found", 404]);
        }
    }

    public function destroy($id)
    {
        $service = Service::where('id' , $id)->first();
        if ($service) {
            $service->delete();
            return $this->response('deleted' , [] , null , 200 , true);
        } else {
            return 'there is no service';
        }

    }
}

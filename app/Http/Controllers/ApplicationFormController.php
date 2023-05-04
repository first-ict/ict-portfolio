<?php

namespace App\Http\Controllers;

use App\Models\Application_Form;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Application_FormResource;


class ApplicationFormController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Application_FormResource::collection(Application_Form::all());
        return $this->response('',$data,[]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'phone' => 'required',
            'email' => 'required',
            'cv_form' => 'required',
            'job_id' => 'required',
        ]);
        if($validator->fails())
        {
            return $this->error($validator->errors(), 422);
        }else{
            $filename = time() . "_" . $request->file('cv_form')->getClientOriginalName();
            $filename = request()->file('cv_form')->storeAs('cv_form', $filename);
            $application_Form = new Application_Form();
            $application_Form->name = $request->name;
            $application_Form->phone = $request->phone;
            $application_Form->email = $request->email;
            $application_Form->cv_form = $filename;
            $application_Form->job_id = $request->job_id;
            $application_Form->save();
            return response()->json
            ([
                'data' => $application_Form,
                'errors'=> [],
                'condition' => true
            ]);
        }
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application_Form  $application_Form
     * @return \Illuminate\Http\Response
     */
    public function show(Application_Form $application_Form)
    {
        return $this->response('',$applicaion_form,[]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application_Form  $application_Form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application_Form $application_Form)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'phone' => 'required',
            'email' => 'required',
            'cv_form' => 'required',
            'job_id' => 'required',
        ]);
        if($validator->fails())
        {
            return $this->error($validator->errors(), 422);
        }else{
            Storage::delete('cv_form/'.$applicaion_form->cv_form);
            $filename = time() . "_" . $request->file('cv_form')->getClientOriginalName();
            $filename = request()->file('cv_form')->storeAs('cv_form', $filename);
            $application_Form->name = $request->name;
            $application_Form->phone = $request->phone;
            $application_Form->email = $request->email;
            $application_Form->cv_form = $filename;
            $application_Form->job_id = $request->job_id;
            $application_Form->update();
            return response()->json
            ([
                'data' => $application_Form,
                'errors'=> [],
                'condition' => true
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application_Form  $application_Form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application_Form $application_Form)
    {
        Storage::delete('cv_form/'.$applicaion_form->cv_form);
        $applicaion_form->delete();
        return $this->response('',[],[]);
    }
}

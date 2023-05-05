<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApplicationFormResource;

class ApplicationFormController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(ApplicationFormResource::collection(ApplicationForm::all()),"Jobs");
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'phone' => 'required|numeric',
            'email' => 'required|email|email|unique:application_forms',
            'cv_form' => 'required|mimes:pdf',
            'job_id' => 'required'
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors());
        }
        $cv_formname = time() . "_" . $request->file('cv_form')->getClientOriginalName();
        $cv_form = request()->file('cv_form')->storeAs('cv_forms', $cv_formname);
        $applicationForm = new ApplicationForm();
        $applicationForm->name = $request->name;
        $applicationForm->phone = $request->phone;
        $applicationForm->email = $request->email;
        $applicationForm->cv_form = $cv_form;
        $applicationForm->job_id = $request->job_id;
        $applicationForm->save();
        return $this->success(new ApplicationFormResource($applicationForm),"success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicationForm  $applicationForm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            ApplicationForm::where('id',$id)->firstOrFail();
        } catch (Exception $e ) {
            return $this->error(["message" => $e->getMessage()]);
        }
        $applicationForm = new ApplicationFormResource(ApplicationForm::where('id',$id)->first());
        return $this->success($applicationForm,"has found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicationForm  $applicationForm
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationForm $applicationForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationForm  $applicationForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationForm $applicationForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicationForm  $applicationForm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $applicationForm= ApplicationForm::where('id', $id)->firstOrFail();
        }catch (Exception $e){
            return $this->error(["message" => $e->getMessage()],404);
        }
        $cv_formname = ApplicationForm::where('id',$id)->first()->cv_form;
        $cv_form = storage_path('app/'.$cv_formname);
        unlink($cv_form);
        $applicationForm->delete();
        return response()->json([
            "condition" => true,
            "message" => "deleted . . ."
        ]);
    }
}

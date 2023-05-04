<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\JobResource;

class JobController extends  BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =JobResource::collection(Job::all());
        return $this->response('all job',$data,[]);
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
            'post' => 'required',
            'description' => 'required',
            'requirement' => 'required',
            'contact' => 'required',
        ]);
        if($validator->fails())
        {
            return $this->error($validator->errors(), 403);
        }else{
            Job::create($request->all());
            return response()->json
            ([
                'data' => ['user'=>$user,'token' => $token],
                'errors'=> [],
                'condition' => true
            ]);
        }
           
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return $this->response('job show',$job,[]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'post' => 'required',
            'description' => 'required',
            'requirement' => 'required',
            'contact' => 'required',
        ]);
        if($validator->fails())
        {
            return $this->error($validator->errors(), 422);
        }else{
           $job->name = $request->name;
           $job->description = $request->description;
           $job->post = $request->post;
           $job->requirement = $request->requirement;
           $job->contact = $request->contact;
           $job->update();
            return response()->json
            ([
                'data' => ['user'=>$user,'token' => $token],
                'errors'=> [],
                'condition' => true
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return $this->response('',$job,[]);
    }
}

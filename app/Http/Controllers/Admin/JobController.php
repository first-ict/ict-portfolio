<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use Exception;
use Illuminate\Support\Facades\Validator;

class JobController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(JobResource::collection(Job::all()),"Jobs");
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
            'post' => 'required|integer',
            'description' => 'required',
            'requirement' => 'required',
            'contact' => 'required'
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors());
        }
        $job = new Job();
        $job->name = $request->name;
        $job->post = $request->post;
        $job->description = $request->description;
        $job->requirement = $request->requirement;
        $job->contact = $request->contact;
        $job->save();
        return $this->success(new JobResource($job),"success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            Job::where('id',$id)->firstOrFail();
        } catch (Exception $e ) {
            return $this->error(["message" => $e->getMessage()]);
        }
        $job = new JobResource(Job::where('id',$id)->first());
        return $this->success($job,"has found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'post' => 'required|integer',
            'description' => 'required',
            'requirement' => 'required',
            'contact' => 'required'
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors());
        }
        $job = Job::where('id',$id)->first();
        if($job){
            $job->name = $request->name;
            $job->post = $request->post;
            $job->description = $request->description;
            $job->requirement = $request->requirement;
            $job->contact = $request->contact;
            $job->update();
            return $this->success(new JobResource($job),"success");
        }else {
            return $this->error(['message'=> "Job not found"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $job= Job::where('id', $id)->firstOrFail();
        }catch (Exception $e){
            return $this->error(["message" => $e->getMessage()],404);
        }
        $job->delete();
        return $this->response(null,[], 204, true);
    }
}

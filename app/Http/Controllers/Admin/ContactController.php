<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ContactResource;



class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $contact = ContactResource::collection( Contact::all());
      return $this->response('all contact',$contact);
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
            'name' => 'required|max:30',
            'email' => 'required|email',
            'phone_no' => 'required|min:11|max:11
            ',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }else{
            $contact =  Contact::create($request->all());
            return $this->response('',$contact,[]);     
        }
    }

    public function delete(Contact $contact)
    {
        $contact->delete();
        $contact = ContactResource::collection( Contact::all());
        return $this->response('all contact',$contact);
      }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\addressbook;
use App\Models\city;
use View;
use DB;
use Validator;

class AddressBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $addressbook = addressbook::latest()->paginate(2);
        $city = city::pluck('name','id');
        return View::make('listing')
            ->with('addressbook', $addressbook)
            ->with('city', $city);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = city::pluck('name','id');
        return View::make('add')->with('city', $city);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{

            $validation_messages = [
              'mimes' => 'Supported file format for :attribute are :mimes',
              'max'      => 'The :attribute must have a maximum length of :max',
              'dimensions' => 'The :attribute must have dimensions  width is :max_width and height is :max_height',
            ];

            $validatedData = Validator::make($request->all(), [
              'firstName' => 'required',
              'lastName' => 'required',
              'email' => 'required|email|unique:addressbooks',
              'phone' => 'required|digits:10',
              'image'=>'image|mimes:jpeg,png,jpg,gif,webp,svg|max:300|dimensions:max_width=150,max_height=150'
            ],$validation_messages);
            if($validatedData->fails()) {
              // return $validatedData->errors();
                return redirect('/addressbook/create')
                    ->withErrors($validatedData)
                    ->withInput();
            }
            if($request['image']){
                $imageName = time().'.'.$request['image']->extension();  
         
                $request['image']->move(public_path('images'), $imageName);
                $request['profilePic'] = $imageName;
            }
            $request['slug'] = $request['email'];
            $allData = $request->all();
            $show = addressbook::create($allData);
            // $message = 'Hello '.$request['firstName'].' '.$request['lastName'].'\n';
            // // $message .= 'Your Address Book Details\n';
            // $message .= 'Name : '.$request['firstName'].' '.$request['lastName'].'\n';
            // $message .= 'Email :'.$request['email'].'\n';
            // $message .= 'phone :'.$request['phone'].'\n';
            // $message .= 'street :'.$request['street'].'\n';
            // $message .= 'zipcode :'.$request['zipcode'].'\n';
            // $headers = 'From: ' . 'webmaster@example.com' . "\r\n" .'Reply-To: ' . 'webmaster@example.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            // $message = wordwrap($message,70);
            // mail($request['email'],"Address Book Detail",$message,$headers);
            
            DB::commit();
            return redirect('/addressbook')->with('success', 'Addressbook is successfully Added');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('/addressbook/create')->with('error','Something went wrong!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addressbook = addressbook::find($id);
        $city = city::pluck('name','id');
        return View::make('edit')
            ->with('addressbook', $addressbook)
            ->with('city', $city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $validation_messages = [
              'mimes' => 'Supported file format for :attribute are :mimes',
              'max'      => 'The :attribute must have a maximum length of :max',
              'dimensions' => 'The :attribute must have dimensions  width is :max_width and height is :max_height',
            ];
            $validatedData = Validator::make($request->all(), [
              'firstName' => 'required',
              'lastName' => 'required',
              'email' => 'required|email|unique:addressbooks,email,'.$id.',slug',
              'phone' => 'required|digits:10',
              'image'=>'image|mimes:jpeg,png,jpg,gif,webp,svg|max:300|dimensions:max_width=150,max_height=150',
            ],$validation_messages);
            if($validatedData->fails()) {
                return redirect('/addressbook/'.$id.'/edit')
                    ->withErrors($validatedData)
                    ->withInput();
            }

            $request['slug'] = $request['email'];
            $addressbook = addressbook::find($id);
            $addressbook->firstName = $request['firstName'];
            $addressbook->lastName = $request['lastName'];
            $addressbook->email = $request['email'];
            $addressbook->phone = $request['phone'];
            $addressbook->zipcode = $request['zipcode'];
            $addressbook->city_id = $request['city_id'];
            $addressbook->street = $request['street'];
            if($request['image']){
                unlink(public_path('images').'/'.$addressbook->profilePic);
                $imageName = time().'.'.$request['image']->extension();  
                $request['image']->move(public_path('images'), $imageName);
                $addressbook->profilePic = $imageName;
            }
            $addressbook->save();            
            DB::commit();
            return redirect('/addressbook')->with('success', 'Addressbook is successfully update');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('/addressbook/'.$id.'/edit')->with('error','Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $addressbook = addressbook::find($id);
        if($addressbook->profilePic){
            unlink(public_path('images').'/'.$addressbook->profilePic);
        }

        $addressbook->delete();
        return redirect('/addressbook')->with('success', 'Addressbook is successfully Deleted');
    }
}

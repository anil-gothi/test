<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function event_index()
    {
        $eventModel = new Event();
        $form_data = [];
        $data['event_form'] = view('event_form',$form_data)->render();
        $data['event_data'] = $eventModel->get_event_list();
        return view('event_index',$data);
    }
    function add_update_event(Request $request)
    {
        $rules['title'] = 'required';
        $rules['start_date'] = 'required';
        $rules['end_date'] = 'required';
        $this->validate($request,$rules);
        $eventModel = new Event();
        $response = $eventModel->add_update_event($request);
        Session::flash('alert-success', 'Event added successfully.');
        return response()->json(['status' => 200,'msg' => 'Event added successfully.'],200);
    }
    function edit_event(Request $request)
    {
        $form_data['data'] = Event::find($request->id);
        $html =  view('event_form',$form_data)->render();
        return response()->json(['status' => 200,'html' => $html],200);
    }
    function delete_event(Request $request)
    {
        Event::destroy($request->id);
        Session::flash('alert-success', 'Event deleted successfully.');
        return response()->json(['status' => 200,'msg' => 'Event deleted successfully.'],200);
    }
}

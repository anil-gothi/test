<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['id'];
    function add_update_event($request)
    {
        $id = isset($request->id) && !empty($request->id)?$request->id:0;
        $obj = Event::firstOrNew(['id' => $id]);
        $obj->title = $request->title;
        $obj->start_date = $request->start_date;
        $obj->end_date = $request->end_date;
        $obj->recurrence_flag = $request->recurrence_flag;
        if($request->recurrence_flag == 0)
        {
            $obj->repeat_on_the_flag_1 = "";
            $obj->repeat_on_the_flag_2 = "";
            $obj->repeat_on_the_flag_3 = "";
            $obj->repeat_flag_1 = $request->repeat_flag_1;
            $obj->repeat_flag_2 = $request->repeat_flag_2;
        }
        else{
            $obj->repeat_flag_1 = "";
            $obj->repeat_flag_2 = "";
            $obj->repeat_on_the_flag_1 = $request->repeat_on_the_flag_1;
            $obj->repeat_on_the_flag_2 = $request->repeat_on_the_flag_2;
            $obj->repeat_on_the_flag_3 = $request->repeat_on_the_flag_3;
        }
        $obj->save();

    }
    function get_event_list()
    {
        $data = Event::orderBy('id','DESC')->paginate(10);
        return $data;
    }
}

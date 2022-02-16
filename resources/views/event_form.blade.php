@php
$repeat_flag_1_arr = ['Every','Every Other','Every Third','Every Fourth'];
$repeat_flag_2_arr = ['Day','Week','Month','Year'];
$repeat_on_the_flag_1_arr = ['First','Second','Third','Fourth'];
$repeat_on_the_flag_2_arr = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
$repeat_on_the_flag_3_arr = ['Month','3 Months','6 Months','Year'];
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> @if(isset($data->id) && !empty($data->id)) Edit @else Add @endif Event</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="event_form" >
    @csrf
<div class="modal-body">
    @if(isset($data->id) && !empty($data->id))
        <input type="hidden" name="id" value="{{ $data->id }}" >
    @endif
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" autocomplete="off" name="title" @if(isset($data->title)) value="{{ $data->title }}" @endif placeholder="Enter event title">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="text" class="form-control" autocomplete="off" name="start_date" id="start_date" @if(isset($data->start_date)) value="{{ $data->start_date }}" @endif placeholder="Start Date">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="text" class="form-control" autocomplete="off" name="end_date" id="end_date" @if(isset($data->end_date)) value="{{ $data->end_date }}" @endif placeholder="End Date">
        </div>
        <div class="mb-3">
            <label for="recurrence_flag1" class="form-label">Recurrence</label>
            <div class="form-check">
                <input class="form-check-input" 
                type="radio"  
                @if(isset($data->id) && !empty($data->id))
                    @if($data->recurrence_flag == 0)
                    checked
                    @endif
                @else
                checked
                @endif
                name="recurrence_flag" value="0" id="recurrence_flag1">
                <label class="form-check-label" for="recurrence_flag1">
                    Repeat
                </label>
            </div>
        </div>
        <div class="mb-3">
            <select class="form-select" name="repeat_flag_1" id="repeat_flag_1">
                @foreach ($repeat_flag_1_arr as $key => $value)
                <option @if(isset($data->repeat_flag_1) && $data->repeat_flag_1 == $value) selected  @endif value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

        </div>
        <div class="mb-3">
            <select class="form-select" name="repeat_flag_2" id="repeat_flag_2">
                @foreach ($repeat_flag_2_arr as $key => $value)
                <option @if(isset($data->repeat_flag_2) && $data->repeat_flag_2 == $value) selected  @endif value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <hr>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" @if(isset($data->recurrence_flag) && $data->recurrence_flag == 1) checked  @endif  name="recurrence_flag" id="recurrence_flag2" value="1">
                <label class="form-check-label" for="recurrence_flag2">
                    Repeat on the
                </label>
            </div>
        </div>
        <div class="mb-3">
            <select class="form-select" name="repeat_on_the_flag_1" id="repeat_on_the_flag_1">
                @foreach ($repeat_on_the_flag_1_arr as $key => $value)
                <option @if(isset($data->repeat_on_the_flag_1) && $data->repeat_on_the_flag_1 == $value) selected  @endif value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-select" name="repeat_on_the_flag_2" id="repeat_on_the_flag_2">
                @foreach ($repeat_on_the_flag_2_arr as $key => $value)
                <option @if(isset($data->repeat_on_the_flag_2) && $data->repeat_on_the_flag_2 == $value) selected  @endif value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-select" name="repeat_on_the_flag_3" id="repeat_on_the_flag_3">
                @foreach ($repeat_on_the_flag_3_arr as $key => $value)
                <option @if(isset($data->repeat_on_the_flag_3) && $data->repeat_on_the_flag_3 == $value) selected  @endif value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

    
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
</div>
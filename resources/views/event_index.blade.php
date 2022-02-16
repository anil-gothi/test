<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    </link>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Event Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                </ul>
                <form class="d-flex">

                    <a class="btn btn-outline-success" href="javascript:void(0)" onclick="show_add_event_modal()">Add Event</a>
                </form>
            </div>
        </div>
    </nav>
    <div class="flash-message">

        @if(Session::has('alert-success'))
        <p class="alert alert-success">{{ Session::get('alert-success') }}</p>
        @endif

    </div>

    @if(isset($event_data) && !empty($event_data))
    <table class="table">
        <thead>
            <tr>

                <th scope="col">Title</th>
                <th scope="col">Date</th>
                <th scope="col">Occurrence</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($event_data as $key => $value)
            <tr>

                <td>{{ $value->title }}</td>
                <td>{{ $value->start_date }} to {{ $value->end_date }}</td>
                <td>
                    @if($value->recurrence_flag == 0)
                    {{ $value->repeat_flag_1.' '.$value->repeat_flag_2  }}
                    @else
                    {{ $value->repeat_on_the_flag_1.' '.$value->repeat_on_the_flag_2.' '.$value->repeat_on_the_flag_3  }}
                    @endif
                </td>
                <td>
                    <a class="btn btn-outline-primary" onclick="View_event_data('{{ $value->title }}','{{ $value->start_date }}','{{ $value->end_date }}','{{ $value->recurrence_flag }}','{{ $value->repeat_flag_1 }}','{{ $value->repeat_flag_2 }}','{{ $value->repeat_on_the_flag_1 }}','{{ $value->repeat_on_the_flag_2 }}','{{ $value->repeat_on_the_flag_3 }}')">View</a>
                    <a class="btn btn-outline-primary" onclick="edit_event('{{ $value->id }}')">Edit</a>
                    <a class="btn btn-outline-primary" onclick="delete_event('{{ $value->id }}')">Delete</a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    {{ $event_data->render() }}
    @endif

    <div class="modal fade" id="event_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="event_modal_body">

            </div>
        </div>
    </div>
    <div class="modal fade" id="show_event_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabela" id="event_view_title"> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>

                                <th scope="col">Date</th>
                                <th scope="col">Date Name</th>

                            </tr>
                        </thead>
                        <tbody id="event_view_body">

                        </tbody>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    @csrf
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ url('/public/assets/') }}/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
    <script>
        function form_validation() {
            $("#event_form").validate({
                rules: {
                    title: {
                        required: false,
                        maxlength: 250,
                    },
                    start_date: {
                        required: false,
                    },
                    end_date: {
                        required: false,
                    },
                },
                errorPlacement: function(label, element) {

                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
                highlight: function(element, errorClass) {
                    $(element).parent().addClass('has-danger')
                    $(element).addClass('form-control-danger')
                },
                submitHandler: function(form, event) {
                    if (!this.beenSubmitted) {
                        event.preventDefault();
                        ajax_form_submit();

                    }
                }
            });
        }

        function ajax_form_submit() {
            var data = $('#event_form').serialize();
            $.ajax({
                url: "{{ route('add_update_event_form') }}",
                method: "POST",
                dataType: "JSON",
                data: data,
                success: function(response) {
                    location.reload();
                },
                error: function(reject) {
                    if (reject.status == 422) {
                        var error_text = "";
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(key, val) {
                            error_text += val[0] + " ";
                        });
                        alert(error_text);
                    } else {
                        var error = reject.responseText;
                        alert(error);
                    }
                }
            });
        }

        function show_date_picker() {
            $("#start_date").datepicker({
                todayBtn: 1,
                autoclose: true,
                format: 'yyyy-mm-dd',
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#end_date').datepicker('setStartDate', minDate);
            });

            $("#end_date").datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                })
                .on('changeDate', function(selected) {
                    var maxDate = new Date(selected.date.valueOf());
                    $('#start_date').datepicker('setEndDate', maxDate);
                });
        }

        function show_add_event_modal() {
            $('#event_modal').modal('show');
            $('#event_modal_body').append(`{!! $event_form !!}`);
            show_date_picker();
            form_validation();
        }

        function edit_event(event_id) {
            $.ajax({
                url: "{{ route('edit_event') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: event_id,
                    _token: $("input[name=_token]").val()
                },
                success: function(response) {
                    $('#event_modal').modal('show');
                    $('#event_modal_body').html(response.html);
                    show_date_picker();
                    form_validation();
                },
                error: function(reject) {
                    if (reject.status == 422) {
                        var error_text = "";
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(key, val) {
                            error_text += val[0] + " ";
                        });
                        alert(error_text);
                    } else {
                        var error = reject.responseText;
                        alert(error);
                    }
                }
            });
        }
        var getDaysBetweenDates = function(startDate, endDate, recurrence_flag, repeat_flag_1, repeat_flag_2, repeat_on_the_flag_1, repeat_on_the_flag_2, repeat_on_the_flag_3) {
            console.log(recurrence_flag);
            console.log(repeat_flag_1);
            console.log(repeat_flag_2);
            console.log(repeat_on_the_flag_1);
            console.log(repeat_on_the_flag_2);
            console.log(repeat_on_the_flag_3);
            var now = startDate.clone(),
                dates = [];
            $('#event_view_body').empty();
            while (now.isSameOrBefore(endDate)) {

                if (recurrence_flag == 0) {
                    var date_range = 1;
                    if (repeat_flag_1 == 'Every') {
                        date_range = 1;
                    } else if (repeat_flag_1 == 'Every Other') {
                        date_range = 2;
                    } else if (repeat_flag_1 == 'Every Third') {
                        date_range = 3;
                    } else if (repeat_flag_1 == 'Every Fourth') {
                        date_range = 4;
                    }
                    var date_range_format = 'days';

                    if (repeat_flag_2 == 'Week') {
                        date_range_format = 'week';
                    } else if (repeat_flag_2 == 'Month') {
                        date_range_format = 'month';
                    } else if (repeat_flag_2 == 'Year') {
                        date_range_format = 'year';
                    }
                    let show_date_name = now.format('dddd');
                    var show_date = now.format('MM/DD/YYYY');

                    dates.push(now.format('MM/DD/YYYY'));
                    $('#event_view_body').append(` <tr>

                    <td>` + show_date + `</td>
                    <td>` + show_date_name + `</td>
                        </tr>>
                    `);
                    now.add(date_range, date_range_format);


                } else {

                    var date_range = 1;
                    if (repeat_on_the_flag_1 == 'First') {
                        date_range = 1;
                    } else if (repeat_on_the_flag_1 == 'Second') {
                        date_range = 2;
                    } else if (repeat_on_the_flag_1 == 'Third') {
                        date_range = 3;
                    } else if (repeat_on_the_flag_1 == 'Fourth') {
                        date_range = 4;
                    }
                    var date_range_format = 'month';
                    date_range = 1;
                    if (repeat_on_the_flag_3 == '3 Months') {
                        date_range = 3;
                    } else if (repeat_flag_2 == '6 Months') {
                        date_range = 6;
                    } else if (repeat_flag_2 == 'Year') {
                        date_range_format = 'year';
                        date_range = 1;
                    }

                    var day_value = 0;
                    if(repeat_on_the_flag_2 == 'Sun')
                        day_value = 0;
                    else if (repeat_on_the_flag_2 == 'Mon')
                        day_value = 1;
                    else if (repeat_on_the_flag_2 == 'Tue')
                        day_value = 2;
                    else if (repeat_on_the_flag_2 == 'Wed')
                        day_value = 3;
                    else if (repeat_on_the_flag_2 == 'Thu')
                        day_value = 4;
                    else if (repeat_on_the_flag_2 == 'Fri')
                        day_value = 5;
                    else if (repeat_on_the_flag_2 == 'Sat')
                        day_value = 6;
                   
                    console.log(repeat_on_the_flag_2);
                    console.log(day_value);
                    var show_date = now.format('MM/DD/YYYY');
                    let show_date_name = moment(show_date).day(day_value).format('dddd');
                    show_date = moment(show_date).day(0).format('MM/DD/YYYY');
                    dates.push(now.format('MM/DD/YYYY'));
                    $('#event_view_body').append(` <tr>

                    <td>` + show_date + `</td>
                    <td>` + show_date_name + `</td>
                        </tr>>
                    `);
                    now.add(date_range, date_range_format);
                }

            }
            return dates;
        };

        function View_event_data(title, start_date, end_date, recurrence_flag, repeat_flag_1, repeat_flag_2, repeat_on_the_flag_1, repeat_on_the_flag_2, repeat_on_the_flag_3) {
            $('#event_view_title').text(title);
            var startDate = moment(start_date);
            var endDate = moment(end_date);
            console.log(repeat_on_the_flag_1);
            console.log(repeat_on_the_flag_2);
            console.log(repeat_on_the_flag_3);
            var dateList = getDaysBetweenDates(startDate, endDate, recurrence_flag, repeat_flag_1, repeat_flag_2, repeat_on_the_flag_1, repeat_on_the_flag_2, repeat_on_the_flag_3);
            $('#show_event_modal').modal('show');
        }
        function delete_event(event_id)
        {
            if(confirm("Do you want to delete event"))
            {
                $.ajax({
                url: "{{ route('delete_event') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: event_id,
                    _token: $("input[name=_token]").val()
                },
                success: function(response) {
                    location.reload();
                },
                error: function(reject) {
                    if (reject.status == 422) {
                        var error_text = "";
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(key, val) {
                            error_text += val[0] + " ";
                        });
                        alert(error_text);
                    } else {
                        var error = reject.responseText;
                        alert(error);
                    }
                }
            });
            }
        }
    </script>
</body>

</html>
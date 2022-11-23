@extends('layouts.primary')

@section('content')

    <div class="row">
        <div class="col">
            <h5 class="text-secondary">{{__('Tasks')}}</h5>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-info" id="btn_add_new_category">
                {{__(' Add Task ')}}
            </button>
        </div>
    </div>

    <div>
        <div class="card">
            @switch($view_type)

                @case('list')
                @include('tasks.tabs.list_view')
                @break
            @endswitch
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            "use strict";

            @if($view_type === 'list')

            flatpickr("#start_date", {

                dateFormat: "Y-m-d",
            });

            flatpickr("#due_date", {

                dateFormat: "Y-m-d",
            });

            let $btn_submit = $('#btn_submit');
            let $form_main = $('#form_main');
            let $sp_result_div = $('#sp_result_div');

            $form_main.on('submit', function (event) {
                event.preventDefault();
                $btn_submit.prop('disabled', true);
                $.post('{{route('admin.tasks.save',['action' => 'task'])}}', $form_main.serialize()).done(function () {
                    location.reload();
                }).fail(function (data) {
                    let obj = $.parseJSON(data.responseText);
                    $btn_submit.prop('disabled', false);
                    let html = '';
                    $.each(obj.errors, function (key, value) {
                        html += '<div class="alert bg-pink-light text-danger">' + value + '</div>'
                    });

                    $sp_result_div.html(html);

                });

            });

            let myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), {
                keyboard: false
            });


            $('.category_edit').on('click', function (event) {
                event.preventDefault();
                $.getJSON('{{route('admin.tasks',['action' => 'task.json'])}}?id=' + $(this).data('id'), function (data) {
                    $('#input_name').val(data.subject);
                    $('#start_date').val(data.start_date);
                    $('#due_date').val(data.due_date);
                    $('#contact_id').val(data.contact_id);
                    $('#description').val(data.description);
                    $('#task_id').val(data.id);
                });

                myModal.show();

            });

            $('#btn_add_new_category').on('click', function () {
                $('#input_name').val('');
                $('#task_id').val('');
                $('#start_date').val('');
                $('#due_date').val('');
                $('#contact_id').val('');
                $('#description').val('');

                myModal.show();
            });


            $('.change_task_status').on('click', function () {
                $.post('{{route('admin.tasks.save', ['action' => 'change-status'])}}', {
                    id: $(this).data('id'),
                    status: $(this).data('status'),
                    _token: '{{csrf_token()}}',
                }).done(function () {
                    location.reload();
                });
            });

            @endif
            @if($view_type === 'calendar')

            var todayDate = moment().startOf("day");
            var YM = todayDate.format("YYYY-MM");
            var YESTERDAY = todayDate.clone().subtract(1, "day").format("YYYY-MM-DD");
            var TODAY = todayDate.format("YYYY-MM-DD");
            var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

            var calendarEl = document.getElementById("tasks_calendar_view");
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                },

                height: 800,
                contentHeight: 780,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + "T09:25:00", // just for demo

                views: {
                    dayGridMonth: {buttonText: "month"},
                    timeGridWeek: {buttonText: "week"},
                    timeGridDay: {buttonText: "day"}
                },

                initialView: "dayGridMonth",
                initialDate: TODAY,

                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                navLinks: true,
                events: [],

            });
            calendar.render();
            @endif
        });
    </script>
@endsection

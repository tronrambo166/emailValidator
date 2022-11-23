<div class="card-body mt-4 table-responsive  pt-0">
    <!--begin::Table-->
    <table class="table align-items-center mb-0">
        <!--begin::Table head-->
        <thead>
        <!--begin::Table row-->
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Subject/Task')}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Assigned To')}}</th>

            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Start Date')}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Due Date')}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Status')}}
            </th>
            <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end ">{{__('Actions')}}</th>
        </tr>
        </thead>

        <tbody>
        <!--begin::Table row-->

        @foreach( $tasks as  $task)

            <tr>
                <td class="">
                    <h6 class="text-sm font-weight-bold mb-0">{{ $task->subject}} </h6>
                </td>
                <td class="text-xs font-weight-bold mb-0">
                    @if(isset($users[$task->contact_id]))
                        {{$users[$task->contact_id]->first_name}}  {{$users[$task->contact_id]->last_name}}
                    @endif
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">
                        @if(!empty($task->start_date))
                            {{$task->start_date->format(config('app.date_time_format'))}}
                        @endif
                    </p>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">
                        @if(!empty($task->due_date))
                            {{$task->due_date->format(config('app.date_time_format'))}}
                        @endif
                    </p>

                </td>
                <td>
                    <div class="dropdown mt-2">
                        <button class="text-xs btn btn-sm
                                         @if($task->status === 'Not Started')
                            btn-info
@elseif($task->status === 'Complete')
                            btn-success
@elseif($task->status === 'Awaiting Feedback')
                            btn-warning
@else
                            btn-secondary
@endif
                            dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            {{$task->status ?? 'Not Started'}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if($task->status !== 'Not Started')
                                <li><a class="dropdown-item change_task_status" data-id="{{$task->id}}"
                                       data-status="Not Started" href="#">{{__('Mark as Not Started')}}</a></li>
                            @endif
                            @if($task->status !== 'Awaiting Feedback')
                                <li><a class="dropdown-item change_task_status" data-id="{{$task->id}}"
                                       data-status="Awaiting Feedback" href="#">{{__('Mark as Awaiting Feedback')}}</a>
                                </li>
                            @endif

                            @if($task->status !== 'Complete')
                                <li><a class="dropdown-item change_task_status" data-id="{{$task->id}}"
                                       data-status="Complete" href="#">{{__('Mark as Complete')}}</a></li>
                            @endif

                        </ul>
                    </div>
                </td>
                <!--begin::Joined-->
                <!--begin::Action=-->
                <td class="text-end">

                    <!--begin::Menu-->
                    <div class="menu-item px-3">
                        <a href="#" class="btn btn-link text-dark px-3 mb-0 category_edit"
                           data-id="{{$task->id}}">{{__('Edit')}}</a>
                        <a href="/delete/task/{{$task->id}}" class="btn btn-link text-danger px-3 mb-0"
                           data-kt-users-table-filter="delete_row">{{__('Delete')}}</a>
                    </div>
                    <!--end::Menu-->
                </td>
                <!--end::Action=-->
            </tr>
        @endforeach

        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add Task')}}</h5>

                </div>

                <form method="post" id="form_main">

                    <div class="modal-body">
                        <div id="sp_result_div"></div>
                        <div class="">
                            <label for="exampleFormControlInput1"
                                   class="required form-label">{{__('Subject/Task')}}</label>
                            <input type="text" id="input_name" name="subject" class="form-control form-control-solid"
                                   placeholder=""/>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <label for="exampleFormControlInput1"
                                           class="required form-label">{{__('Start Date')}}</label>
                                    <input type="text" placeholder="Pick Date" id="start_date" name="start_date"
                                           @if (!empty($task)) value="{{$task->start_date}}"
                                           @endif class="form-control form-control-solid flatpickr-input"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="exampleFormControlInput1" class="form-label">{{__('End Date')}}</label>
                                    <input type="text" id="due_date" name="due_date"
                                           class="form-control form-control-solid"
                                           @if (!empty($task)) value="{{$task->due_date}}"
                                           @endif placeholder="Pick Date"/>
                                </div>
                            </div>

                        </div>
                        <div class="mb-1 mt-2">

                            <label for="exampleFormControlInput1" class="form-label">{{__('Assign To')}}</label>
                            <select class="form-select form-select-solid fw-bolder" id="contact"
                                    aria-label="Floating label select example" name="contact_id">
                                <option value="0">{{__('None')}}</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}"
                                            @if (!empty($task))
                                            @if ($task->contact_id === $user->id)
                                            selected
                                        @endif
                                        @endif
                                    >{{$user->first_name}} {{$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-2">

                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{__('Description')}}</label>
                                    <textarea type="text" name="description" id="description"
                                              class="form-control form-control-solid"
                                              rows="7">@if (!empty($task)){{$task->description}}@endif </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ms-3">
                        @csrf
                        <button type="submit" id="btn_submit" class="btn btn-info">{{__('Save')}} </button>
                        <button type="button" class="btn bg-pink-light text-danger"
                                data-bs-dismiss="modal">{{__('Close')}}</button>
                    </div>
                    <input type="hidden" name="task_id" id="task_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>



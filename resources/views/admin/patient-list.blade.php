@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">List of Service Providers</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
									<li class="breadcrumb-item active">Patient</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Name</th>
													<th>Email </th>
													<th>Country</th>
													<th>City</th>
													<th>Phone</th>
													<th>Current Job</th>
													<th>Toral Earned</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody> 
												@foreach($patient as $p) @php $earning = 0;$c=0@endphp
												<tr>
													
													<td>{{$p->name}}</td>
													<td>{{$p->email}}</td>
													<td>{{$p->country}}</td>
													<td>{{$p->city}}</td>
													<td>{{$p->phone}}</td>

													@foreach($job as $j)

													@if($p->current_job_id == $j->id) @php $c++; @endphp
													<td>{{$j->title}}, (Id ={{$j->id}})</td> @endif

													@php $completed = explode(',',$p->jobs_completed_ids);@endphp

													@foreach($completed as $done)
													@if($done == $j->id)
													@php $earning = $earning+($j->rate*$j->hours_required); @endphp
													

													@endif @endforeach
													@endforeach

													@if($c==0)<td>0</td> @endif
													<td>${{$earning}}</td>

													<td><a class="btn btn-sm bg-success-light"  href="{{route('history',[$p->id,$p->jobs_completed_ids])}}">
																<i class="fe fe-pencil"></i> History
															</a> </td>

													
												</tr>
												@endforeach
												
												
											</tbody>
										</table>
									</div>
									</div>
								</div>
							</div>
						</div>			
					</div>
					
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
@endsection
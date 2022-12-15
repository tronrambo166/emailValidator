@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Jobs</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Jobs</li>
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
										

										<table class="datatable table table-hover table-center mb-0" id="myTable">
											<thead>
											    <th>Image</th>	
													<th>Title</th>	
																								
													<th>Description</th>
													<th>Location</th>
													<th>Required Hours</th>
													
													<th>Status</th>
													<th>Max Hires</th>
													<th>Rate</th>
													
													
													
												</tr>
										
											</thead>
										
											<tbody>				
												@foreach($doctor as $l)
												@foreach($job_ids as $ids)
												@if($l->id == $ids)
												<tr>


													<td>
													<h2 class="table-avatar">
															<a  class="avatar avatar-lg mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/doctors/{{$l->image}}" alt="User Image"></a>
															<a href="profile">{{$l->name}} </a>
														</h2>

														
														<td>{{$l->title}}</td>
														<td>{{$l->desc}}</td>
											 	<td>
														<h2 class="table-avatar">
															<a >
																@foreach($location as $lo)@if($lo->id==$l->location_id)
																{{$lo->city}},{{$lo->country}} @endif @endforeach</a>
														</h2>
																				
													<td>{{$l->hours_required}}</td>
													<td>Completed</td>
													<td>{{$l->max_hires}}</td>
													<td>{{$l->rate}}</td>
												
	
													<td class="text-right">
														<div class="actions">
															<!-- <a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_specialities_details{{$l->id}}">
																<i class="fe fe-pencil"></i> Edit
															</a>
							<a onclick="return confirm('Are you sure...?') "  href="{{route('delete_jobs',$l->id)}}" class="btn btn-sm bg-danger-light">
																<i class="fe fe-trash"></i> Delete
															</a> -->
														</div>
													</td>
												</tr>
												@endif
												@endforeach
												@endforeach

											
											


									</div>
								</div>
							</div>
						</div>			
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
@endsection
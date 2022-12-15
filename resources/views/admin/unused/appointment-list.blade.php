@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Appointments</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Appointments</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">
						
							<!-- Recent Orders -->
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Doctor Name</th>
													
													<th>Patient Name</th>
													<th>Apointment Time</th>
													
													<th class="">Amount</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach($appointment as $p)
												<tr>
													<td> @foreach($doctor as $d) @if($d->id==$p->doctor_id)
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/doctors/{{$d->image}}" alt="User Image"></a>
													<a href="profile">{{$d->name}}  </a>
														</h2>
														@endif @endforeach
													</td>

													<td> @foreach($patient as $d)@if($d->id==$p->patient_id)
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/patients/{{$d->image}}" alt="User Image"></a>
													<a href="profile">{{$d->name}}  </a>
														</h2>
														@endif @endforeach
													</td>

													<td><span class="text-primary d-block">{{$p->appointment_time}}</span></td>
													
													<td class="">
														{{$p->amount}}
													</td>

												<td class="text-right"><a onclick="return confirm('Are you sure...?') "  href="{{route('del_appointment',$p->id)}}" class="btn btn-sm bg-danger-light">
																<i class="fe fe-trash"></i> Delete
															</a></td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Recent Orders -->
							
						</div>
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
@endsection
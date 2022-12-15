@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Users</h3>
									<p class="text-success"> @if(Session::has('success')) {{Session::get('success')}} </p>
								@php Session::forget('success'); @endphp @endif
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Users</li>
								</ul>
							</div>
							
						</div>
					</div>
					<!-- Page Header -->
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										

										<table class=" table table-hover table-center mb-0">
											<thead>
												<tr> 															
													<th>Name</th>
													<th>Emails</th>
													<th>Subscribed</th>
													<th>Action</th>
															
													
												</tr>
										
											</thead>
										
											<tbody>				
												@foreach($artists as $l)
												<tr>

												



												<!--	<td>
													<h2 class="table-avatar">
															<a  class="avatar avatar-lg mr-2"><img class="avatar-img rounded-circle" src="../images/artists/" alt="User Image"></a>
															<a href="profile">{{$l->name}} </a>	</h2>			 						
												</td> -->

													
													
													<td>{{$l->name}}</td>
													<td>{{$l->email}}</td>
												
										<td class="text-right">
										<div class="actions">

									@if($l->stripe_id != null)
									<p class="btn btn-sm bg-success-light" 
									> <i class="fe fe-pencil"></i> Subscribed </p>

									@else	<p  class="btn btn-sm bg-danger-light"  href="{{ route('restrict',$l->id) }}"> <i class="fe fe-pencil"></i> Not Subscribed</p>
									@endif

						
													</div>
												</td>


													
													<td class="text-right">
														<div class="actions">

										@if($l->approved == 0)
										<a class="btn btn-sm bg-success-light" 
										href="{{route('approve',$l->id)}}"> </i> Approve</a>

										@else	<a onclick="return confirm('Are you sure...?') " class="btn btn-sm bg-warning-light font-weight-bold"  href="{{ route('restrict',$l->id) }}"> Restrict</a>
										@endif

							<a onclick="return confirm('Are you sure...?') "  href="{{route('del_users',$l->id)}}" class="btn btn-sm bg-danger-light">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td>
												</tr>
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
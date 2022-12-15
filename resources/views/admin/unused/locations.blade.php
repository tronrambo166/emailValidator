@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Locations</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Locations</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a href="{{route('loc_add')}}"  class="btn btn-primary float-right mt-2">Add</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										

										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Country</th>
													<th>City</th>
													<th>Address</th>
													
													<th class="text-right">Action</th>
												</tr>
										
											</thead>
										
											<tbody>				
												@foreach($location as $l)
												<tr>
													<td>{{$l->country}}</td>
													<td>{{$l->city}}</td>
													
													<td>
														<h2 class="table-avatar">
															<a href="profile">{{$l->address}}</a>
														</h2>
													</td>
													
													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light"  href="{{route('loc_edit',$l->id)}}">
																<i class="fe fe-pencil"></i> Edit
															</a>
							<a onclick="return confirm('Are you sure...?') "  href="{{route('del_location',$l->id)}}" class="btn btn-sm bg-danger-light">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td>
												</tr>
											
											


									</div>
								</div>
							</div>
						</div>			
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
			
			
			
			<!-- Edit Details Modal -->
			<div class="modal fade" id="edit_specialities_details{{$l->id}}" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Location</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							
							<form action="{{route('up_location')}}"  method="post" enctype="multipart/form-data"> @csrf
								<input name="id" type="number" hidden value="{{$l->id}}" class="form-control">

								<div class="row form-row">
									<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Country Name</label>
											<input value="{{$l->country}}" name="country" type="text" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>City Name</label>
											<input value="{{$l->city}}" name="city" type="text" class="form-control">
										</div>
									</div>


									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Address</label>
											<input type="text" name="address" value="{{$l->address}}" class="form-control" value="Cardiology">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image" class="form-control">
										</div>
									</div>
									
								</div>
								<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->

				@endforeach

											</tbody>
										</table>

										<!-- Add Modal -->
			<div class="modal fade" id="Add_Specialities_details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Specialities</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="{{route('add_location')}}"  method="post" enctype="multipart/form-data">
								@csrf
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Country Name</label>
											<input required="" name="country" type="text" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>City Name</label>
											<input required="" name="city" type="text" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Address</label>
											<input required=""  type="text" name="address" class="form-control" value="Cardiology">
										</div>
									</div>

									
									
								</div>
								<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /ADD Modal -->
			

			
			
        </div>
		<!-- /Main Wrapper -->
@endsection
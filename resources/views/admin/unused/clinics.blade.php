@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Clinics</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Clinics</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a href="#Add_Specialities_details" data-toggle="modal" class="btn btn-primary float-right mt-2">Add</a>
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
													<th>Name</th>
													<th>Location</th>
													<th>Address</th>
													<th class="">Image</th>
													<th class="">Description</th>
													<th class="text-right">Action</th>
												</tr>
										
											</thead>
										
											<tbody>				
												@foreach($clinic as $l)
												<tr>
													<td>{{$l->name}}</td>

													<td>
														<h2 class="table-avatar">
															<a href="profile">
																@foreach($location as $lo)@if($lo->id==$l->location_id)
																{{$lo->name}} @endif @endforeach</a>
														</h2>
													
													<td>
														<h2 class="table-avatar">
															<a href="profile">
																{{$l->address}}
																</a>
														</h2>
													</td>
													<td><img class="mb-2" width="50px" height="50px" src="../assets_admin/img/hospitals/{{$l->image}}" >

														<img class="mb-2" width="50px" height="50px" src="../assets_admin/img/hospitals/{{$l->image2}}" >

														<img class="mb-2" width="50px" height="50px" src="../assets_admin/img/hospitals/{{$l->image3}}" >

														<img class="mb-2" width="50px" height="50px" src="../assets_admin/img/hospitals/{{$l->image4}}" >

													</td>

													<td>
														<h2 class="table-avatar">
															<a href="profile">
																{{$l->description}}
																</a>
														</h2>
													</td>
												
													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_specialities_details{{$l->id}}">
																<i class="fe fe-pencil"></i> Edit
															</a>
							<a onclick="return confirm('Are you sure...?') "  href="{{route('del_clinic',$l->id)}}" class="btn btn-sm bg-danger-light">
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
							<h5 class="modal-title">Edit Clinics</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							
							<form action="{{route('up_clinic')}}"  method="post" enctype="multipart/form-data">
								@csrf
							<input  name="id" type="number" hidden value="{{$l->id}}" class="form-control">
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Name</label>
											<input required="" name="name" type="text" value="{{$l->name}}" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Location</label>
							<select required="" name="location_id" class="form-control">
							
							
								@foreach($location as $ll)
							<option @php if($ll->id==$l->location_id) echo 'selected'; @endphp value="{{$ll->id}}">{{$ll->name}}</option>
							@endforeach
						  </select>
						  
										</div>
									</div>


									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Address</label>
											<input required="" name="address" type="text" value="{{$l->address}}" class="form-control">
										</div>
									</div>



									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Description</label>
											<input required="" name="description" type="text" value="{{$l->description}}" class="form-control">
										</div>
									</div>



									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image2" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image3" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image4" class="form-control">
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
							<h5 class="modal-title">Add Clinic</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="{{route('add_clinic')}}"  method="post" enctype="multipart/form-data">
								@csrf
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Name</label>
											<input required="" name="name" type="text" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Location</label>
							<select required="" name="location_id" class="form-control">
							
							<option value="">Select a location</option>
								@foreach($location as $l)
							<option value="{{$l->id}}">{{$l->name}}</option>
							@endforeach
						  </select>
						  
										</div>
									</div>


									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Address</label>
											<input required="" name="address" type="text"  class="form-control">
										</div>
									</div>



									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Description</label>
											<input required="" name="description" type="text"  class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image2" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image3" class="form-control">
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Image</label>
											<input type="file" name="image4" class="form-control">
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
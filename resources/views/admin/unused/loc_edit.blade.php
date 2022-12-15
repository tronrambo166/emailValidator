@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header m-0 p-0">
						<div class="row m-0 p-0">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Edit Locations</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Locations</li>
								</ul>
							</div>
							
						</div>
					</div>


					<!-- /Page Header -->
					<div class="row pt-0">
						<div class="col-sm-12">
							<div class="card pt-0">
								<div class="card-body pt-0">
								
									<!-- Edit Details Modal -->
			<div class="" id="edit_specialities_details{{$l->id}}" aria-hidden="true" role="dialog">
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

									
									
								</div>
								<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Edit Details Modal -->

								</div>
							</div>
						</div>			
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
			
			
			
			

			
			
      
@endsection
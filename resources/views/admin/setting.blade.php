@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						@if(Session::has('success'))
						<p class="text-center text-success">{{Session::get('success')}} </p>
						@php Session::forget('success'); @endphp @endif
					
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body"> 
									<div class="table-responsive">
										

									<!--	<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Name</th>
													<th>Disease Id</th>
													<th>Disease Name</th>
													<th>Procedure Name</th>
													<th>Medication A</th>
													<th>Medication B</th>
													<th>Medication C</th>
													<th>Medication D</th>
													<th>Medication E</th>
													
													<th class="text-right">Action</th>
												</tr>
										
											</thead>
										
											<tbody>				
												
												<tr>
													
													
													
												class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_specialities_details">
																<i class="fe fe-pencil"></i> Edit
															</a>
							<a onclick="return confirm('Are you sure...?') "  href="" class="btn btn-sm bg-danger-light">
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
			
				
											</tbody>
										</table> -->

										<!-- Add Modal -->
			<div class="row">
				<div class="col-sm-8">
							
			<div class="card " id=""  role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">SMTP Setup</h5>
							
						</div>
						<div class="modal-body">
							<form action="{{route('smtp_setting')}}"  method="post" enctype="multipart/form-data">
								@csrf
								<div class="row form-row">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>SMTP Provider</label>
											<select
											 required="" name="provider" type="text" class="form-control">
											 <option>Mailtrap</option>
											 <option>MailHog</option>
											 <option>smtp4dev</option>

											 </select>
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Driver</label>
											<select
											 required="" name="driver" type="text" class="form-control">
											 <option>SMTP</option>
											 <option>Mailgun</option>
											 <option>Mailchimp </option>
											 <option>Twilio </option>

											 </select>
										</div>
									</div>


									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Host</label>
											<input required=""  type="text" name="host" class="form-control" >
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Port</label>
											<input required=""  type="text" name="port" class="form-control" >
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Username</label>
											<input required=""  type="text" name="username" class="form-control" >
										</div>
									</div>



									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Password</label>
											<input required=""  type="text" name="password" class="form-control" >
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Security</label>
											<select
											 required="" name="security" type="text" class="form-control">
											 <option>No Encryption</option>
											  <option>SSL</option>
											   <option>TLS</option>
											 </select>
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Email From Address</label>
											<input required=""  type="text" name="mail_f" class="form-control" >
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Email From Name</label>
											<input required=""  type="text" name="mail_f_name" class="form-control" >
										</div>
									</div>
									
								</div>
								<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
							</form>
						</div>
					</div>
				</div>
			</div>

			</div>

			<div class="col-sm-4 mt-5">
				<h3>Instructions</h3>
				<div>
					<h4>For Non SSL</h4>
					<p class="responsive-font-example">Select 'sendmail' as driver if you face issue with <br> 'smtp', set host according to your mail server<br> manual, and set port 587</p>
				</div>

				<div>
					<h4>For SSL</h4>
					<p>Select 'sendmail' as driver if you face issue with<br> 'smtp', set host according to your mail server<br> manual, and set port 465</p>
				</div>

			</div>

			</div>
			<!-- /ADD Modal -->
			

			
			
        </div>
		<!-- /Main Wrapper -->
@endsection
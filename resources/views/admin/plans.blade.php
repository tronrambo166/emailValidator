@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Plans</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Plans</li>
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
										

										<table class=" table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Plan</th>
													<th>Description</th>
													<th>Type</th>

												</tr>
										
											</thead>
										
											<tbody>				
												
											@foreach(config('spark.billables')['user']['plans'] as $plans)
												<tr> 
													<td>{{$plans['name']}}</td>
													<td>{{$plans['short_description']}}</td>
													<td>{{$plans['name']}}</td>
																
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

@extends('layout.mainlayout_admin')
@section('content')		
@if(!Session::has('admin'))
 <script>window.location.href = "./login";</script> @endif
 
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="card p-5 mx-auto w-75 page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Welcome Admin!</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>

					
					<!-- /Page Header -->
		
					
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
	   @endsection
	  
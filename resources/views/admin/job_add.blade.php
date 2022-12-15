@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header m-0 p-0">
						<div class="row m-0 p-0">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Create Job</h3>
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
								
									<!-- /HIdden add form-->

 <div  class="" id="add_jobs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"> Create Job
        
      </div>
    
    
      <div class="modal-body">
	
		    <form action="{{route('add_jobs')}}"  method="post" enctype="multipart/form-data">
		    @csrf	

		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Title</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required="" class="form-control form-group" type="text" name="title" id="title" placeholder="Enter Title"  /> 
					</div>
					<div class="col-sm-4"> </div>
		    	</div>


		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Required Items</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					 <input type="checkbox" name="items[]" value="safety gloves">  Safety gloves<br>
					 <input type="checkbox" name="items[]" value="safety googles"> Hafety googles <br>
					<input type="checkbox" name="items[]" value="hard hat">  Hard hat<br>
					<input type="checkbox" name="items[]" value="steel toe boots">Steel toe boots <br>
					<input type="checkbox" name="items[]" value="safety vest"> Safety vest
					</div>
					<div class="col-sm-4"> </div>
		    	</div>


		    		<div class="row form-group">
		    		<div class="col-sm-1"><label for="password"><strong>Description</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required="" class="form-control form-group" type="text" name="desc" id="password" placeholder="Enter desc"  /> 
					</div>
					<div class="col-sm-4"> </div>
		    	</div>



		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Required Hours</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required="" step="any" class="form-control form-group" type="number" name="hours_required" id="name" placeholder="Enter hours"  /> 
					</div>
					<div class="col-sm-4"> </div>
		    	</div>

		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Location</strong></label></div>
		    		<div class="col-sm-1"></div>
					
		    		<div class="col-sm-7"> 
						<select required="" name="location_id" class="form-control">
							<option value="">Select a Location</option>
								@foreach($location as $c)
							<option value="{{$c->id}}">{{$c->city}}, {{$c->country}}</option>
							@endforeach
						</select>					
					</div>
					<div class="col-sm-4"> </div>					
		    	</div>

		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Status</strong></label></div>
		    		<div class="col-sm-1"></div>
					
		    		<div class="col-sm-7"> 
						<select required="" name="status" class="form-control">
								<option value="ToDo">To Do</option>
								
							
							
						</select>					
					</div>
					<div class="col-sm-4"> </div>					
		    	</div>

		    	
		    		<div class="row form-group">
		    		<div class="col-sm-1"><label for="password"><strong>Max Hires</strong></label></div>
					<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required="" class="form-control form-group" type="number" name="max_hires" id="password" placeholder="Enter rate" />
								
			
			

		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="password"><strong>Rate</strong></label></div>
					<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input step="any" required="" class="form-control form-group" type="number" name="rate" id="password" placeholder="Enter rate" /> 
	</div>
	<div class="col-sm-4"> </div>					
		    	</div>
		
				<div class="row form-group">
		    		<div class="col-sm-1 "><label for="photo"><strong>Upload Image</strong></label></div>
					<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input class=" form-group " type="file" name="image" id="photo" /> 
					</div>
					<div class="col-sm-4"> </div>	
		    	</div>
				
				<div class="clearfix"></div>
				
				<div class="row">
					<div class="col-sm-6"></div>
				<input type="submit" name="add" value="Create Job" class="mt-3 px-5 py-1 btn btn-outline-dark  font-weight-bold" />
				</div>
				
		    </form>


      </div>
    
    
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
			
<!-- /HIdden add form-->



								</div>
							</div>
						</div>			
					</div>
				</div>			
			</div>
			<!-- /Page Wrapper -->
			
			
			
			

			
			
      
@endsection
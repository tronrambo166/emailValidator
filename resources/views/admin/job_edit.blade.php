@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header m-0 p-0">
						<div class="row m-0 p-0">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Edit Job</h3>
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

			<div class=" " id="edit_specialities_details{{$l->id}}" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Jobs</h5>
							
						</div>
						<div class="modal-body">
							
							<form action="{{route('update_jobs')}}"  method="post" enctype="multipart/form-data">
								@csrf
							<input  name="id" type="number" hidden value="{{$l->id}}" class="form-control">
							<input  name="id_asn" type="number" hidden value="{{$id_asn}}" class="form-control">

		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Title</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required=""value="{{$l->title}}" class="form-control form-group" type="text" name="title" id="title" placeholder="Enter Title"  /> 
					</div>
					<div class="col-sm-4"> </div>
		    	</div>


		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Required Items</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 

		    			@php
		    			$items=str_replace('"','',str_replace('[','',str_replace(']','',$l->items))); 
		    			 $items = explode(',',$items); @endphp
									
														
					 <input 
					 @foreach($items as $it)@if($it == 'safety gloves') checked @endif @endforeach type="checkbox" name="items[]" value="safety gloves">  Safety gloves<br>
					 
					 <input
					  @foreach($items as $it)@if($it == 'safety googles') checked @endif @endforeach type="checkbox" name="items[]" value="safety googles"> Hafety googles <br>
					<input 
					 @foreach($items as $it)@if($it == 'hard hat') checked @endif @endforeach type="checkbox" name="items[]" value="hard hat">  Hard hat<br>
					
					<input
					 @foreach($items as $it)@if($it == 'steel toe boots') checked @endif @endforeach type="checkbox" name="items[]" value="steel toe boots">Steel toe boots <br>
					
					<input
					 @foreach($items as $it)@if($it == 'safety vest') checked @endif @endforeach type="checkbox" name="items[]" value="safety vest"> Safety vest
					</div>
					<div class="col-sm-4"> </div>
		    	</div>



		    		<div class="row form-group">
		    		<div class="col-sm-1"><label for="password"><strong>Description</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required=""value="{{$l->desc}}" class="form-control form-group" type="text" name="desc" id="password" placeholder="Enter Description"  /> 
					</div>
					<div class="col-sm-4"> </div>
		    	</div>



		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="name"><strong>Required Hours</strong></label></div>
		    		<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required=""value="{{$l->hours_required}}" step="any" class="form-control form-group" type="number" name="hours_required" id="name" placeholder="Enter hours"  /> 
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
							<option @if($c->id == $l->location_id) selected @endif value="{{$c->id}}">{{$c->city}}, {{$c->country}}</option>
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
								<option value="In Progress">In Progress</option>
								<option value="Completed">Completed</option>
								<option value="Cancelled">Cancelled</option>
							
							
						</select>					
					</div>
					<div class="col-sm-4"> </div>					
		    	</div>

		    	
		    		<div class="row form-group">
		    		<div class="col-sm-1"><label for="password"><strong>Max Hires</strong></label></div>
					<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input required=""value="{{$l->max_hires}}" class="form-control form-group" type="number" name="max_hires" id="password" placeholder="Enter rate" />
								
			
			

		    	<div class="row form-group">
		    		<div class="col-sm-1"><label for="password"><strong>Rate</strong></label></div>
					<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input step="any" required=""value="{{$l->rate}}" class="form-control form-group" type="number" name="rate" id="password" placeholder="Enter rate" /> 
	</div>
	<div class="col-sm-4"> </div>					
		    	</div>
		
				<div class="row form-group">
		    		<div class="col-sm-1 "><label for="photo"><strong>Change Image</strong></label></div>
					<div class="col-sm-1"></div>
		    		<div class="col-sm-7"> 
					<input class=" form-group " type="file" name="image" id="photo" /> 
					</div>
					<div class="col-sm-4"> </div>	
		    	</div>
				
				<div class="clearfix"></div>
				
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
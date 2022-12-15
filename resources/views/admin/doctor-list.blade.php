@extends('layout.mainlayout_admin')
@section('content')	

<style type="text/css"> .smalls{font-size: 12px;} </style>
 <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />

<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-7 col-auto">
								<h3 class="page-title">Jobs</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Jobs</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<a href="{{route('job_add')}}"  class="btn btn-primary float-right mt-2">Add</a>
							</div>
						</div>
					</div>
<!-- /Page Header -->
<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
<div class="table-responsive">


<table class="datatable table table-hover table-center mb-0" id="myTable">
<thead>
<th>SL</th>
<th>Image</th>	
<th>Title</th>	
<th>Required Items</th>										
<th >Description</th>
<th>Location</th>
<th>Required Hours</th>
<th>Asisgned To</th>
<th>Status</th>
<th>Max Hires</th>
<th>Rate</th>


<th class="text-right">Action</th>
</tr>

</thead>

<tbody>		@php $j=1;$k=1; @endphp		
@foreach($doctor as $l)
<tr>

<td>{{$j++}}</td>
<td>
<h2 class="table-avatar">
<a  class="avatar avatar-lg mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/doctors/{{$l->image}}" alt="User Image"></a>

</h2>


<td>{{$l->title}}</td>

<td> <div class="row"> 
@php 
$items=str_replace('"','',str_replace('[','',str_replace(']','',$l->items))); 

$items = explode(',',$items); @endphp
@foreach($items as $it)
@foreach($images as $img)
@if($img->item_name == $it)


<div class="col-sm-6">
<img class="d-block" width="40px" src="{{$img->image}}" />
<h2 style="font-size: 12px;" class="smalls">{{ucfirst($it)}}</h2>

</div>
@endif @endforeach @endforeach
</div></td>


<td class="ml-3">{{$l->desc}}</td>
<td>
<h2 class="table-avatar">
<a >
@foreach($location as $lo)@if($lo->id==$l->location_id)
{{$lo->city}},{{$lo->country}} @endif @endforeach</a>
</h2>

<td>{{$l->hours_required}}</td>
<td>{{$l->name}}</td>
<td>{{$l->status2}}</td>
<td>{{$l->max_hires}}</td>
<td>{{$l->rate}}</td>


<td class="text-right"> 
<div class="actions">
<a class="btn btn-sm bg-success-light"  href="{{route('job_edit',[$l->id,$l->id_asn]) }}">
<i class="fe fe-pencil"></i> Edit
</a>
<a onclick="return confirm('Are you sure...?') "  href="{{route('delete_jobs',$l->id)}}" class="btn btn-sm bg-danger-light">
<i class="fe fe-trash"></i> Delete
</a>
</div>
</td>
</tr>

@endforeach


<!-- NOT -->
@foreach($notAssigned as $l)
<tr>

<td>{{$k++}}</td>
<td>
<h2 class="table-avatar">
<a  class="avatar avatar-lg mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/doctors/{{$l->image}}" alt="User Image"></a>

</h2>


<td>{{$l->title}}</td>

<td> <div class="row"> 
@php 
$items=str_replace('"','',str_replace('[','',str_replace(']','',$l->items))); 

$items = explode(',',$items); @endphp
@foreach($items as $it)
@foreach($images as $img)
@if($img->item_name == $it)


<div class="col-sm-6">
<img class="d-block" width="40px" src="{{$img->image}}" />
<h2 style="font-size: 12px;" class="smalls">{{ucfirst($it)}}</h2>

</div>
@endif @endforeach @endforeach
</div></td>


<td class="ml-3">{{$l->desc}}</td>
<td>
<h2 class="table-avatar">
<a >
@foreach($location as $lo)@if($lo->id==$l->location_id)
{{$lo->city}},{{$lo->country}} @endif @endforeach</a>
</h2>

<td>{{$l->hours_required}}</td>
<td>{{$l->name}}</td>
<td>Not Assigned</td>
<td>{{$l->max_hires}}</td>
<td>{{$l->rate}}</td>


<td class="text-right"> 
<div class="actions">
<a class="btn btn-sm bg-success-light"  href="{{route('job_edit',[$l->id,0]) }}">
<i class="fe fe-pencil"></i> Edit
</a>
<a onclick="return confirm('Are you sure...?') "  href="{{route('delete_jobs',$l->id)}}" class="btn btn-sm bg-danger-light">
<i class="fe fe-trash"></i> Delete
</a>
</div>
</td>
</tr>
@endforeach 

<!-- NOT -->




</div>
</div>
</div>
</div>			
</div>
</div>			
</div>
<!-- /Page Wrapper -->
			
			
			 

											</tbody>
										</table>



			
			
        </div>
		<!-- /Main Wrapper -->








<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


@endsection
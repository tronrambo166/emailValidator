 <x-app-layout>
  @section('content')


<div class="row mx-auto shadow w-75 my-4" style="width:90%; background:#ffffff;color:black">  
         <div class="col-md-8 mx-auto"> 
            <h4 class="text-center my-4">Verification History <span class="small">(Bulk)</span></h4>

            <table class="table tabil mb-4 mx-auto" style="color:black;">
  <thead>
    <tr>
      <th class="text-center" scope="col">Date of result</th>
      <th class="text-center" scope="col">File Name</th>
      <th class="text-center" scope="col">Download</th>
    
    </tr>
  </thead>
  <tbody id="songs">

   @foreach($files as $fileData) <?php $cnt=0; ?>
   
 @php $info = str_replace('{','-',str_replace('"',';',$fileData->info)); @endphp
    

    <tr id="loading">  
      <td scope="row" class="text-center"> {{$fileData->date}} </td>
       <td scope="row" class="text-center"> {{$fileData->file_name}} </td>
         <td  scope="row" class="text-center small">

          <div class="row">
            <a class="text-center text-success font-weight-bold" style=" font-size:12px;color:black; margin-bottom:5px;" href="{{url('/mail_rep_dld/'.$info.'/'.$fileData->file_name.'/valid')}}">Valid emails</a>
          </div>

           <div class="row">
            <a class="text-center text-danger font-weight-bold" style=" font-size:12px;color:black; margin-bottom:5px;" href="{{url('/mail_rep_dld/'.$info.'/'.$fileData->file_name.'/invalid')}}">Invalid emails</a>
          </div>

           <div class="row">
            <a class="text-center text-secondary font-weight-bold" style=" font-size:12px;color:black; margin-bottom:5px;" href="{{url('/mail_rep_dld/'.$info.'/'.$fileData->file_name.'/dispose')}}">Disposeable emails</a>
          </div>

           <div class="row">
            <a class="text-center font-weight-bold" style=" font-size:12px;color:black; margin-bottom:5px;" href="{{url('/mail_rep_dld/'.$info.'/'.$fileData->file_name.'/role')}}">Role based emails</a>
          </div>
     

     
         
        </td>
    </tr>

   @endforeach

  </tbody>
</table>

<div class="clearfix py-3"></div>



             </div>  

           
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>


<script type="text/javascript">

</script>


          @endsection
          </x-app-layout>
        
       


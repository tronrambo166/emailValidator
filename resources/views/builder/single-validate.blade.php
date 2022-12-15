  <x-app-layout>
  @section('content')

<style type="text/css"> 
    label, .form-label {
    font-size: 14px;
    font-weight: 400;
    margin-bottom: 0.5rem;
    color: #252f40;
    margin-left: 0.25rem;
    font-family: inherit;
}
</style> 
        <!-- Kartik fileinput -->
         <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <link rel="stylesheet" 
        href="public/builder/kartik-v/bootstrap-fileinput/css/fileinput.css" media="all" type="text/css">
        <!-- Simple Sidebar -->
        <link rel="stylesheet" href="public/builder/css/simple-sidebar.css">
        <!-- Select2 -->
        <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
        <!-- Bootstrap select2 -->
        <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
        <!-- Bootstrap extend -->
        <link rel="stylesheet" 
        href="https://cdn.rawgit.com/Chalarangelo/bootstrap-extend/880420ae663f7c539971ded33411cdecffcc2134/css/bootstrap-extend.min.css">
        <!-- Bootstrap tour standalone -->
        <link rel="stylesheet" 
        href="public/builder/bootstrap-tour/build/css/bootstrap-tour-standalone-brv.css">
        <!-- Zebra dialog -->
        <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/zebra_dialog@latest/dist/css/flat/zebra_dialog.min.css">
        <!-- Custom styles -->
        <link rel="stylesheet" href="public/builder/css/oc-advanced.css">


        <!-- Main fileinput plugin file -->
        <script src="public/builder/kartik-v/bootstrap-fileinput/js/fileinput.js"></script>
        <!-- Optionally if you need a theme like font awesome theme you can include it as mentioned below -->
        <script src="public/builder/kartik-v/bootstrap-fileinput/themes/fa/theme.min.js"></script>
        <!-- Optionally if you need translation for your language then include locale file as mentioned below -->
        <script src="public/builder/kartik-v/bootstrap-fileinput/js/locales/fr.js"></script>
        <!-- Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <!-- Bootstrap extend -->
        <script src="https://cdn.rawgit.com/Chalarangelo/bootstrap-extend/880420ae663f7c539971ded33411cdecffcc2134/js/bootstrap-extend.min.js"></script>
        <!-- Bootstrap tour standalone -->
        <script src="public/builder/bootstrap-tour/build/js/bootstrap-tour-standalone.min.js"></script>
        <!-- Zebra dialog -->
        <script src="https://cdn.jsdelivr.net/npm/zebra_dialog/dist/zebra_dialog.min.js"></script>
        <!-- Custom script -->
        <script type="text/javascript" src="public/builder/js/oc-advanced.js"></script>

 <div class="mb-4"  style="max-height: 700px;background-color:white; "> 
    <p style="background: white;" class="font-weight-bold h5 text-center text-secondary py-3"> Validate Single Email</p>
</div> 

<div class="row w-75 mx-auto" style="max-height: 200px;">
  <div class=" card mx-auto shadow"  style="width: 50%;overflow: hidden;max-height: 200px;background:white; ">

   <!-- action="{{route('/clean_mail')}}" --> 
   <!-- action="{{route('/clean_mail')}}" -->




    <form  method="post" action="{{route('/single_validate')}}" enctype="multipart/form-data">@csrf

                        <div class="row card-body  " style="background:#ffffff;font-family: revert;color: black;">
                            
                                <div class="py-0 my-0 font-weight-bold form-group" id="usage">
                                    <label for="inputListName">Enter email to verify</label>
                                    
                                </div>
                                <div class="form-group py-0 " id="options">
                                    <label for="textareaListEmails"></label>
                                    <input type="text" class="w-75 form-control" id="textareaListEmails" name="emails" spellcheck="false" />

                                     <button style="background: black;" id="launchs" type="submit" class="my-3 d-inline font-weight-bold text-light btn ">Validate</button>
                                </div>      
                            </div>       
                    </form>
                    </div>


  <div id="results" class="col-sm-5 px-0 card mx-auto shadow"  style="max-height: 700px;font-size: 13px;background:white; ">
     <p style="color: darkslategrey;" class="px-0 font-weight-bold h5 text-center  py-4"> Results History</p> 
   
  <table class="table tabil mb-4 mx-auto" style="color:black;">
  <thead>
    <tr>
      <th class="text-center" scope="col">Emails</th>
      <th class="text-center" scope="col">Status</th> 
      <th class="text-center" scope="col">Type</th> 
         
    </tr>
  </thead>
  <tbody id="songs">
  <?php $cnt=0; ?>
   @foreach($all as $email) <?php $cnt++; ?>
   @if($cnt!=1)
    <tr id="loading">  
      <td scope="row" class="text-center"> {{$email->email}} </td>
       <td scope="row" class="text-center"> {{$email->valid}} </td>
       <td scope="row" class="text-center"> {{$email->type}} </td>
       
        <!--<td scope="row" class="text-center"> 
            @if($email->role == 'True') Role Based @else Free @endif </td> -->
      
    </tr>
   @endif
   @endforeach

  </tbody>
</table>
</div>

</div>


@if(Session::has('single_check') && isset($current_check))
<div class="row w-75 mx-auto">
  <div id="single results" class="col-sm-6 ml-4 px-0 mt-4 card  shadow"  style="max-height: 700px;background:white; ">

<div class="px-4 pt-3">
     <p  class=" h6 px-0 font-weight-bold  py-1"> 
     Email address is 
     @if($current_check->valid == 'Valid')
     <span class="text-success">VALID</span>
     @else  <span class="text-danger">INVALID</span> @endif </p> <hr>

      <p  class=" small font-weight-bold  "> 
     <span class="font-weight-bold text-secondary">Email: </span>{{$current_check->email}}</p>

      <p  class=" small font-weight-bold  "> 
     <span class="font-weight-bold text-secondary">Status: </span>{{$current_check->valid}}</p>

      <p  class=" small font-weight-bold  "> 
     <span class="font-weight-bold text-secondary">SMTP: </span>{{$current_check->smtp}}</p>

      <p  class=" small font-weight-bold  "> 
     <span class="font-weight-bold text-secondary">Type: </span>{{$current_check->type}}</p>
      <p  class=" small font-weight-bold  "> 

      <p  class=" small font-weight-bold  "> 
     <span class="font-weight-bold text-secondary">Disposable: </span>{{$current_check->dispose}}</p>

      <p  class=" small font-weight-bold  "> 
     <span class="font-weight-bold text-secondary">Role based: </span>{{$current_check->role}}</p>


     
</div>

</div>
       </div>   @endif            

                    <div class="py-5"></div>

                    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
@endsection

</x-app-layout>
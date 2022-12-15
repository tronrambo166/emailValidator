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

 <div class="mb-5 "  style="max-height: 700px;background-color:white; "> 
    <p style="background: white;color: grey;" class="font-weight-bold h5 text-center text-secondary py-3"> Emails from Text</p>
</div> 

<div class="row w-75 mx-auto">
  <div class="col-sm-6 card mx-auto shadow"  style="max-height: 700px;background:#f3f3f3a6; ">
   <!-- action="{{route('/clean_mail')}}" --> 
   <!-- action="{{route('/clean_mail')}}" -->
    <form  method="post" action="{{route('/ExtractEmails')}}" enctype="multipart/form-data">@csrf

                       

                        <div class="row card-body  " style="background:#ffffff;font-family: revert;color: black;">
                            <div class="col-sm">
                                <div class="form-group" id="usage">
                                    <label for="inputListName">Enter raw text to extract emails</label>
                                    
                                </div>
                                <div class="form-group" id="options">
                                    
                                    <textarea class="w-100 form-control" id="textareaListEmails" name="string" rows="8" spellcheck="false" ></textarea> 

                                     <button style="background: black;" id="launchs" type="submit" class="my-3 d-inline font-weight-bold text-light btn ">Extract</button>
                                </div>                               
                            </div> 
                        </div>                  
                    </form>
                    </div>


  <div id="results" class="px-0 col-sm-5  card mx-auto shadow"  style="max-height: 700px;background:white; ">
     <p style="background: #edf1efba;color: black;" class="px-0 font-weight-bold h5 text-center  py-4"> Results</p>
   
  <table class="table tabil mb-4 mx-auto" style="color:black;">
  <thead>
    <tr>
      <th class="text-center" scope="col">SL</th>
      <th class="text-center" scope="col">Emails</th>   
    </tr>
  </thead>
  <tbody id="songs">
  <?php $cnt=1; ?>
  @if(Session::has('extract')) @php $emails = Session::get('extract'); @endphp
   @foreach($emails as $email) 
    <tr id="loading">  
      <td scope="row" class="text-center"> {{$cnt++}} </td>
       <td scope="row" class="text-center"> {{$email}} </td>
      
    </tr>

   @endforeach @endif

  </tbody>
</table>
                    </div>

 </div>



                    <div class="py-5"></div>

                    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
@endsection

</x-app-layout>
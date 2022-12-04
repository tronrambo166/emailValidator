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

 <div class="  py-4"  style="max-height: 700px;background-color:white; "> 
    <p class="h4 text-center"> Welcome to Email Cleaner</p>
</div> 

  <div class=" card m-auto"  style="overflow: hidden;max-height: 700px;background:white;
   width:82%; ">

   <!-- action="{{route('/clean_mail')}}" --> 
   <!-- action="{{route('/clean_mail')}}" -->



<div class="row mx-auto" style="width:90%; background:#161616;">  
         <div class="col-md-3"> 
            <h5 class="text-center text-light mt-2">The Top 20</h5> <hr>

            <table class="table tabil mb-4 text-light">
  <thead>
    <tr>
      <th scope="col">Position</th>
      <th scope="col">Artist</th>
      <th scope="col">Song</th>
      <th scope="col">Move</th>
    
    </tr>
  </thead>
  <tbody id="songs"> 
    <tr id="loading">
     
      <td class="font-weight-bold"> Loading... </td>
    </tr>

    
  </tbody>
</table>

                    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
@endsection

</x-app-layout>
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
   width:65%; ">

   <!-- action="{{route('/clean_mail')}}" --> 
   <!-- action="{{route('/clean_mail')}}" -->




    <form  method="post" action="{{route('/clean_mail')}}" enctype="multipart/form-data">@csrf

                       

                        <div class="row card-body" style="background:ffffff47;">
                            <div class="col-sm">
                                <div class="form-group" id="usage">
                                    <label for="inputListName">Indicate the name of your list for export (optional)</label>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    id="inputListName" 
                                    name="name" 
                                    aria-describedby="nameHelp" 
                                    placeholder="The name of the final file"
                                    spellcheck="false">
                                </div>
                               <div class="form-group" id="options">
                                    <label for="textareaListEmails">Copy/paste your email addresses below <small>(separeate emails by new line)</small></label>
                                    <textarea class="form-control" id="textareaListEmails" name="emails" rows="11" spellcheck="false"></textarea>
                                </div>
                                <div class="row form-group" id="reflex" > 
                                    <div class="col-sm-10"  >  <p class="small control-label"> insert a csv file containing your emails </p>
                                    
                                </div>

                                    <div class="col-sm-2" style="height: 60px;"  >  <input 
                                    id="file-input" 
                                    name="fileInput" 
                                    type="file" 
                                    class="file-loading" 
                                    accept="text/plain" 
                                    data-show-upload="false" 
                                    data-show-remove="true" 
                                    data-show-caption="true">
                                </div>
                                   
                                   
                                </div>


                               <div class="form-group" id="contributing">
                                   <!--  <label for="select-choices">Choose the cleaning level of your email addresses</label>
                                    <select 
                                    class="cleaning-choices" 
                                    id="select-choices" 
                                    name="select-choices" 
                                    data-placeholder="Select an cleaning option" 
                                    style="width: 100%;" 
                                    required>
                                        <option></option>
                                        <option value="1">Level 1 - Validating Email</option>
                                        <option value="2">Level 2 - Level 1 + Domain Validation</option>
                                        <option value="3">Level 3 - Level 1 + Level 2 + SMTP Email Validation</option>
                                    </select> -->
                                </div>
                            </div> 


                            <div class="col-sm ">
                                <div id="order-1">
                                    <label class="text-success" >Sorting options in asc or desc order (optional)</label>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="ascOrDesc" id="noSorting" value="none" checked>
                                        <label for="noSorting">No sorting (leave as is)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="ascOrDesc" id="ascOrder" value="asc">
                                        <label for="ascOrder">By order ascending or ASC (0-9 a-z)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="ascOrDesc" id="descOrder" value="desc">
                                        <label for="descOrder">By order descending or DESC (z-a 9-0)</label>
                                    </div>
                                </div>

 
                                <div id="order-2" class="mt-4">
                                    <label class="text-success">Advanced sorting options by domains (optional)</label>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="tldAndSld" id="noDomain" value="none" checked>
                                        <label for="noDomain">No sorting (leave as is)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="tldAndSld" id="tld" value="tld">
                                        <label for="tld">Top level TLD (eg: .com, .net, .org...)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="tldAndSld" id="ccTld" value="ccTld">
                                        <label for="ccTld">National top level ccTLD (eg: .ca for Canada, .fr for France...)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="rdbtn rdbtn-primary" name="tldAndSld" id="sld" value="sld">
                                        <label for="sld">Second level SLD (eg: gmail.com, example.org...)</label>
                                    </div>
                                </div>
                                <hr> 

                            </div>
                        </div>
                      
                        <div class="d-flex justify-content-center">
                            <button style="background: black;" id="launchs" type="submit" class="font-weight-bold text-light btn ">Clean/Sort my emails </button>
                        </div>
                    </form>
                    </div>


                    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
@endsection

</x-app-layout>
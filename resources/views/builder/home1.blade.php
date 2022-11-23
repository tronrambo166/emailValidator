
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 style_render::  

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
        <!-- Menu Toggle Script -->
        <script type="text/javascript">
        $(document).ready(function() {
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            var formData = new FormData();
            var $input = $("#file-input");
            $input.fileinput({
                dropZoneEnabled: false,
                previewFileType: "text",
                allowedFileExtensions: ["txt", "csv"],
                maxFilePreviewSize: 2560,
                uploadUrl: '/admin/panel/optimail/runtime',
                uploadExtraData: function() {
                    return {
                        fileName: $("#inputListName").val(),
                        txtEmails: $("#textareaListEmails").val(),
                        level: $("select[name=select-choices]").val(),
                        ascOrDesc: $('input[name=ascOrDesc]:checked', '#optimail-form').val(),
                        tldAndSld: $('input[name=tldAndSld]:checked', '#optimail-form').val(),
                        aeoTld: $("#aeo-tld").val(),
                        aeoSld: $("#aeo-sld").val()
                    };
                },
                uploadAsync: false,
                showUpload: false,
                showRemove: false,
                showCancel: false,
                maxFileCount: 1,
                initialPreviewAsData: true,
                previewFileType: "image",
                theme: "fa",
                browseClass: "btn brv-btn-orange",
                browseLabel: "Choose file",
                browseIcon: "<span class=\"oi oi-file\" aria-hidden=\"true\"></span> ",
                removeClass: "btn btn-danger",
                removeLabel: "Delete",
                removeIcon: "<span class=\"oi oi-trash\" aria-hidden=\"true\"></span> ",
                uploadClass: "btn btn-info",
                uploadLabel: "Upload",
                uploadIcon: "<span class=\"oi oi-data-transfer-upload\" aria-hidden=\"true\"></span> ",
                layoutTemplates: {
                    main1: 
                    '{preview}\n' +
                    '<div class="kv-upload-progress hide"></div>\n' +
                    '<div class="input-group {class}">\n' +
                    '   {caption}\n' +
                    '   <div class="input-group-btn">\n' +
                    '       {remove}\n' +
                    '       {cancel}\n' +
                    '       {upload}\n' +
                    '       {browse}\n' +
                    '   </div>\n' +
                    '</div>',
                    main2: '{preview}\n<div class="kv-upload-progress hide"></div>\n{remove}\n{cancel}\n{upload}\n{browse}\n',
                    preview: 
                    '<div class="file-preview {class}">\n' +
                    '    {close}\n' +
                    '    <div class="{dropClass}">\n' +
                    '    <div class="file-preview-thumbnails">\n' +
                    '    </div>\n' +
                    '    <div class="clearfix"></div>' +
                    '    <div class="file-preview-status text-center text-success"></div>\n' +
                    '    <div class="kv-fileinput-error"></div>\n' +
                    '    </div>\n' +
                    '</div>',
                    icon: '<span class="glyphicon glyphicon-file kv-caption-icon"></span>',
                    caption: 
                    '<div tabindex="-1" class="form-control file-caption {class}">\n' +
                    '   <div class="file-caption-name"></div>\n' +
                    '</div>',
                    btnDefault: '<button type="{type}" tabindex="500" title="{title}" class="{css}"{status}>{icon}{label}</button>',
                    btnLink: '<a href="{href}" tabindex="500" title="{title}" class="{css}"{status}>{icon}{label}</a>',
                    btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}{label}</div>',
                    modalMain: '<div id="kvFileinputModal" class="file-zoom-dialog modal fade" tabindex="-1" aria-labelledby="kvFileinputModalLabel"></div>',
                    modal: 
                    '    <div class="modal-dialog modal-lg{rtl}" role="document">\n' +
                    '        <div class="modal-content">\n' +
                    '            <div class="modal-header wave">\n' +
                    '                <div class="kv-zoom-actions pull-right">{toggleheader}</div>\n' +
                    '                <h5 class="modal-title" id="exampleModalLabel">{heading} <small><span class="kv-zoom-title"></span></small></h5>\n' +
                    '                <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
                    '                    <span aria-hidden="true">&times;</span>\n' +
                    '                </button>\n' +
                    '            </div>\n' +
                    '            <div class="modal-body">\n' +
                    '            <div class="floating-buttons"></div>\n' +
                    '            <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
                    '            </div>\n' +
                    '            <div class="modal-footer">\n' +
                    '                <button type="button" class="btn btn-secondary brv" data-dismiss="modal">Close</button>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>\n',
                    progress: 
                    '<div class="progress">\n' +
                    '    <div class="progress-bar progress-bar-success progress-bar-striped text-center" role="progressbar" aria-valuenow="{percent}" aria-valuemin="0" aria-valuemax="100" style="width:{percent}%;">\n' +
                    '        {status}\n' +
                    '     </div>\n' +
                    '</div>\n' +
                    '<div class="mb-1"></div>',
                    footer: 
                    '<div class="file-thumbnail-footer">\n' +
                    '    <div class="file-caption-name" style="width:{width}">{caption}</div>\n' +
                    '    {progress} {actions}\n' +
                    '</div>',
                    actions: 
                    '<div class="file-actions">\n' +
                    '    <div class="file-footer-buttons">\n' +
                    '        {zoom} {other}' +
                    '    </div>\n' +
                    '    <div class="clearfix"></div>\n' +
                    '</div>',
                    actionDelete: '',
                    actionUpload: '',
                    actionZoom: '<button type="button" class="kv-file-zoom {zoomClass}" title="{zoomTitle}">{zoomIcon}</button>',
                    actionDrag: ''
                }
            }).on('filebatchpreupload', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                response = data.response, reader = data.reader;
                $.each(files, function(key, value) {
                    if (value != null) {
                        formData.append("fileInput", value, value.name);
                    }
                });
            });

             startTimer 
             showModal 

            $('#launch').click(function(e) {
                e.preventDefault(); alert('hi'); console.log('hsdkfshksdhf');
                if ($("#textareaListEmails").val() === "" && document.getElementById("file-input").files.length == 0) {
                    $.Zebra_Dialog('<strong>Warning!</strong> You must add your email addresses to be cleaned either by <u>copying or pasting</u> or by <u>uploading a txt or csv file</u> or <u>both</u>.', {
                        type: 'warning',
                        title: 'No email addresses'
                    });

                    return false;
                }

                if ($("#select-choices").val() === "") {
                    $.Zebra_Dialog('<strong>Warning!</strong> You must choose the <u>cleaning level</u> for your email addresses.', {
                        type: 'warning',
                        title: 'Cleaning level'
                    });

                    return false;
                }

                $input.fileinput('upload');
                $('#timer').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });

                startTimer();
            });

            var t;
            var turnOnTimer = 0;

            function timerCount() {
                $.ajax({
                    url: '/admin/panel/optimail/timer',
                    type : 'POST',
                    success: function(data) {
                        if (data["percent"][0] < 100 && data["reload"][0] == 1) {
                            var progress = '<div class="progress"><div class="progress-bar" role="progressbar" style="width:' + 
                                data["percent"][0] + '%;height:23px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>',
                                text1 = '<span class="badge badge-pill badge-primary">1</span> File batch upload completed.<br>',
                                text2 = '<span class="badge badge-pill badge-primary">2</span> Processing email addresses... Completed.<br>',
                                text3 = '<span class="badge badge-pill badge-primary">3</span> Removing duplicates, spaces, line breaks and passing emails in lowercase... Completed.<br>',
                                text4 = '<span class="badge badge-pill badge-primary">4</span> Cleaning email addresses according to the chosen level:<br>',
                                text5 = '<span class="badge badge-pill badge-primary">3</span> Removing duplicates, spaces, line breaks and passing emails in lowercase... In progress, please wait <i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><br>',
                                hr = '<hr style="border-top: 1px solid rgba(255,255,255,.5);">';
                            (data["percent"][0] > 0) ? 
                                $(".timer-com").html(text1 + text2 + text3 + text4 + "<br>State of progress: " + data["percent"][0] + "%" + "<br>" + progress) :
                                $(".timer-com").html(text1 + text2 + text5 + "<br>State of progress: " + data["percent"][0] + "%" + "<br>" + progress);
                        } else {
                            var progress = '<div class="progress"><div class="progress-bar" role="progressbar" style="width:100%;height:23px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>',
                                text1 = '<span class="badge badge-pill badge-primary">1</span> File batch upload completed.<br>',
                                text2 = '<span class="badge badge-pill badge-primary">2</span> Processing email addresses... Completed.<br>',
                                text3 = '<span class="badge badge-pill badge-primary">3</span> Removing duplicates, spaces, line breaks and passing emails in lowercase... Completed.<br>',
                                text4 = '<span class="badge badge-pill badge-primary">4</span> Cleaning email addresses according to the chosen level:<br>',
                                hr = '<hr style="border-top: 1px solid rgba(255,255,255,.5);">';
                            $(".timer-com").html(text1 + text2 + text3 + text4 + "<br>State of progress: 100%" + "<br>" + progress + hr +  
                                "<div class='text-center'><input class='btn btn-success' id='brv-finished' type='button' value='Yeah finished! Click here to continue'></div>");
                            $('#brv-finished').click(function(){window.location.href = "/admin/panel/optimail/tables"; return false;});
                            stopTimer();
                        }
                    },
                    dataType: "json"
                });

                t = setTimeout(function(){timerCount()}, 3000);
            }

            function startTimer() {
                if (!turnOnTimer) {
                    turnOnTimer = 1;
                    timerCount();
                }
            }

            function stopTimer() {
                clearTimeout(t);
                turnOnTimer = 0;
            }
        });
        </script>

        <script type="text/javascript">
        function bounceMail() {
            $("#bounceMailRefresh").prop('disabled', true);
            $("#bounceMail-btn").prop('disabled', true);
            $("#bounceMail-btn").html('In progress, please wait <i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i>');
            $(".brv-inbox").text("Establishing a connection to your mailbox and checking for bounced mails...");
            $("#bounceMailErrors").html('');
            $.ajax({
                url: '/admin/panel/optimail/bounce/mail',
                type : 'POST',
                success: function(data) {
                    if (data) {
                        $(".brv-inbox").text(data);
                        $("#bounceMail-btn").html('Click here to check your mailbox for bounced mails');
                        $("#bounceMail-btn").prop('disabled', false);
                        $("#bounceMailRefresh").prop('disabled', false);
                    }
                },
                error: function(data) {
                    if (data) {
                        $(".brv-inbox").text('Connection closed due to an error.');
                        $("#bounceMail-btn").html('Click here to check your mailbox for bounced mails');
                        $("#bounceMail-btn").prop('disabled', false);
                        $("#bounceMailRefresh").prop('disabled', false);
                        $("#bounceMailErrors").html('<div class="alert alert-danger" role="alert">An error has occurred. Please check your settings.</div>');
                    }
                },
                dataType: "json"
            });
        }

        function refresh() {
            $("#bounceMailErrors").html('');
            $("#bounceMail-btn").html('Click here to check your mailbox for bounced mails');
            $("#bounceMail-btn").prop('disabled', false);
            $(".brv-inbox").text("Waiting for instruction");
        }

        function openSettings() {
            $('#bounceMail').modal('hide');
            $('#settingsModal').modal('show');
            $('#settingsModal').on('shown.bs.modal', function(e) {
                $('body').addClass('modal-open');
            });
        }

        function recordsTable() {
            window.location.href = "/admin/panel/optimail/tables/bounce";
        }
        </script>

 ::script_body_render 

<?php include "public/builder/src/BereviCollectionPack/Resources/views/Main/adminPanel.php"; ?>

                <!-- Timer Modal -->
                <div class="modal modal-timer" id="timer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body brv">
                                <a class="navbar-brand" href="javascript:void" style="color: #fff;">
                                    <span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                        <span class="logo-brv"></span>
                                    </span>
                                    <span style="margin-left:10px"></span>
                                    <span style="font-family: 'Homemade Apple', cursive; color: orange;">C</span><span class="logo-c-brv"></span>
                                </a>
                                <a href="/admin/logout" class="btn btn-outline-orange active pull-right" role="button" aria-pressed="true">
                                    <span class="oi oi-account-logout" title="Logout" aria-hidden="true"></span>
                                </a>
                                <hr style="border-top: 1px solid rgba(255,255,255,.5);">
                                <div class="timer-com">
                                    Waiting for instruction
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bounce Mail Modal -->
                <div class="modal fade" id="bounceMail" tabindex="-1" role="dialog" aria-labelledby="bounceMail" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body brv">
                                <a class="navbar-brand" href="javascript:void" style="color: #fff;">
                                    <span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                        <span class="logo-brv"></span>
                                    </span>
                                    <span style="margin-left:10px"></span>
                                    <span style="font-family: 'Homemade Apple', cursive; color: orange;">C</span><span class="logo-c-brv"></span>
                                </a>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <hr style="border-top: 1px solid rgba(255,255,255,.5);">
                                <div class="bounce-mail">
                                    <div class="card text-center">
                                        <div class="card-header" style="color: #212529;">
                                            <button type="button" class="btn btn-info btn-sm pull-right" onclick="openSettings()">Mailbox settings</button>
                                            <div class="pull-left">
                                                <button type="button" onclick="recordsTable()" class="btn btn-info btn-sm">Records</button>
                                                <button type="button" id="bounceMailRefresh" class="btn btn-info btn-sm" onclick="refresh()">Refresh</button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="color: #212529;">
                                            <h4 class="card-title">Bounce mail handler</h4>
                                            <p class="card-text">
                                                Bounces are messages that, due to an error, could not be delivered to their respective recipients.
                                            </p>
                                            <p class="card-text">
                                                You can click on the button below to make the necessary verifications according to your settings.
                                            </p>
                                            <p class="card-text">
                                                <code class="brv-inbox">Waiting for instruction</code>
                                            </p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <div id="bounceMailErrors"></div>
                                            <button type="button" id="bounceMail-btn" class="btn btn-primary btn-sm" onclick="bounceMail()">
                                                Click here to check your mailbox for bounced mails
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main structure -->
                <div class="jumbotron masthead-page">
                    <div id="sidebar-wrapper">
                        <ul class="sidebar-nav">
                            <li class="sidebar-brand">
                                <span>Available applications</span>
                            </li>
                            <li>
                                <a href="/admin/panel/optimail" class="active">
                                    <img src="" alt="Optimail Cleaner logo 28x28">
                                    Optimail Cleaner
                                </a>
                            </li>
                        </ul>
                    </div>
                    <p class="float-left brv-app-button" id="download">
                        <button type="button" class="btn btn-primary btn-sm" id="menu-toggle">Applications</button>
                        <button type="button" class="btn btn-light btn-sm start">
                            <i class="fa fa-magic" aria-hidden="true"></i>
                            Tutorial
                        </button>
                        <button type="button" class="btn btn-light btn-sm" id="tour-bm" data-toggle="modal" data-target="#bounceMail">
                            <i class="fa fa-inbox" aria-hidden="true"></i>
                            Bounce mails
                        </button>
                        <button type="button" class="btn btn-light btn-sm" id="tour" onclick="location.href='/admin/panel/optimail/tables';">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            Records
                        </button>
                    </p>
                    <div class="brv-global">
                        <h3 class="text-center brv-title">Optimail Cleaner</h3>
                        <p class="text-center brv-sub-title">Clean your email addresses intensively</p>
                    </div>
                    <hr>
                    <form  method="post" action="{{route('/clean_mail')}}"  enctype="multipart/form-data">

                          <hr> <input  type="submit" class="btn btn-primary" value="Clean" />
                      </form>

                        <div class="row">
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
                                    <label for="textareaListEmails">Copy/paste your email addresses below</label>
                                    <textarea class="form-control" id="textareaListEmails" name="emails" rows="11" spellcheck="false"></textarea>
                                </div>
                                <div class="form-group" id="reflex" style="height: 100px;"> 
                                    <label class="control-label">And/or download a file containing your email addresses</label>
                                    <input 
                                    id="file-input" 
                                    name="fileInput" 
                                    type="file" 
                                    class="file-loading" 
                                    accept="text/plain" 
                                    data-show-upload="false" 
                                    data-show-remove="true" 
                                    data-show-caption="true">
                                </div>
                                <div class="form-group" id="contributing">
                                    <label for="select-choices">Choose the cleaning level of your email addresses</label>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div id="order-1">
                                    <label>Advanced sorting options in ascending or descending order (optional)</label>
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
                                <hr>
                                <div id="order-2">
                                    <label>Advanced sorting options by domains (optional)</label>
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
                                <label><em>Removal options (optional)</em></label>
                                <div id="del-tld">
                                    <label>Advanced TLD and ccTLD removal</label>
                                    <div class="form-group">
                                        <select 
                                        class="aeo-tld" 
                                        id="aeo-tld" 
                                        name="aeo-tld[]" 
                                        data-placeholder="Choose domains to remove from your list" 
                                        multiple="multiple" 
                                        style="width: 100%;">
                                            <optgroup label="Generic domains">
                                                <option value="com">.com</option>
                                                <option value="org">.org</option>
                                                <option value="net">.net</option>
                                                <option value="int">.int</option>
                                                <option value="edu">.edu</option>
                                                <option value="gov">.gov</option>
                                                <option value="mil">.mil</option>
                                            </optgroup>
                                            <optgroup label="Special domains">
                                                <option value="arpa">.arpa</option>
                                            </optgroup>
                                            <optgroup label="A">
                                                <option value="ac">.ac</option>
                                                <option value="ad">.ad</option>
                                                <option value="ae">.ae</option>
                                                <option value="af">.af</option>
                                                <option value="ag">.ag</option>
                                                <option value="ai">.ai</option>
                                                <option value="al">.al</option>
                                                <option value="am">.am</option>
                                                <option value="an">.an</option>
                                                <option value="ao">.ao</option>
                                                <option value="aq">.aq</option>
                                                <option value="ar">.ar</option>
                                                <option value="as">.as</option>
                                                <option value="at">.at</option>
                                                <option value="au">.au</option>
                                                <option value="aw">.aw</option>
                                                <option value="ax">.ax</option>
                                                <option value="az">.az</option>
                                            </optgroup>
                                            <optgroup label="B">
                                                <option value="ba">.ba</option>
                                                <option value="bb">.bb</option>
                                                <option value="bd">.bd</option>
                                                <option value="be">.be</option>
                                                <option value="bf">.bf</option>
                                                <option value="bg">.bg</option>
                                                <option value="bh">.bh</option>
                                                <option value="bi">.bi</option>
                                                <option value="bj">.bj</option>
                                                <option value="bl">.bl</option>
                                                <option value="bm">.bm</option>
                                                <option value="bn">.bn</option>
                                                <option value="bo">.bo</option>
                                                <option value="bq">.bq</option>
                                                <option value="br">.br</option>
                                                <option value="bs">.bs</option>
                                                <option value="bt">.bt</option>
                                                <option value="bu">.bu</option>
                                                <option value="bv">.bv</option>
                                                <option value="bw">.bw</option>
                                                <option value="by">.by</option>
                                                <option value="bz">.bz</option>
                                                <option value="bzh">.bzh</option>
                                            </optgroup>
                                            <optgroup label="C">
                                                <option value="ca">.ca</option>
                                                <option value="cat">.cat</option>
                                                <option value="cc">.cc</option>
                                                <option value="cd">.cd</option>
                                                <option value="cf">.cf</option>
                                                <option value="cg">.cg</option>
                                                <option value="ch">.ch</option>
                                                <option value="ci">.ci</option>
                                                <option value="ck">.ck</option>
                                                <option value="cl">.cl</option>
                                                <option value="cm">.cm</option>
                                                <option value="cn">.cn</option>
                                                <option value="co">.co</option>
                                                <option value="corsica">.corsica</option>
                                                <option value="cr">.cr</option>
                                                <option value="cs">.cs</option>
                                                <option value="cu">.cu</option>
                                                <option value="cv">.cv</option>
                                                <option value="cw">.cw</option>
                                                <option value="cx">.cx</option>
                                                <option value="cy">.cy</option>
                                                <option value="cz">.cz</option>
                                            </optgroup>
                                            <optgroup label="D">
                                                <option value="dd">.dd</option>
                                                <option value="de">.de</option>
                                                <option value="dj">.dj</option>
                                                <option value="dk">.dk</option>
                                                <option value="dm">.dm</option>
                                                <option value="do">.do</option>
                                                <option value="dz">.dz</option>
                                            </optgroup>
                                            <optgroup label="E">
                                                <option value="ec">.ec</option>
                                                <option value="ee">.ee</option>
                                                <option value="eg">.eg</option>
                                                <option value="eh">.eh</option>
                                                <option value="er">.er</option>
                                                <option value="es">.es</option>
                                                <option value="et">.et</option>
                                                <option value="eu">.eu</option>
                                            </optgroup>
                                            <optgroup label="F">
                                                <option value="fi">.fi</option>
                                                <option value="fj">.fj</option>
                                                <option value="fk">.fk</option>
                                                <option value="fm">.fm</option>
                                                <option value="fo">.fo</option>
                                                <option value="fr">.fr</option>
                                            </optgroup>
                                            <optgroup label="G">
                                                <option value="ga">.ga</option>
                                                <option value="gb">.gb</option>
                                                <option value="gd">.gd</option>
                                                <option value="ge">.ge</option>
                                                <option value="gf">.gf</option>
                                                <option value="gg">.gg</option>
                                                <option value="gh">.gh</option>
                                                <option value="gi">.gi</option>
                                                <option value="gl">.gl</option>
                                                <option value="gm">.gm</option>
                                                <option value="gn">.gn</option>
                                                <option value="gp">.gp</option>
                                                <option value="gq">.gq</option>
                                                <option value="gr">.gr</option>
                                                <option value="gs">.gs</option>
                                                <option value="gt">.gt</option>
                                                <option value="gu">.gu</option>
                                                <option value="gw">.gw</option>
                                                <option value="gy">.gy</option>
                                            </optgroup>
                                            <optgroup label="H">
                                                <option value="hk">.hk</option>
                                                <option value="hm">.hm</option>
                                                <option value="hn">.hn</option>
                                                <option value="hr">.hr</option>
                                                <option value="ht">.ht</option>
                                                <option value="hu">.hu</option>
                                            </optgroup>
                                            <optgroup label="I">
                                                <option value="id">.id</option>
                                                <option value="ie">.ie</option>
                                                <option value="il">.il</option>
                                                <option value="im">.im</option>
                                                <option value="in">.in</option>
                                                <option value="io">.io</option>
                                                <option value="iq">.iq</option>
                                                <option value="ir">.ir</option>
                                                <option value="is">.is</option>
                                                <option value="it">.it</option>
                                            </optgroup>
                                            <optgroup label="J">
                                                <option value="je">.je</option>
                                                <option value="jm">.jm</option>
                                                <option value="jo">.jo</option>
                                                <option value="jp">.jp</option>
                                            </optgroup>
                                            <optgroup label="K">
                                                <option value="ke">.ke</option>
                                                <option value="kg">.kg</option>
                                                <option value="kh">.kh</option>
                                                <option value="ki">.ki</option>
                                                <option value="km">.km</option>
                                                <option value="kn">.kn</option>
                                                <option value="kp">.kp</option>
                                                <option value="kr">.kr</option>
                                                <option value="krd">.krd</option>
                                                <option value="kw">.kw</option>
                                                <option value="ky">.ky</option>
                                                <option value="kz">.kz</option>
                                            </optgroup>
                                            <optgroup label="L">
                                                <option value="la">.la</option>
                                                <option value="lb">.lb</option>
                                                <option value="lc">.lc</option>
                                                <option value="li">.li</option>
                                                <option value="lk">.lk</option>
                                                <option value="lr">.lr</option>
                                                <option value="ls">.ls</option>
                                                <option value="lt">.lt</option>
                                                <option value="lu">.lu</option>
                                                <option value="lv">.lv</option>
                                                <option value="ly">.ly</option>
                                            </optgroup>
                                            <optgroup label="M">
                                                <option value="ma">.ma</option>
                                                <option value="mc">.mc</option>
                                                <option value="md">.md</option>
                                                <option value="me">.me</option>
                                                <option value="mf">.mf</option>
                                                <option value="mg">.mg</option>
                                                <option value="mh">.mh</option>
                                                <option value="mk">.mk</option>
                                                <option value="ml">.ml</option>
                                                <option value="mm">.mm</option>
                                                <option value="mn">.mn</option>
                                                <option value="mo">.mo</option>
                                                <option value="mp">.mp</option>
                                                <option value="mq">.mq</option>
                                                <option value="mr">.mr</option>
                                                <option value="ms">.ms</option>
                                                <option value="mt">.mt</option>
                                                <option value="mu">.mu</option>
                                                <option value="mv">.mv</option>
                                                <option value="mw">.mw</option>
                                                <option value="mx">.mx</option>
                                                <option value="my">.my</option>
                                                <option value="mz">.mz</option>
                                            </optgroup>
                                            <optgroup label="N">
                                                <option value="na">.na</option>
                                                <option value="nc">.nc</option>
                                                <option value="ne">.ne</option>
                                                <option value="nf">.nf</option>
                                                <option value="ng">.ng</option>
                                                <option value="ni">.ni</option>
                                                <option value="nl">.nl</option>
                                                <option value="no">.no</option>
                                                <option value="np">.np</option>
                                                <option value="nr">.nr</option>
                                                <option value="nu">.nu</option>
                                                <option value="nz">.nz</option>
                                            </optgroup>
                                            <optgroup label="O">
                                                <option value="om">.om</option>
                                            </optgroup>
                                            <optgroup label="P">
                                                <option value="pa">.pa</option>
                                                <option value="pe">.pe</option>
                                                <option value="pf">.pf</option>
                                                <option value="pg">.pg</option>
                                                <option value="ph">.ph</option>
                                                <option value="pk">.pk</option>
                                                <option value="pl">.pl</option>
                                                <option value="pm">.pm</option>
                                                <option value="pn">.pn</option>
                                                <option value="pr">.pr</option>
                                                <option value="ps">.ps</option>
                                                <option value="pt">.pt</option>
                                                <option value="pw">.pw</option>
                                                <option value="py">.py</option>
                                            </optgroup>
                                            <optgroup label="Q">
                                                <option value="qa">.qa</option>
                                                <option value="quebec">.quebec</option>
                                            </optgroup>
                                            <optgroup label="R">
                                                <option value="re">.re</option>
                                                <option value="ro">.ro</option>
                                                <option value="rs">.rs</option>
                                                <option value="ru">.ru</option>
                                                <option value="rw">.rw</option>
                                            </optgroup>
                                            <optgroup label="S">
                                                <option value="sa">.sa</option>
                                                <option value="sb">.sb</option>
                                                <option value="sc">.sc</option>
                                                <option value="sd">.sd</option>
                                                <option value="se">.se</option>
                                                <option value="sg">.sg</option>
                                                <option value="sh">.sh</option>
                                                <option value="si">.si</option>
                                                <option value="sj">.sj</option>
                                                <option value="sk">.sk</option>
                                                <option value="sl">.sl</option>
                                                <option value="sm">.sm</option>
                                                <option value="sn">.sn</option>
                                                <option value="so">.so</option>
                                                <option value="sr">.sr</option>
                                                <option value="ss">.ss</option>
                                                <option value="st">.st</option>
                                                <option value="su">.su</option>
                                                <option value="sv">.sv</option>
                                                <option value="sx">.sx</option>
                                                <option value="sy">.sy</option>
                                                <option value="sz">.sz</option>
                                            </optgroup>
                                            <optgroup label="T">
                                                <option value="tc">.tc</option>
                                                <option value="td">.td</option>
                                                <option value="tf">.tf</option>
                                                <option value="tg">.tg</option>
                                                <option value="th">.th</option>
                                                <option value="tj">.tj</option>
                                                <option value="tk">.tk</option>
                                                <option value="tl">.tl</option>
                                                <option value="tm">.tm</option>
                                                <option value="tn">.tn</option>
                                                <option value="to">.to</option>
                                                <option value="tp">.tp</option>
                                                <option value="tr">.tr</option>
                                                <option value="tt">.tt</option>
                                                <option value="tv">.tv</option>
                                                <option value="tw">.tw</option>
                                                <option value="tz">.tz</option>
                                            </optgroup>
                                            <optgroup label="U">
                                                <option value="ua">.ua</option>
                                                <option value="ug">.ug</option>
                                                <option value="uk">.uk</option>
                                                <option value="um">.um</option>
                                                <option value="us">.us</option>
                                                <option value="uy">.uy</option>
                                                <option value="uz">.uz</option>
                                            </optgroup>
                                            <optgroup label="V">
                                                <option value="va">.va</option>
                                                <option value="vc">.vc</option>
                                                <option value="ve">.ve</option>
                                                <option value="vg">.vg</option>
                                                <option value="vi">.vi</option>
                                                <option value="vn">.vn</option>
                                                <option value="vu">.vu</option>
                                            </optgroup>
                                            <optgroup label="W">
                                                <option value="wf">.wf</option>
                                                <option value="ws">.ws</option>
                                            </optgroup>
                                            <optgroup label="Y">
                                                <option value="ye">.ye</option>
                                                <option value="yt">.yt</option>
                                                <option value="yu">.yu</option>
                                            </optgroup>
                                            <optgroup label="Z">
                                                <option value="za">.za</option>
                                                <option value="zm">.zm</option>
                                                <option value="zr">.zr</option>
                                                <option value="zw">.zw</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div id="del-sld">
                                    <label>Advanced SLD removal</label>
                                    <div class="form-group">
                                        <select 
                                        class="aeo-sld" 
                                        id="aeo-sld" 
                                        name="aeo-sld[]" 
                                        data-placeholder="Choose domains to remove from your list" 
                                        multiple="multiple" 
                                        style="width: 100%;">
                                            <optgroup label="The most used">
                                                <option value="facebook.com">facebook.com</option>
                                                <option value="youtube.com">youtube.com</option>
                                                <option value="yahoo.com">yahoo.com</option>
                                                <option value="live.com">live.com</option>
                                                <option value="msn.com">msn.com</option>
                                                <option value="wikipedia.org">wikipedia.org</option>
                                                <option value="blogspot.com">blogspot.com</option>
                                                <option value="baidu.com">baidu.com</option>
                                                <option value="microsoft.com">microsoft.com</option>
                                                <option value="qq.com">qq.com</option>
                                                <option value="bing.com">bing.com</option>
                                                <option value="ask.com">ask.com</option>
                                                <option value="adobe.com">adobe.com</option>
                                                <option value="taobao.com">taobao.com</option>
                                                <option value="twitter.com">twitter.com</option>
                                                <option value="youku.com">youku.com</option>
                                                <option value="soso.com">soso.com</option>
                                                <option value="wordpress.com">wordpress.com</option>
                                                <option value="sohu.com">sohu.com</option>
                                                <option value="hao123.com">hao123.com</option>
                                                <option value="windows.com">windows.com</option>
                                                <option value="163.com">163.com</option>
                                                <option value="tudou.com">tudou.com</option>
                                                <option value="amazon.com">amazon.com</option>
                                                <option value="apple.com">apple.com</option>
                                                <option value="ebay.com">ebay.com</option>
                                                <option value="4399.com">4399.com</option>
                                                <option value="yahoo.co.jp">yahoo.co.jp</option>
                                                <option value="linkedin.com">linkedin.com</option>
                                                <option value="go.com">go.com</option>
                                                <option value="tmall.com">tmall.com</option>
                                                <option value="paypal.com">paypal.com</option>
                                                <option value="sogou.com">sogou.com</option>
                                                <option value="aol.com">aol.com</option>
                                                <option value="xunlei.com">xunlei.com</option>
                                                <option value="craigslist.org">craigslist.org</option>
                                                <option value="orkut.com">orkut.com</option>
                                                <option value="56.com">56.com</option>
                                                <option value="orkut.com">orkut.com.br</option>
                                                <option value="about.com">about.com</option>
                                                <option value="skype.com">skype.com</option>
                                                <option value="7k7k.com">7k7k.com</option>
                                                <option value="dailymotion.com">dailymotion.com</option>
                                                <option value="flickr.com">flickr.com</option>
                                                <option value="pps.tv">pps.tv</option>
                                                <option value="qiyi.com">qiyi.com</option>
                                                <option value="bbc.co.uk">bbc.co.uk</option>
                                                <option value="4shared.com">4shared.com</option>
                                                <option value="mozilla.com">mozilla.com</option>
                                                <option value="mail.ru">mail.ru</option>
                                                <option value="booking.com">booking.com</option>
                                                <option value="tripadvisor.com">tripadvisor.com</option>
                                                <option value="hotmail.com">hotmail.com</option>
                                                <option value="gmail.com">gmail.com</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: Australia">
                                                <option value=".asn.au">.asn.au</option>
                                                <option value=".com.au">.com.au</option>
                                                <option value=".net.au">.net.au</option>
                                                <option value=".id.au">.id.au</option>
                                                <option value=".org.au">.org.au</option>
                                                <option value=".edu.au">.edu.au</option>
                                                <option value=".gov.au">.gov.au</option>
                                                <option value=".csiro.au">.csiro.au</option>
                                                <option value=".act.au">.act.au</option>
                                                <option value=".nsw.au">.nsw.au</option>
                                                <option value=".nt.au">.nt.au</option>
                                                <option value=".qld.au">.qld.au</option>
                                                <option value=".sa.au">.sa.au</option>
                                                <option value=".tas.au">.tas.au</option>
                                                <option value=".vic.au">.vic.au</option>
                                                <option value=".wa.au">.wa.au</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: Austria">
                                                <option value=".co.at">.co.at</option>
                                                <option value=".or.at">.or.at</option>
                                                <option value=".priv.at">.priv.at</option>
                                                <option value=".ac.at">.ac.at</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: France">
                                                <option value=".avocat.fr">.avocat.fr</option>
                                                <option value=".aeroport.fr">.aeroport.fr</option>
                                                <option value=".veterinaire.fr">.veterinaire.fr</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: Hungary">
                                                <option value=".co.hu">.co.hu</option>
                                                <option value=".film.hu">.film.hu</option>
                                                <option value=".lakas.hu">.lakas.hu</option>
                                                <option value=".ingatlan.hu">.ingatlan.hu</option>
                                                <option value=".sport.hu">.sport.hu</option>
                                                <option value=".hotel.hu">.hotel.hu</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: New Zealand">
                                                <option value=".ac.nz">.ac.nz</option>
                                                <option value=".co.nz">.co.nz</option>
                                                <option value=".geek.nz">.geek.nz</option>
                                                <option value=".gen.nz">.gen.nz</option>
                                                <option value=".kiwi.nz">.kiwi.nz</option>
                                                <option value=".maori.nz">.maori.nz</option>
                                                <option value=".net.nz">.net.nz</option>
                                                <option value=".org.nz">.org.nz</option>
                                                <option value=".school.nz">.school.nz</option>
                                                <option value=".cri.nz">.cri.nz</option>
                                                <option value=".govt.nz">.govt.nz</option>
                                                <option value=".health.nz">.health.nz</option>
                                                <option value=".iwi.nz">.iwi.nz</option>
                                                <option value=".mil.nz">.mil.nz</option>
                                                <option value=".parliament.nz">.parliament.nz</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: Israel">
                                                <option value=".ac.il">.ac.il</option>
                                                <option value=".co.il">.co.il</option>
                                                <option value=".net.il">.net.il</option>
                                                <option value=".net.il">.net.il</option>
                                                <option value=".k12.il">.k12.il</option>
                                                <option value=".gov.il">.gov.il</option>
                                                <option value=".muni.il">.muni.il</option>
                                                <option value=".idf.il">.idf.il</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: South Africa">
                                                <option value=".ac.za">.ac.za</option>
                                                <option value=".gov.za">.gov.za</option>
                                                <option value=".law.za">.law.za</option>
                                                <option value=".mil.za">.mil.za</option>
                                                <option value=".nom.za">.nom.za</option>
                                                <option value=".school.za">.school.za</option>
                                                <option value=".net.za">.net.za</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: Ukraine">
                                                <option value=".gov.ua">.gov.ua</option>
                                                <option value=".com.ua">.com.ua</option>
                                                <option value=".in.ua">.in.ua</option>
                                                <option value=".org.ua">.org.ua</option>
                                                <option value=".net.ua">.net.ua</option>
                                                <option value=".edu.ua">.edu.ua</option>
                                            </optgroup>
                                            <optgroup label="Domains by country code: United Kingdom">
                                                <option value=".co.uk">.co.uk</option>
                                                <option value=".org.uk">.org.uk</option>
                                                <option value=".me.uk">.me.uk</option>
                                                <option value=".ltd.uk">.ltd.uk</option>
                                                <option value=".plc.uk">.plc.uk</option>
                                                <option value=".net.uk">.net.uk</option>
                                                <option value=".sch.uk">.sch.uk</option>
                                                <option value=".ac.uk">.ac.uk</option>
                                                <option value=".gov.uk">.gov.uk</option>
                                                <option value=".mod.uk">.mod.uk</option>
                                                <option value=".mil.uk">.mil.uk</option>
                                                <option value=".nhs.uk">.nhs.uk</option>
                                                <option value=".police.uk">.police.uk</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="d-flex justify-content-center">
                            <button id="launchs" type="submit" class="btn btn-primary">Clean my email addresses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <footer>
            <p>
                Designed and developed for <a href="https://codecanyon.net/user/viwari/portfolio" target="_blank">Berevi Collection</a>, 
                by <a href="https://www.berevi.com" target="_blank">Berevi.com</a>.
            </p>
        </footer>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
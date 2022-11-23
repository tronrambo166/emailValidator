{{ style_render:: }}

        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Homemade+Apple" rel="stylesheet">
        <!-- Custom styles -->
        <link rel="stylesheet" href="{{ app_path }}/css/offcanvas.css">
        <link rel="stylesheet" href="{{ app_path }}/css/admin-panel.css">
        <!-- For images -->
        <style type="text/css">
        .wave {
            background-image: url('{{ app_path }}/images/panel/top-bar.png') !important;
        }

        .masthead {
            background: url('{{ app_path }}/images/panel/oc-presentation.png') no-repeat;
            background-color: rgb(93, 146, 154);
        }
        </style>

{{ ::style_render }}

{{ script_body_render:: }}

        <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                url: '{{ app_path }}/admin/panel/settings/load',
                type : 'POST',
                success: function(results) {
                    if (results) {
                        $("#smtpSender").val(results["smtp_sender"][0]);
                        $("#domainName").val(results["domain_name"][0]);
                        $("#bounceMailHandlerEmail").val(results["bounce_mail_handler_email"][0]);
                        $("#bounceMailHandlerPassword").val(results["bounce_mail_handler_password"][0]);
                        $("#serverType").val(results["server_type"][0]);
                        $("#bounceTimes").val(results["bounce_times"][0]);
                    }
                },
                dataType: "json"
            });

            $.ajax({
                url: '{{ app_path }}/admin/panel/envato/api',
                type : 'POST',
                success: function(results) {
                    if (results) {
                        $("#envato_api").html(results["cmd"]);
                    }
                },
                dataType: "json"
            });
        });

        function submitSettings() {
            var smtpSender = $('#smtpSender').val();
            var domainName = $('#domainName').val();
            var bounceMailHandlerEmail = $('#bounceMailHandlerEmail').val();
            var bounceMailHandlerPassword = $('#bounceMailHandlerPassword').val();
            var serverType = $('#serverType').val();
            var bounceTimes = $('#bounceTimes').val();
            $.ajax({
                url: '{{ app_path }}/admin/panel/settings',
                type : 'POST',
                data: {
                    smtpSender: smtpSender,
                    domainName: domainName,
                    bounceMailHandlerEmail: bounceMailHandlerEmail,
                    bounceMailHandlerPassword: bounceMailHandlerPassword,
                    serverType: serverType,
                    bounceTimes: bounceTimes
                },
                dataType: "json"
            });

            $('#settingsModal').modal('hide');
        }
        </script>

{{ ::script_body_render }}

        <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark wave">
            <a class="navbar-brand" href="#">
                <span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    <span class="logo-brv"></span>
                </span>
                <span style="margin-left:10px"></span>
                <span style="font-family: 'Homemade Apple', cursive; color: #fd7e14;">C</span><span class="logo-c-brv"></span>
            </a>
            <button 
            class="navbar-toggler" 
            type="button" 
            data-toggle="collapse" 
            data-target="#navbarsExampleDefault" 
            aria-controls="navbarsExampleDefault" 
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item">
                        <a class="nav-item nav-link mr-md-2" href="javascript:void" data-toggle="modal" data-target="#settingsModal" onfocus="if(this.blur)this.blur()">
                            <span class="oi oi-wrench" aria-hidden="true"></span>
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link mr-md-2" href="javascript:void" data-toggle="modal" data-target="#pluginsModal" onfocus="if(this.blur)this.blur()">
                            <span class="oi oi-grid-three-up" aria-hidden="true"></span>
                            Plugins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link mr-md-2" href="javascript:void" data-toggle="modal" data-target="#historyModal" onfocus="if(this.blur)this.blur()">
                            <span class="oi oi-calendar" aria-hidden="true"></span>
                            History
                        </a>
                    </li>
                    <li class="nav-item dropdown brv-item-marge">
                        <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-languages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="oi oi-globe" aria-hidden="true"></span>
                            Language
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-languages">
                            <a class="dropdown-item active" href="javascript:;">English</a>
                        </div>
                    </li>
                </ul>
                <a href="{{ app_path }}/admin/logout" class="btn btn-outline-orange active" role="button" aria-pressed="true">
                    <span class="oi oi-account-logout" title="Logout" aria-hidden="true"></span>
                </a>
            </div>
        </nav>

        <!-- Settings Modal -->
        <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header wave">
                        <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card brv-card border-secondary mb-3">
                            <h6 class="card-header border-secondary">SMTP Vérification</h6>
                            <div class="card-body">
                                <h6 class="card-title">Sender email <small>- Use to perform verification tests</small></h6>
                                <p class="card-text">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="smtpSender" name="smtp_sender" placeholder="name@example.com">
                                    </div>
                                </p>
                            </div>
                        </div>
                        <div class="card brv-card border-secondary mb-3">
                            <h6 class="card-header border-secondary">Mailbox settings <small>(Bounce mail handler)</small></h6>
                            <div class="card-body">
                                <h6 class="card-title">Your domain name</h6>
                                <p class="card-text">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="domainName" name="domain_name" placeholder="domain.com">
                                        <small id="domainNameHelpBlock" class="form-text text-muted">
                                            For example google.com without the http://www
                                        </small>
                                    </div>
                                </p>
                                <h6 class="card-title">Your email address <small>- Where the mails return</small></h6>
                                <p class="card-text">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="bounceMailHandlerEmail" name="bounce_mail_handler_email" placeholder="noreply@example.com">
                                    </div>
                                </p>
                                <h6 class="card-title">Your email address password</h6>
                                <p class="card-text">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="bounceMailHandlerPassword" name="bounce_mail_handler_password" placeholder="Password">
                                        <small id="bounceMailHandlerPasswordHelpBlock" class="form-text text-muted">
                                            Your email address password is used to connect to your inbox in a authenticated way.
                                        </small>
                                    </div>
                                </p>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="serverType">Server type</label>
                                        <select id="serverType" class="custom-select d-block" style="width: 100%;">
                                            <option value="">Please choose</option>
                                            <option value="gmail">Gmail</option>
                                            <option value="hotmail">Hotmail</option>
                                            <option value="yahoo">Yahoo</option>
                                            <option value="aol">AOL</option>
                                            <option value="imap">IMAP</option> 
                                            <option value="pop3">POP3</option>
                                            <option value="ssl">SSL IMAP or POP3</option>
                                            <option value="self">SSL IMAP or POP3 self-signed certificate</option>
                                            <option value="nntp">NNTP</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <small id="serverTypeHelpBlock" class="form-text text-muted">
                                            On what type of server your mailbox is hosted.
                                        </small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="bounceTimes">Bounce times <small>- Default 3</small></label>
                                        <select id="bounceTimes" class="custom-select d-block" style="width: 100%;">
                                            <option value="">Please choose</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                        <small id="bounceTimesHelpBlock" class="form-text text-muted">
                                            Bounce times before email deletion.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary brv" onclick="submitSettings()">Ok</button>
                        <button type="button" class="btn btn-secondary brv" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plugins Modal -->
        <div class="modal fade" id="pluginsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header wave">
                        <h5 class="modal-title" id="exampleModalLabel">Plugins</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card brv-card border-secondary mb-3">
                            <h6 class="card-header border-secondary">Optimail Cleaner</h6>
                            <div class="card-body">
                                <h6 class="card-title">Report <small>- Each available application is used as a plugin</small></h6>
                                <p class="card-text">
                                    <div class="form-group">
                                        <ul class="list-group" style="color: #495057;">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Application downloaded
                                                <span class="badge badge-primary badge-pill">OK</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Application installed
                                                <span class="badge badge-primary badge-pill">OK</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Application active
                                                <span class="badge badge-primary badge-pill">OK</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Reinstall / Uninstall
                                                <span>
                                                    <button type="button" class="btn btn-danger btn-sm pull-right" disabled>Uninstall</button>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary brv" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Modal -->
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header wave">
                        <h5 class="modal-title" id="exampleModalLabel">History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card brv-card border-secondary mb-3">
                            <h6 class="card-header border-secondary">Berevi Collection Applications</h6>
                            <div class="card-body">
                                <h6 class="card-title">Report <small>- History of all Berevi Collection applications available on Codecanyon.net</small></h6>
                                <p class="card-text">
                                    <div id="historyScroll" class="list-group">
                                        <a href="https://codecanyon.net/user/viwari/portfolio" target="_blank" class="list-group-item list-group-item-action flex-column align-items-start active">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">Optimail Cleaner is now available on Codecanyon.net</h5>
                                                <small>2017/11/09</small>
                                            </div>
                                            <p class="mb-1">Allows depth cleaning of all your email addresses easily.</p>
                                            <small>Check out our portfolio by clicking on this banner</small>
                                        </a>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary brv" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

<div id="envato_api"></div>

        <!-- Main wrapper -->
        <div id="wrapper">
            <!-- Main container -->
            <div class="container-fluid">
                <div class="row row-offcanvas row-offcanvas-left">
                    <div class="col-6 col-md-3 sidebar-offcanvas brv-side-menu" id="sidebar">
                        <div class="list-group">
                            <a href="{{ app_path }}/admin/panel/optimail" class="active list-group-item">
                                <img src="{{ app_path }}/images/panel/small-logo.png" alt="Optimail Cleaner Small logo 28x28">
                                Optimail Cleaner
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <p class="float-left d-md-none">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Applications</button>
                        </p>

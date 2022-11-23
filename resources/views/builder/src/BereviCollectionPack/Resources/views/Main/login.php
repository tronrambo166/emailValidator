{{ title_render::Berevi Collection - Sign in to your app }}

{{ style_render:: }}

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Homemade+Apple" rel="stylesheet">
        <!-- Custom style -->
        <link href="{{ app_path }}/css/cover.css" rel="stylesheet">

{{ ::style_render }}

{{ script_body_render:: }}

        <script type="text/javascript">
        /* Envato API: Ajax request script for token access */
        var request;
        $("#auth").submit(function(event) {
            event.preventDefault();
            if (request) {
                request.abort();
            }

            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();

            $inputs.prop("disabled", true);
            request = $.post('{{ app_path }}/login/control', serializedData, function(response) {
                document.location.replace(response);
                console.log("Response: " + response);
            });

            request.done(function(response, textStatus, jqXHR) {
                console.log("OK");
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error(
                    "The following error occurred: " + 
                    textStatus, errorThrown
                );
            });

            request.always(function() {
                $inputs.prop("disabled", false);
            });
        });
        </script>

{{ ::script_body_render }}

        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="cover-container">
                    <header class="masthead clearfix">
                        <div class="inner">
                            <h3 class="masthead-brand">
                                <a href="javascript:;">
                                    <span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                        <span class="logo-brv"></span>
                                    </span>
                                    <span style="margin-left:10px"></span>
                                    <span style="font-family: 'Homemade Apple', cursive; color: #fd7e14;">C</span><span class="logo-c-brv"></span>
                                </a>
                            </h3>
                            <nav class="nav nav-masthead">
                                <a class="nav-link active" href="{{ app_path }}/login">Home</a>
                                <a class="nav-link" href="https://codecanyon.net/user/viwari/portfolio" target="_blank">Portfolio</a>
                                <a class="nav-link" href="https://codecanyon.net/user/viwari" target="_blank">Contact</a>
                            </nav>
                        </div>
                    </header>
                    <main role="main" class="inner cover">
                        <h1 class="cover-heading">Just one click</h1>
                        <p class="lead">
                            You will be redirected to a login page, and once you have successfully logged in you will come back to the app. 
                            You will also have to grant the permissions the app requires. That's all!
                        </p>
                        <p class="lead">
                            <form id="auth">
                                <button class="btn btn-lg btn-secondary brv-orange submit" type="submit">
                                    Sign In
                                </button>
                            </form>
                        </p>
                    </main>
                    <footer class="mastfoot">
                        <div class="inner">
                            <p>
                                Designed and developed for <a href="https://codecanyon.net/user/viwari/portfolio" target="_blank">Berevi Collection</a>, 
                                by <a href="https://www.berevi.com" target="_blank">Berevi.com</a>.
                            </p>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

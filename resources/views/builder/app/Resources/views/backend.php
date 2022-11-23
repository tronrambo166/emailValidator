<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{ title_render }}</title>

		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Favicons -->
		<link rel="apple-touch-icon" sizes="120x120" href="{{ app_path }}/images/favicons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ app_path }}/images/favicons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ app_path }}/images/favicons/favicon-16x16.png">
		<link rel="manifest" href="{{ app_path }}/images/favicons/manifest.json">
		<link rel="mask-icon" href="{{ app_path }}/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="theme-color" content="#ffffff">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" 
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
		integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 
		crossorigin="anonymous">
    	<!-- Icon sets -->
    	<link rel="stylesheet" 
    	href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
    	<link rel="stylesheet" 
    	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>

		{{ body_render }}

    	<!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->
	    <!-- Optional JavaScript -->
	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" 
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" 
		crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" 
		integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" 
		crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" 
		integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" 
		crossorigin="anonymous"></script>
    	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    	<script type="text/javascript" src="{{ app_path }}/js/ie10-viewport-bug-workaround.js"></script>
    	<script type="text/javascript" src="{{ app_path }}/js/offcanvas.js"></script>
	</body>
</html>

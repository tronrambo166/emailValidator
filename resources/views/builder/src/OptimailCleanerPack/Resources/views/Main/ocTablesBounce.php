{{ title_render::Berevi Collection - Optimail Cleaner Bounce Table }}

{{ style_render:: }}

		<!-- Simple sidebar -->
		<link rel="stylesheet" href="{{ app_path }}/css/simple-sidebar.css">
		<!-- Bootstrap 4 for DataTables -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
		<!-- Zebra dialog -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/zebra_dialog@latest/dist/css/flat/zebra_dialog.min.css">
		<!-- Custom styles -->
		<link rel="stylesheet" href="{{ app_path }}/css/oc-tables.css">
        <!-- For images -->
        <style type="text/css">
		td.details-control {
		    background: url('{{ app_path }}/images/datatables/details_open.png') no-repeat center center;
		}

		tr.shown td.details-control {
		    background: url('{{ app_path }}/images/datatables/details_close.png') no-repeat center center;
		}
		</style>

{{ ::style_render }}

{{ script_body_render:: }}

		<!-- JQuery for datatables -->
		<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<!-- Bootstrap 4 for datatables -->
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
		<!-- Zebra dialog -->
		<script src="https://cdn.jsdelivr.net/npm/zebra_dialog/dist/zebra_dialog.min.js"></script>
		<!-- Custom script -->
		<script type="text/javascript" src="{{ app_path }}/js/oc-tables-bounce.js"></script>
		<!-- Script -->
		<script type="text/javascript">
		$(document).ready(function() {
		    if ($('#isRecords').css('display') == 'block') {
			    var table = $('#ocBounceTable').DataTable({
				    responsive: true,
				    "ajax": {
				        'type': 'POST',
				        'url': '{{ app_path }}/admin/panel/optimail/tables/bounce/objects',
				    },
				    "autoWidth": false,
				    "deferRender": true,
					"columnDefs": [
					    {   "targets": [1],
					        "visible": false,
					        "searchable": false
					    },
						{
						    "targets": [2, 3, 4, 5, 6],
						    "className": "text-center",
						},
						{
						    "targets": [6],
						    "orderable": false,
						}
					],
			        "columns": [
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           null,
			                "defaultContent": ''
			            },
			            {"data": "id"},
			            {"data": "name"},
			            {"data": "date"},
			            {"data": "nb_returned"},
			            {"data": "download"},
			            {"data": "delete"}
			        ],
			        "order": [[1, 'desc']]
			    });

			    $('#ocBounceTable tbody').on('click', 'td.details-control', function() {
			        var tr = $(this).closest('tr');
			        var row = table.row(tr);

			        if (row.child.isShown()) {
			            row.child.hide();
			            tr.removeClass('shown');
			        } else {
			            row.child(format(row.data())).show();
			            tr.addClass('shown');
			        }
			    });
			}
		});

		function deleteMe(elem) {
			var id = $(elem).attr("id");
	    	var res = id.split("-", 1);
			$.Zebra_Dialog('<strong>Warning!</strong> Are you really sure you want to delete these files?', {
			    type: 'warning',
			    title: 'Delete these files?',
			    buttons: [
			        {
			        	caption: 'Yes', 
			        	callback: function() {
						   	setTimeout(function () {
						       	window.location.replace("{{ app_path }}/admin/panel/optimail/tables/bounce/delete/files/" + res);
						    }, 500);
			        	}
			        },
			        {
			        	caption: 'Cancel', 
			        	callback: function() {}
			        }
			    ]
			});
		}

		function downloadBad(elem) {
			var id = $(elem).attr("id");
	    	var res = id.split("-", 1);
			$.Zebra_Dialog('Preparing the <strong>"Bad"</strong> file for download. Please wait...', {
			    type: 'confirmation',
			    custom_class: "ZebraDialog_Index",
			    buttons: false,
			    modal: false,
			    position: ['right - 20', 'top + 20'],
			    auto_close: 3000,
			    onClose: function(caption) {
				   	setTimeout(function () {
				       	window.location.replace("{{ app_path }}/admin/panel/optimail/tables/bounce/download/bad/" + res);
				    }, 500);
			    }
			});
		}
		</script>

{{ ::script_body_render }}

{{ @include::BereviCollectionPack:Main:adminPanel.php }}

				<div class="jumbotron masthead-page">
                    <div id="sidebar-wrapper">
                        <ul class="sidebar-nav">
                            <li class="sidebar-brand">
                                <span>Available applications</span>
                            </li>
                            <li>
                                <a href="{{ app_path }}/admin/panel/optimail" class="active">
                                    <img src="{{ app_path }}/images/panel/small-logo.png" alt="Optimail Cleaner logo 28x28">
                                    Optimail Cleaner
                                </a> 
                            </li>
                        </ul>
                    </div>
                    <p class="float-left brv-app-button" id="download">
                        <button type="button" class="btn btn-primary btn-sm" id="menu-toggle">Applications</button>
                        <button type="button" class="btn btn-light btn-sm" id="tour" onclick="location.href='{{ app_path }}/admin/panel/optimail/advanced';">
                        	<i class="fa fa-angle-double-left" aria-hidden="true"></i>
                        	Back to Optimail Cleaner
                        </button>
                    </p>
                    <div class="brv-global">
                        <h3 class="text-center brv-title">Optimail Cleaner</h3>
                        <p class="text-center brv-sub-title">Clean your email addresses intensively</p>
                    </div>
                    <hr>
					<div class="alert alert-primary" role="alert" style="{{ isRecordsMsg }}">
					  	<h4 class="alert-heading">No record available</h4>
					  	<p>Aww yeah, you have not started cleaning your mailbox yet and thereby do not have any records of available.</p>
					  	<hr>
					 	<p class="mb-0">Whenever you need to, be sure to use the bounce mail process before consulting your records.</p>
					</div>
					<div id="isRecords" class="alert alert-light" role="alert" style="{{ isRecords }}">
	                    <table id="ocBounceTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th></th>
					                <th>id</th>
					                <th>Name</th>
					                <th>Date</th>
					                <th>Nb returned</th>
					                <th>Download</th>
					                <th></th>
					            </tr>
					        </thead>
					        <tfoot>
					            <tr>
					                <th></th>
					                <th>id</th>
					                <th>Name</th>
					                <th>Date</th>
					                <th>Nb returned</th>
					                <th>Download</th>
					                <th></th>
					            </tr>
					        </tfoot>
					    </table>
					</div>
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

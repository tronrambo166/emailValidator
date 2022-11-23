<?php
$show_details					='yes';   	// choice : 'yes' or 'no'
$disposable_email				='yes';		// choice : 'yes' or 'no'
$check_mx						='yes';		// choice : 'yes' or 'no'

					
if(!empty($_POST['Check'])){
	if(!empty($_POST['email'])){
	
		$emails = get_email($_POST['email']);
		require_once('emailvalidclass.php'); //include emailvalidclass.php file
		$emailChecker = new emailChecker; // Make a new instance
		if($show_details=='yes'){ $emailChecker->supress_output = 0; }else{ $emailChecker->supress_output = 1; }
		if($disposable_email=='yes'){ $emailChecker->filter_dea = 1; }else{ $emailChecker->filter_dea = 0; }
		if($check_mx=='yes'){ $emailChecker->check_mx = 1; }else{ $emailChecker->check_mx = 0; }
		$emailChecker->smtp_test = 0; 

		$emailsubmited=count($emails);	
							
		echo '<br><b>Emails : </b>'.$emailsubmited;
							
							echo '<hr><table cellpadding="10" cellspacing="10" border="1" style="margin-top: 15px;">
									<tr style="font-size:20px;background-color:black;color:white">
										<td>Email</td>
										<td>Passed</td>';
							if($show_details=='yes'){ 
										echo '<td style="text-align:left">Email valid ?</td>';
										if($disposable_email=='yes'){	
											echo '<td>Disposable ?</td>';
										 }  
										if($check_mx=='yes'){
											echo '<td>Domain MX Check ?</td>';
										 }  
							}  
								echo '	</tr>';
							$array_good_emails=array();
							$array_bad_emails=array();
							$array_good_no_duplicate_emails=array();    
							
							foreach((array)$emails as $key=>$e){
							
								if(empty($e)) continue;
							
								$e = $emailChecker->check($e);
								$e = $e['result'];
								// echo '<pre>';
								// print_r($e);
								// echo '</pre>';
								if($e['success']){
									$array_good_emails[]=htmlspecialchars($e['query']);
								}else{
									$array_bad_emails[]=htmlspecialchars($e['query']); 
								}
							?>
						<tr>
							<td><?php echo htmlspecialchars($e['query']); ?></td>
							
							<?php if($e['success']){
										echo '<td style="background-color:green">yes</td>';				
									}else{
										echo '<td style="background-color:red">no</td>';				
									}
							?>
							
							
							<td>
							<?php if(!empty($e['report']['validate_email'])){ 
										echo 'yes';				
									}elseif(!empty($e['errors']['validate_email'])){
										echo 'no';				
									}
							?>
							</td>
<?php if($show_details=='yes'){ ?>
	<?php if($disposable_email=='yes'){ ?>		
						<td>	
								<?php if(!empty($e['report']['filter_dea'])){ 
											echo 'no';
										}elseif(!empty($e['errors']['filter_dea'])){
											echo 'yes';
										}else{
											echo '-';
										}
								?>	
						</td>
	<?php } ?>
	<?php if($check_mx=='yes'){  ?>
								<?php if(!empty($e['report']['check_mx'])){ 
											echo '<td>yes</td>';
										}elseif(!empty($e['errors']['check_mx'])){
											echo '<td>no</td>';
										}else{
											echo '<td>-</td>';
										}
								?>
	<?php } ?>
<?php } ?>
						</tr>

						<?php
							}
							echo '</table><br><br>';
							
						?>
	<div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Show Passed/Good Emails</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                                        <div class="panel-body" style="color:black">
                                            <?php echo implode("<br>",$array_good_emails); ?>
                                        </div>
                                    </div>
                                </div>				
	<div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Show Bad Emails</a>
                                        </h6>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body" style="color:black">
                                            <?php echo implode("<br>",$array_bad_emails); ?>
                                        </div>
                                    </div>
                                </div>
    <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="collapsed">Show Passed/Good Emails (without duplicate emails) </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse">
                                        <div class="panel-body" style="color:black">
                                            <?php $array_good_no_duplicate_emails=array_unique($array_good_emails); 
												echo implode("<br>",$array_good_no_duplicate_emails); ?>
                                        </div>
                                    </div>
                                </div>				
						
						
		
						<?php

		

	}else{
		echo 'Email field empty. Please, try again';
	}	
}


function get_email($text) {
						## Regex taken from http://bit.ly/Tq2PYP PHP's FILTER_VALIDATE_EMAIL function.
						$email_pattern = "/(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))/i";
						$raw = $text;						
						$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
						$content = str_replace($newlines, "----", html_entity_decode($raw));
						$content2 = preg_replace("/\s/", "-", $content);
						$content2 = preg_replace("/\-+/", "|", $content2);
						$content2 = explode("|", $content2);
						
						$emails = array();
						foreach( $content2 as $line) {
							preg_match("/@/", $line, $match);
							if( count($match) > 0 ) {
								preg_match_all($email_pattern, $line, $email_match);
								if( count($email_match) > 0 ) {
									foreach($email_match[0] as $key=>$email) {
										$emails[] = $email;
									}
								}
							}
						}
						
						return $emails;
					}
?>
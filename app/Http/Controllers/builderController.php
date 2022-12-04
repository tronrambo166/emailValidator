<?php

namespace App\Http\Controllers;  
//use App\Validation\Controller;
use Illuminate\Http\Request;
use App\Validation\Standardize;
use App\Validation\MailCleaner;
use App\Validation\BounceMailHandler;
use App\Http\Controllers\fileController;
use SMTPValidateEmail\Validator as SmtpEmailValidator;
use App\Models\RoleBasedEmails;
use EmailChecker\EmailChecker;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;


class builderController extends BaseController
{

     public function __construct()
    {
        parent::__construct();
    }


    public function home()
    {
        return view('builder.mail-cleaner'); 
    }

     public function validator()
    {
        return view('builder.mail-validate');
    }

     public function textToEmails(){
        $user_id = Auth::id();
        return view('builder.textToEmails');
    }


    public function ExtractEmails(Request $request){
    $user_id = Auth::id();
    $string = $request->string;
    $pattern ='/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
    preg_match_all($pattern, $string, $matches);
    Session::put('extract',$matches[0]); Session::save();
    return redirect()->back();
    //$files=DB::table('files')->where('user_id',$user_id)->orderBy('id','DESC')->get();
        //return view('builder.textToEmails',compact('files'));
    }


    public function history(){
         $user_id = Auth::id();
        $files=DB::table('files')->where('user_id',$user_id)->orderBy('id','DESC')->get();
   
        return view('builder.history',compact('files'));
    }

     public function clean_mail(Request $request)
    {   
        $fileName = $request->name.'.txt'; 
        if($request->name == '') $fileName = 'emails.txt';
        $emails= array();$i=0; //return $request->all();

        //MX
        $helo = $_SERVER ['HTTP_HOST'];
        $from = "info@mail.com";
        //MX

        if($request->fileInput!=null) 
        { 
        $inputFile = $request->file('fileInput');
        $emails = fileController::convert($inputFile, ',');
        if(!$emails) return "File not readable!";
         foreach($emails as $e)
         {

          if($e != ''){   
         $e = $this->clean($e);  
         $emails[$i] = $e;$i++; 
          }
         }  
        }
        else
        {
        $all= explode(PHP_EOL,$request->emails); 
            foreach($all as $e)
            {
             if($e != ''){     
             $e = $this->clean($e);  
             $emails[$i] = $e; $i++;
             } 
            }
            
        }

        

        $order = $request->ascOrDesc;
        $tld_Sld = $request->tldAndSld;
        

        $emails=$this->sorter($tld_Sld,$order,$emails);
        //return print_r($emails);


        header("Content-type: text/csv");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename='.$fileName);
        $file = fopen('php://output','w');
        foreach($emails as $email) echo $email.PHP_EOL;
           
                
    }



 public function mx_check(Request $request)
    {   
        $helo = $_SERVER ['HTTP_HOST'];
        $from = "info@mail.com";
        $smtp_qlfied=array();
        //MX

        $fileName = $request->name.'.txt'; 
        if($request->name == '') $fileName = 'emails.txt';
        $emails= array();$i=0;$j=0; //return $request->all();

        if($request->fileInput!=null) 
        { 
        $inputFile = $request->file('fileInput');
        $emails = fileController::convert($inputFile, ',');
        if(!$emails) return "File not readable!"; 
         foreach($emails as $e)
         {
         //$e = $this->clean($e);  
         $emails[$i] = $e;$i++; 
         }  
        }
        else
        {
        $all= explode(PHP_EOL,$request->emails); 
            foreach($all as $e)
            {
             //$e = $this->clean($e);
             if($e != ''){  
             $emails[$i] = $e; $i++;
             } 
            }
            
        }

// Emails are stored in $emails array();
//echo '<pre>'; print_r($emails); echo '<pre>';  exit;
$result = array();

  
  //SYNTAX  
  foreach($emails as $email){ 
  $result[$j]['email']  =$email; 
  //if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  if (! preg_match ( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email )) {
          $result[$j]['good']  = 'False';
    } else $result[$j]['good']  = 'True';
    $j++;
}
        
//$scriptpass = "E35DCBD20CC0";$password = 'E35DCBD20CC0'; //$_GET ["password"];
//if ($password != $scriptpass) {echo "<check>96DA8A550749</check><server>Verify Script</server><message>603 Wrong Password</message><log></log>";return;}



 //MX  
$j=0;foreach($emails as $email){
$mx = $this->mx( $email, $from, $helo); 
if($mx=='failed' || $mx=='Bad') $result[$j]['mx']  = 'False';
else { $result[$j]['mx'] = 'True'; $smtp_qlfied[]=$email; } $j++; 
} //echo '<pre>'; print_r($result); echo '<pre>';  exit;

 //SMTP
$smtp = $this->SMTP($smtp_qlfied);$smtp_true=array();
$j=0;foreach($smtp as $key => $value) {
//$result[$j]['smtp'] = 'False';
if($value == 1) $smtp_true[$j] = $key; 
$j++; } 



//Disposable
$checker = new EmailChecker();
$j=0;foreach($emails as $email){

//smtp fill
$result[$j]['smtp'] = 'False';
foreach($smtp_true as $sm)
if($sm == $email) $result[$j]['smtp'] = 'True';
//smtp fill


$res = $checker->isValid($email);     // true
if($res == 1) $result[$j]['dispose']='False';
else $result[$j]['dispose']='True'; $j++;
}
//echo '<pre>'; print_r($result); echo '<pre>';  exit;


//ROLE BASED  
$roleList = RoleBasedEmails::ifRole();$j=0;
foreach($emails as $email){
$result[$j]['role']  = 'False';
list($name) = explode("@", $email); 

foreach($roleList as $role){ 
if($name==$role) { $result[$j]['role']  = 'True'; break; }
} $j++;
}
 // echo '<pre>'; print_r($result); echo '<pre>';  exit;

//CLEAN for DOWNLOAD
$cleanResult =$result;
foreach($cleanResult as $key => $value) 
$cleanResult[$key]['email']=$this->clean($value['email']);
//echo '<pre>'; print_r($cleanResult); echo '<pre>'; exit;

//DB INSERT
 $user_id = Auth::id();
DB::table('files')->
insert(['user_id'=>$user_id, 'info'=>json_encode($cleanResult), 
    'file_name'=>$fileName, 'date'=> date('M d, Y')]);

//DB GET
$i=0;
$files=DB::table('files')->where('user_id',$user_id)->orderBy('id','DESC')->get();


//ECHO TABLE 

echo '<table cellpadding="12"  border="" style="float:left; border:none; font-family:monospace;margin-top: 37px; ">
<tr style="font-size:14px;background-color:white;color:black";>
<td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">Processed</td>

     </tr>';

  echo '<td style=" border:none; text-align:center;font-weight:bold;color:green">';

  foreach($files as $fileData) { 
    $info = str_replace('{','-',str_replace('"',';',$fileData->info));

    echo '<span style="margin-top:15px;">'.$fileData->file_name.'</span>
   <a style="float:right; font-size:12px;color:black; margin-bottom:15px;" href="./mail_rep_dld/'.$info.'/'.$fileData->file_name.'">Download</a></br></br>';
   if($i==0) echo'<p style="background-color:azure;margin-top:15px;">Previous</p> ';$i++;
}

  echo '</td>';
  echo '</tr></table><br><br>';  


//ECHO TABLE 2
echo '<table cellpadding="12"  border="" style="border:none; font-family:monospace;margin-top: 15px; margin:auto;">
<tr style="font-size:14px;background-color:white;color:black";>
    <td style="border:1px solid #dedde7;text-align:center;border-radius: 10px;" >Email</td> 
    <td style="text-align:center;border:1px solid #dedde7;border-radius: 14px;width:120px; ">Good</td> 
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">MX</td>
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">SMTP</td>
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">Disposable</td>
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">Role Based</td>

    

       </tr> <a style="float:right; " href="./mail_rep_dld/"></a>';

  foreach($result as $res) {
  echo '<tr style="margin-top:15px;">
  <td style="text-align:center;font-weight:bold;background-color:#008353;color:white;">'.$res['email'].'</td>';

  if($res['good']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['mx']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['smtp']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['dispose']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['role']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';



    }


   
echo '</tr></table><br><br>'; 

Session::forget('mail_result');
Session::put('mail_result',$result); Session::put('fileName',$fileName);
Session::save();
 exit;
//ECHO TABLE

//DOWNLOAD
        header("Content-type: text/csv");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename='.$fileName);
        $file = fopen('php://output','w');
        foreach($mx as $m) echo $m.PHP_EOL;
           
                
    }


public function mail_rep_dld($result,$name)
{ 
$result = str_replace('-','{',str_replace(';','"',$result));
$result= json_decode($result);
///print_r($result); exit;

$fileName= $name;//'emails'.uniqid().'.txt';

//DOWNLOAD 
        header("Content-type: text/csv");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename='.$fileName);
        $file = fopen('php://output','w');
        foreach($result as $res)
        { 
         foreach($res as $key => $value) {  
            echo $key.' = '.$value.PHP_EOL;
             } echo PHP_EOL;
         }
           

}


//SINGLE_______________________________________________________________________________________
public function single_mail(Request $request)
    { 
        return view('builder.single-validate');
    }
 public function single_validate(Request $request)
    {   
        $helo = $_SERVER ['HTTP_HOST'];
        $from = "info@mail.com";
        $smtp_qlfied=array();
        //MX

        $fileName = $request->name.'.txt'; 
        if($request->name == '') $fileName = 'emails.txt';
        $emails= array();$i=0;$j=0; //return $request->all();

        if($request->fileInput!=null) 
        { 
        $inputFile = $request->file('fileInput');
        $emails = fileController::convert($inputFile, ',');
        if(!$emails) return "File not readable!"; 
         foreach($emails as $e)
         {
         //$e = $this->clean($e);  
         $emails[$i] = $e;$i++; 
         }  
        }
        else
        {
        $all= explode(PHP_EOL,$request->emails); 
            foreach($all as $e)
            {
             //$e = $this->clean($e);
             if($e != ''){  
             $emails[$i] = $e; $i++;
             } 
            }
            
        }

// Emails are stored in $emails array();
//echo '<pre>'; print_r($emails); echo '<pre>';  exit;
$result = array();

  
  //SYNTAX  
  foreach($emails as $email){ 
  $result[$j]['email']  =$email; 
  //if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  if (! preg_match ( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email )) {
          $result[$j]['good']  = 'False';
    } else $result[$j]['good']  = 'True';
    $j++;
}
        
//$scriptpass = "E35DCBD20CC0";$password = 'E35DCBD20CC0'; //$_GET ["password"];
//if ($password != $scriptpass) {echo "<check>96DA8A550749</check><server>Verify Script</server><message>603 Wrong Password</message><log></log>";return;}



 //MX  
$j=0;foreach($emails as $email){
$mx = $this->mx( $email, $from, $helo); 
if($mx=='failed' || $mx=='Bad') $result[$j]['mx']  = 'False';
else { $result[$j]['mx'] = 'True'; $smtp_qlfied[]=$email; } $j++; 
} //echo '<pre>'; print_r($result); echo '<pre>';  exit;

 //SMTP
$smtp = $this->SMTP($smtp_qlfied);$smtp_true=array();
$j=0;foreach($smtp as $key => $value) {
//$result[$j]['smtp'] = 'False';
if($value == 1) $smtp_true[$j] = $key; 
$j++; } 



//Disposable
$checker = new EmailChecker();
$j=0;foreach($emails as $email){

//smtp fill
$result[$j]['smtp'] = 'False';
foreach($smtp_true as $sm)
if($sm == $email) $result[$j]['smtp'] = 'True';
//smtp fill


$res = $checker->isValid($email);     // true
if($res == 1) $result[$j]['dispose']='False';
else $result[$j]['dispose']='True'; $j++;
}
//echo '<pre>'; print_r($result); echo '<pre>';  exit;


//ROLE BASED  
$roleList = RoleBasedEmails::ifRole();$j=0;
foreach($emails as $email){
$result[$j]['role']  = 'False';
list($name) = explode("@", $email); 

foreach($roleList as $role){ 
if($name==$role) { $result[$j]['role']  = 'True'; break; }
} $j++;
}
 // echo '<pre>'; print_r($result); echo '<pre>';  exit;

//CLEAN for DOWNLOAD
//$cleanResult =$result;
//foreach($cleanResult as $key => $value) 
//$cleanResult[$key]['email']=$this->clean($value['email']);
//CLEAN for DOWNLOAD

echo '<pre>'; print_r($result); echo '<pre>'; exit;

//STOP HERE****

//DB INSERT
 $user_id = Auth::id();
DB::table('files')->
insert(['user_id'=>$user_id, 'info'=>json_encode($cleanResult), 'file_name'=>$fileName]);

//DB GET
$i=0;
$files=DB::table('files')->where('user_id',$user_id)->orderBy('id','DESC')->get();


//ECHO TABLE 

echo '<table cellpadding="12"  border="" style="float:left; border:none; font-family:monospace;margin-top: 37px; ">
<tr style="font-size:14px;background-color:white;color:black";>
<td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">Processed</td>

     </tr>';

  echo '<td style=" border:none; text-align:center;font-weight:bold;color:green">';

  foreach($files as $fileData) { 
    $info = str_replace('{','-',str_replace('"',';',$fileData->info));

    echo '<span style="margin-top:15px;">'.$fileData->file_name.'</span>
   <a style="float:right; font-size:12px;color:black; margin-bottom:15px;" href="./mail_rep_dld/'.$info.'/'.$fileData->file_name.'">Download</a></br></br>';
   if($i==0) echo'<p style="background-color:azure;margin-top:15px;">Previous</p> ';$i++;
}

  echo '</td>';
  echo '</tr></table><br><br>';  


//ECHO TABLE 2
echo '<table cellpadding="12"  border="" style="border:none; font-family:monospace;margin-top: 15px; margin:auto;">
<tr style="font-size:14px;background-color:white;color:black";>
    <td style="border:1px solid #dedde7;text-align:center;border-radius: 10px;" >Email</td> 
    <td style="text-align:center;border:1px solid #dedde7;border-radius: 14px;width:120px; ">Good</td> 
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">MX</td>
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">SMTP</td>
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">Disposable</td>
    <td style="border:1px solid #dedde7;width:120px; border-radius: 10px;text-align:center;">Role Based</td>

    

       </tr> <a style="float:right; " href="./mail_rep_dld/"></a>';

  foreach($result as $res) {
  echo '<tr style="margin-top:15px;">
  <td style="text-align:center;font-weight:bold;background-color:#008353;color:white;">'.$res['email'].'</td>';

  if($res['good']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['mx']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['smtp']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['dispose']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';

  if($res['role']=='True') echo '<td style="text-align:center;font-weight:bold;color:green">Yes</td>'; 
  else echo '<td style="text-align:center;font-weight:bold;color:black;">No</td>';



    }


   
echo '</tr></table><br><br>'; 

Session::forget('mail_result');
Session::put('mail_result',$result); Session::put('fileName',$fileName);
Session::save();
 exit;
//ECHO TABLE

//DOWNLOAD
        header("Content-type: text/csv");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename='.$fileName);
        $file = fopen('php://output','w');
        foreach($mx as $m) echo $m.PHP_EOL;
           
                
    }

    //SINGLE___________________________________________________________________________________________





// ______________ Helper Functions ______________ //

    public function SMTP($emails = array())
{
$sender    = 'sohaankane@example.org';
$validator = new SmtpEmailValidator($emails, $sender);
$results   = $validator->validate();
return $results;
//echo '<pre>'; print_r($results); echo '<pre>';  exit;
  }

    
    //

    public function mx($Email, $From, $Helo) {
    $result = array ();
    
    if (! preg_match ( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $Email )) {
        $result [0] = "500 Bad Syntax";
        return 'Bad';
    }
    
    list ( $Username, $Domain ) = explode ( "@", $Email );
    if($Domain == 'maildrop.cc' || $Domain == 'emaxple.com') return 'true';

    $log='';
    if (checkdnsrr ( $Domain, "MX" )) {
        $log .= "MX record about {$Domain} exists:\r";
        if (getmxrr ( $Domain, $MXHost )) {
            //for ( $i = 0,$j = 1; $i < count ( $MXHost ); $i++,$j++ )
        //{
        //    $log .= "$MXHost[$i]\r";
        //}
        }
        
        $ConnectAddress = $MXHost [0];
        $log .= $ConnectAddress . "\r";
    
    } else {
        return 'failed';
        $ConnectAddress = $Domain;
        $log .= "MX record about {$Domain} does not exist.\r";
    }
    
    $Connect = fsockopen ( $ConnectAddress, 25 );
    $result [1] = $ConnectAddress;
    
    // Success in socket connection
    if ($Connect) {
        $log .= "Connection succeeded to {$ConnectAddress} SMTP.\r";
        
        $reply = fgets ( $Connect, 1024 );
        $log .= $reply."\r";
        
        // Finish connection.
        fputs ( $Connect, "QUIT\r\n" );
        $log .= "> QUIT\r";
        fclose ( $Connect );
    } // Failure in socket connection
    else {
        $result [0] = "500 Can not connect E-Mail server: ({$ConnectAddress}).";
        $result [2] = $log;
        return $result;
    }
    $result [0] = $reply;
    $result [2] = $log;
    return $result;
}



    public function clean($string)
    {
        $string = str_replace(' ', '', $string);
       
        $string = preg_replace('/[^A-Za-z0-9-@.\-]/', '', $string); //echo $string; exit;
        return $string = str_replace('..', '.', $string);
    }


    public function sorter($domainLevel, $order, array $emails = array())
    {
        if ($domainLevel == "tld") {
            $newlines = [];
            foreach ($emails as $email) {
                $newlines[] = strrev($email);
            }

            if ($order == "asc") {
                sort($newlines, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($newlines, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($newlines, SORT_NATURAL | SORT_FLAG_CASE);
            }

            foreach ($newlines as $email) {
                $reallines[] = strrev($email);
            }

            return $reallines;
        } elseif ($domainLevel == "ccTld") {
            $a = $b = $ax = $bx = [];
            foreach ($emails as $email) {
                $x = substr(strrev(trim($email)), 0, 3);
                (strpos($x, '.') !== false) ? $a[] = strrev($email) : $b[] = strrev($email);
            }

            if ($order == "asc") {
                sort($a, SORT_NATURAL | SORT_FLAG_CASE);
                sort($b, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($a, SORT_NATURAL | SORT_FLAG_CASE);
                rsort($b, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($a, SORT_NATURAL | SORT_FLAG_CASE);
                sort($b, SORT_NATURAL | SORT_FLAG_CASE);
            }

            foreach ($a as $lineA) {
                $ax[] = strrev($lineA);
            }

            foreach ($b as $lineB) {
                $bx[] = strrev($lineB);
            }

            return array_merge($ax, $bx);
        } elseif ($domainLevel == "sld") {
            $a = $b = $c = $ax = $bx = [];
            foreach ($emails as $email) {
                $x = trim($email);
                if (strpos($x, '@') !== false) {
                    $y = explode("@", $x);
                    $a[] = $y[1];
                    $b[] = $y[0];
                } else {
                    $c[] = $x;
                }
            }

            foreach ($a as $key => $value) {
                $ax[] = $value."@".$b[$key];
            }

            if ($order == "asc") {
                sort($ax, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($ax, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($ax, SORT_NATURAL | SORT_FLAG_CASE);
            }

            foreach ($ax as $key => $value) {
                list($sld, $local) = explode('@', $value);
                $bx[] = $local.'@'.$sld;
            }

            if ($order == "asc") {
                sort($c, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($c, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($c, SORT_NATURAL | SORT_FLAG_CASE);
            }
        
            return array_merge($bx, $c);
        } 

        elseif ($domainLevel == "none" && $order == "asc") {
            sort($emails, SORT_NATURAL | SORT_FLAG_CASE);

            return $emails;
        } elseif ($domainLevel == "none" && $order == "desc") {
            rsort($emails, SORT_NATURAL | SORT_FLAG_CASE);

            return $emails;
        }

        return $emails;
    }

}



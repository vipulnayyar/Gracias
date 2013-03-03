<center>
<h1>
Currently, this app is in <i> Alpha </i> Phase. <br/>
and is being tested by the developer himself.
<form method="POST" action="index.php">

<label> Wanna join the team in building this application ?? </label>
<input type="text" name="email"  placeholder="Enter Your Email" /> <br/>
<input type="submit" value="Submit" />  
</form>
</h1>
</center>



<?php
include "config.inc.php";


if(isset($_REQUEST['email']))
{
$dbh->Query('INSERT INTO developers(`email`) VALUES("'.$_REQUEST['email'].'") ');  

?>
You'll be contacted .
<img src="homer.gif" />


<?php }



require 'sdk/facebook.php';
//set_time_limit(0);


$app_id = "";
$app_secret = ""; 
$my_url = "http://apps.facebook.com/birth_app";
$mytoken="";



$facebook = new Facebook(array(
  'appId'  => '',
  'secret' => '',
));


// Get User ID
$user = $facebook->getUser();
if ($user) {

  $res=$dbh->Query('Select * from app_user WHERE uid=\''.$user.'\' ');
  //echo "enter";
            if(mysql_num_rows($res)>=1);
            else{ 

                        try{ 
                              //echo "try";
                              $name = $facebook->api('/me', 'GET');

                              }catch(FacebookApiException $e) { 
                              echo "fail";

                              echo $e->getMessage();
                             }
                         $dbh->Query('Insert INTO app_user(`uid`,`name`) VALUES(\''.$user.'\', \''.$name['name'].'\') '); 

                }




  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $params = array(
  'scope' => 'read_stream, publish_stream',
  'redirect_uri' => 'http://apps.facebook.com/birth_app'
);

$loginUrl = $facebook->getLoginUrl($params);
echo "<script type='text/javascript' >";
echo 'top.location.href=\''.$loginUrl.'\''; 
echo "</script>";

}

$access_token ="";
$facebook->setAccessToken($mytoken);



$fql="SELECT post_id, actor_id, target_id, message FROM stream WHERE filter_key = 'others' AND source_id = me() AND target_id=me() AND created_time>1350691200 LIMIT 500";

$ret_obj = $facebook->api(array(
                                   'method' => 'fql.query',
                                   'query' => $fql,
                                 ));



foreach($ret_obj as $post)
{

				try {



$message = array("happy", "birthday", "wishes", "hapy","bday", "b\'day", "party", "vipul",

      "wish","loads","fun","Happy","HAPPY","BIRTHDAY","BDAY", "B\'DAY","Bday","Birthday"

  );  

$j=0;
$ct=0;

while($j< sizeof($message))
{

if((strpos($post['message'], $message[$j++]))|| (  strpos($post['message'], $message[$j++]) >= 0   ) ) {$ct=1; break; }



}


if ((strpos($post['message'], 'happy') )|| (strpos($post['message'], 'birthday') ) ||  ( strpos($post['message'], 'wishes') ) || 
  (strpos($post['message'], 'hapy') ) ||   (strpos($post['message'], 'bday')) || (strpos($post['message'], 'b\'day') ) ||
  (strpos($post['message'], 'party')) || (strpos($post['message'], 'vipul')) ||   (strpos($post['message'], 'wish') )|| 
  (strpos($post['message'], 'loads')) ||   (strpos($post['message'], 'fun')) || (strpos($post['message'], 'Happy') ) ||
  (strpos($post['message'], 'HAPPY')) || (strpos($post['message'], 'BIRTHDAY')) || (strpos($post['message'], 'BDAY') ) ||
  (strpos($post['message'], 'B\'DAY')) || (strpos($post['message'], 'Bday')) || (strpos($post['message'], 'Birthday') ) )
  $msg1='Thanks for your well wishes !! .... :-).....................................................................................................................Astonished o.O , that i replied in less than 30 seconds...................................................................................................................................................................................................................................................................................................................................................................................................................................................................... (This was a system generated response :-p )';
else $msg1='Thanks for your post !! .... :-).....................................................................................................................Astonished o.O , that i replied in less than 30 seconds...................................................................................................................................................................................................................................................................................................................................................................................................................................................................... (This was a system generated response :-p )';


if($ct==1)
  $msg1='Thanks for your well wishes !! .... :-)..................................................................................................................Astonished o.O , that i replied in less than 30 seconds...................................................................................................................................................................................................................................................................................................................................................................................................................................................................... (This was a system generated response :-p )';
else $msg1='Thanks for your post !! .... :-)..................................................................................................................Astonished o.O , that i replied in less than 30 seconds...................................................................................................................................................................................................................................................................................................................................................................................................................................................................... (This was a system generated response :-p )';

         
//echo strpos($post['message'], 'happy') ;


        						$res=$dbh->Query('Select * from posts WHERE post_id=\''.$post['post_id'].'\' ');
        						     

        						if(mysql_num_rows($res)==0){ $dbh->Query('Insert INTO tests(`test`) VALUES(\'CRON new\') '); 



                                        if (isset($dbh)&&($res)) {
                                            $post_obj = $facebook->api('/'.$post['post_id'].'/comments', 'POST',
                                                  array(
                                                    'message' => $msg1
                                               ));   

                                          }








                                         $dbh->Query('INSERT INTO posts(`post_id`,`comment_id`) VALUES(\''.$post['post_id'].'\',\''.$post_obj['id'].'\')');
        								 


        						 	}else $dbh->Query('Insert INTO tests(`test`) VALUES(\'CRON TEST\') ');  




					} catch(FacebookApiException $e) { 
						echo "fail";

						echo $e->getMessage();
					 }






}





?>

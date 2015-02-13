<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  ini_set('default_socket_timeout', -1);
  ini_set('MAX_EXECUTION_TIME', -1);


  $servername = "localhost";
  $username = "admin";
  $password = "123!@#456$%^";

  /**
  INSERT TAGS FOR POSTS !
  */


  $conn=mysqli_connect("localhost",$username, $password, "ContentDB_161");
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    writeLog(mysqli_connect_error());
    return;
  }
  // Try add tags 


  writeLog("Try get all results from DB for USERS.");

  $results = mysqli_query($conn, "
                                    select * from contentdb_161.Users
                                    where wusUserID <> 0
                                    order by wusShortName ;
                                    ");

  echo "Try get results..";

  $i = 0;

  while ($row = mysqli_fetch_array($results, MYSQL_ASSOC)) 
  {
    $user = array();
    $user['wusLogin'] = $row['wusLogin'];
    $user['wusDescription'] = $row['wusDescription'];
    $user['wusEMail'] = $row['wusEMail'];
    $user['wusCreated'] = $row['wusCreated'];
    $user['wusActiveFL'] = $row['wusActiveFL'];
    $user['wusShortName'] = $row['wusShortName'];
    $users[$i] = $user;
    $i++;
  }

  writeLog("All USERS collected from MSSQL.");

  mysqli_free_result($results);
  mysqli_close ($conn);

  require('./wp-load.php');
  $tot = $i-1;

  echo "<br/> Start inserting total USERS: ". $tot;
  writeLog("Start inserting total USERS: ". $tot );

  foreach ($users as $user) 
  {

    if( empty($user['wusEMail']) )
      $user_email = $user['wusLogin'] ."@news.gr";
    else    
      $user_email = $user['wusEMail'];

    $user_id = username_exists( $user_email );
    if ( !$user_id and email_exists( $user_email ) == false ) 
    {

      // create an auto passwd
      $user_pass_rand = wp_generate_password( $length=12, $include_standard_special_chars=false );  // When creating an user, `user_pass` is expected.

      $userdata = array(
            'user_login'      =>  $user['wusLogin'] ,     // user_name
            'first_name'      =>  substr($user['wusDescription'], 0, strpos($user['wusDescription'], " ")),
            'last_name'       =>  substr($user['wusDescription'] , strpos($user['wusDescription'], " ")),
            'user_email'      =>  $user_email,
            'user_nicename'   =>  $user['wusShortName'] ,
            'user_registered' =>  $user['wusCreated'],
            'display_name'    =>  substr($user['wusDescription'] , strpos($user['wusDescription'], " ")),
            'role'            =>  ($user['wusActiveFL']==1 ? 'Contributor' : NULL), 
            'user_pass'       =>  $user_pass_rand
      );

      $user_id = wp_insert_user( $userdata ) ;    

      //On success
      if( !is_wp_error($user_id) ) {
        writeLog("User created OK,  username: ". $user['wusLogin'] . " passwrod: " . $user_pass_rand);
        echo "<br/> User created : ". $user_id . " username: " .  $user['wusLogin'] ;
      } 
      else
        echo $wp_error->get_error_message();
    }

  }


  echo "<br/>Finished inserting USERS successfully. ";
  writeLog("Finished inserting USERS successfully");

  die();


  function writeLog($data)
  {
    file_put_contents(  $_SERVER['DOCUMENT_ROOT'] . "\\errorLog.txt" ,  date("Y-m-d H:i:s"). " -> " . $data . "\n", FILE_APPEND );
  }


?>	


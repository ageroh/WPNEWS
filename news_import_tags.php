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

  $limit = 50;
  writeLog("Try get all results from DB for TAGS. Limit set to " . $limit);

  $results = mysqli_query($conn, "
                                    SELECT 
                                      e.ententityid as ID
                                      , aTags.enrEntityID as tagID
                                      , enrRank as Rank
                                      , caeCategoryID  as Parent
                                    FROM contentdb_161.entity e
                                      INNER join
                                      ( SELECT  ententityid,
                                        @curRow := @curRow + 1 AS row_number
                                      FROM    contentdb_161.entity l
                                      JOIN    (SELECT @curRow := 0) r
                                      WHERE entstatusid = 3 AND entEntityTypeID IN ( 1 ) 
                                      ORDER BY entPublished DESC
                                      LIMIT ". $limit . " ) cut
                                        ON cut.ententityid = e.ententityid
                                    INNER JOIN contentdb_161.Entity_Relation aTags
                                      ON aTags.enrParentEntityID = cut.entEntityID
                                      and enrRelationID = 20 
                                    INNER JOIN contentdb_161.Category_Entity
                                      ON caeEntityId = enrEntityID      
                                    INNER JOIN contentdb_161.category cat 
                                      ON cat.catCategoryID = caeCategoryID
                                      AND  cat.catCategoryID not in ( 1, 86,87,109,143,144,145,146,147,152,153,154,155,156,157,158,159,160,22,142,82,4,3)
                                    order by cut.row_number asc;
                                    ");

  echo "Try get results..";

  $i = 0;

  while ($row = mysqli_fetch_array($results, MYSQL_ASSOC)) 
  {
    $post = array();
   
    $post['post_id'] = $row['ID'];
    $post['tagID'] = $row['tagID'];
    $post['Rank'] = $row['Rank'];
    $post['Parent'] = $row['Parent'];

    $posts[$i] = $post;
    $i++;
  }

  writeLog("All tags-articles collected from MSSQL.");

  mysqli_free_result($results);
  mysqli_close ($conn);

  require('./wp-load.php');
  $tot = $i;

  echo "<br/>Start inserting total tags: ". $tot;
  writeLog("Start inserting total tags: ". $tot );

  foreach ($posts as $post) 
  {

    // do only if post exisst:
    if(acme_post_exists($post['post_id']))
    {
      
      
      $wp_error = addTerm($post['post_id'], 'post_tag', $post['tagID'],   $post['Rank'] ,  $post['Parent']) ; 
      if( is_wp_error( $wp_error ) ) 
      {
        echo $wp_error->get_error_message();
        writeLog($wp_error->get_error_message());
        return;
      }
      else 
      {
        echo "<br/>Inserted tagId: " . $post['tagID']. " for ". $post['post_id'];
      }

      writeLog("Inserted tagId: " . $post['tagID']. " for ". $post['post_id'] . ", " . $wp_error );

    }
  }

  echo "<br/>Finished inserting tags successfully. ";
  writeLog("Finished inserting tags successfully");

  die();

  function acme_post_exists( $id ) {
    return is_string( get_post_status( $id ) );
  }


  function addTerm($id, $tax, $term, $rank, $parent) {

      if( is_term(intval($term)) )
      {
        $result = wp_set_post_terms( $id,  array(intval($term)), $tax, TRUE );
        echo " " . $result;
        return $result;
      }

  }


  function writeLog($data)
  {
    file_put_contents( $_SERVER['DOCUMENT_ROOT'] . "\\errorLog.txt" ,  date("Y-m-d H:i:s"). " -> " . $data . "\n", FILE_APPEND );
  }


?>	


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
    return;
  }
  // Try add tags 
  echo "<br/> Connection successfully to MySQL.";

  $results = mysqli_query($conn, "
                                  SELECT 
                                        ententityid as ID
                                      , aTags.enrEntityID as tagID
                                      , enrRank as Rank
                                      , caeCategoryID  as Parent
                                    FROM contentdb_161.entity 
                                    INNER JOIN contentdb_161.Entity_Relation aTags
                                      ON aTags.enrParentEntityID = entity.entEntityID
                                      and enrRelationID = 20 
                                     inner join contentdb_161.Category_Entity
                                    on caeEntityId = enrEntityID      
                                    INNER JOIN contentdb_161.category cat 
                                      ON cat.catCategoryID = caeCategoryID
                                      AND  cat.catCategoryID not in ( 1, 86,87,109,143,144,145,146,147,152,153,154,155,156,157,158,159,160,22,142,82,4,3)
                                    WHERE  entstatusid = 3 
                                      AND entEntityTypeID IN ( 1 ) 
                                    ORDER BY entPublished DESC 
                                    LIMIT 1000; ");

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

  mysqli_free_result($results);
  mysqli_close ($conn);

  require('./wp-load.php');
  $tot = $i;

  echo "<br/>Start inserting total tags: ". $tot;
  writeLog("Start inserting total tags: ". $tot . "\n");

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

      writeLog("Inserted tagId: " . $post['tagID']. " for ". $post['post_id'] . ", " . $wp_error . "\n");

    }
  }

  echo "<br/>Finished inserting tags successfully. ";
  writeLog("Finished inserting tags successfully" . "\n");

  die();

  function acme_post_exists( $id ) {
    return is_string( get_post_status( $id ) );
  }


/*  // not used
  function slugify($text)
  { 
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
    return 'n-a';
    }

    return $text;
  }
*/

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
    file_put_contents( $_SERVER['DOCUMENT_ROOT'] . "\\errorLog.txt" , $data, FILE_APPEND );
  }


?>	


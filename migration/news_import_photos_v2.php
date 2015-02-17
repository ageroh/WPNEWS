
<?php
  /**
    My special import script for NEWS.GR
   */


error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('MAX_EXECUTION_TIME', -1);
ini_set('default_socket_timeout', -1);


$servername = "localhost";
$username = "admin";
$password = "123!@#456$%^";


$conn=mysqli_connect("localhost",$username, $password, "ContentDB_161");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  writeLog(mysqli_connect_error());
  return;
}

$limit = 50;
writeLog("Try get all results from DB for PHOTOS-ARTICLES. Limit set to " . $limit);


echo "<br/> Connection successfully to MySQL.";
writeLog("Connection successfully to MySQL");

$results = mysqli_query($conn, "
                       SELECT DISTINCT
                          e.ententityid as ID
                        , e.entPublished
                        , e.entPreview as '_thumbnail_id'
                      FROM   contentdb_161.entity e
                      INNER join
                        ( SELECT  ententityid,
                            @curRow := @curRow + 1 AS row_number
                        FROM    contentdb_161.entity l
                        JOIN    (SELECT @curRow := 0) r
                          WHERE  entstatusid = 3 AND entEntityTypeID IN ( 1 ) 
                        ORDER BY entPublished DESC
                        LIMIT " . $limit . " ) cut
                        ON cut.ententityid = e.ententityid
                      INNER JOIN contentdb_161.category_entity catEntCon
                        ON catEntCon.caeentityid = e.ententityid 
                      INNER JOIN contentdb_161.category cat 
                        ON cat.catCategoryID = catEntCon.caeCategoryID
                      order by cut.row_number asc; ");
echo "<br/> Try get results..";
if (!$results) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}


$i = 0;

while ($row = mysqli_fetch_array($results, MYSQL_ASSOC)) 
{
  $Post_Thumb = array();
  $Post_Thumb["id"] =  $row['ID'];
  $Post_Thumb["_thumbnail_id"] = $row['_thumbnail_id']; 
  $Post_Thumb["thumb_2"] = substr($row['_thumbnail_id'], 0, 2); 
  $Post_Thumb['thumb_date_path'] = date('Y/m',strtotime($row['entPublished']));
  $Post_Thumbs[$row['ID']] = $Post_Thumb;   

  $i++;
}

mysqli_free_result($results);
mysqli_close ($conn);

require('./wp-load.php');
echo "<br/> Finished reading image url from old Db...";

$j = 0;
$args = array(
    'posts_per_page' => -1,  // Get all posts
    'post_type' => 'post',
    'order' => 'DESC',
    'orderby' => 'ID'
  );

$allPosts = get_posts( $args );
writeLog("All posts read.\n");


// upload only images for Articles that already exists.
foreach ( $allPosts as $post ) 
{
    //the_title(); 
    echo "<br/>Reading Post:" . $post->ID;

    $item = $Post_Thumbs[$post->ID];

    if($item == null)
    {
      writeLog('Not found yet: '. $post->ID . '\n');
      continue;
    }


    $upload_dir = wp_upload_dir();
    $file = $upload_dir['basedir'] ."/". $item["thumb_date_path"] . "/" . $filename;
    $filename =  $item["_thumbnail_id"] . ".jpg";

    // check if image already exists on Server 
    /*if( file_exists( $file ) ) 
    {
      // No Need to get and upload the filename, just attach it to post.
      if( $allAttachments != null)
      {
        foreach ($allAttachments as $atmnt) 
        {
          if( $atmnt['file'] == $file && $atmnt["attach_id"] ==  $attach_id )          
          {  
             // found
             set_post_thumbnail( $post->ID, $attach_id ); 
             echo "<br/> Attachment already exists: " . $attach_id . " set to post : " . $post->ID;
             writeLog("OK: Attachment already exists: " . $attach_id . " set to post : " . $post->ID ."\n");
             break;
          }
        }
      }

    }  
    else
    {
*/
     
      $image_url = $_SERVER['DOCUMENT_ROOT'] . "\\tempNewsMig.jpg";
      $url = 'http://air.news.gr/cov/' .$item["thumb_2"] . '/' . $item["_thumbnail_id"] . '_b1.jpg' ;      // fetch the greatest image from HTTP.
      
      // fix url !
      $url = htmlentities($url);

      echo "<br/>Image url: ";
      echo $url;
       writeLog("Image URL: " . $url ."\n");

      // get file from news.gr
      $dataImg = file_get_contents_curl( $url );
      if( $dataImg == null)
      {
        sleep(1); // delay a a little then try again
        $dataImg = file_get_contents_curl( $url );

        if($dataImg == null) 
        {       
          echo "<br/>ERROR: Empty filename : " . $url;
          writeLog("ERROR: Empty filename : " . $url ."\n");
          return;
        }
      }


      $ckwrite = file_put_contents($image_url, $dataImg, LOCK_EX);
      if($ckwrite==false)
      {
        writeLog("ERROR: Writing to temp file : " . $image_url );
        return;
      }

      echo "<br/> Get:  " . $url;
      writeLog("Get : " . $url ."\n");

      $upload_dir = wp_upload_dir();
      $image_data = file_get_contents($image_url);

      if( wp_mkdir_p( $upload_dir['basedir'] ."/". $item["thumb_date_path"] . "/") )
        $file = $upload_dir['basedir'] ."/". $item["thumb_date_path"] . "/" . $filename;
      
      print_r("<br/> Actual file to upload : " . $file);
      writeLog(" Actual file to upload : " . $file ."\n");
      $ckwrite = file_put_contents($file, $image_data, LOCK_EX);
      if($ckwrite==false)
      {
        writeLog("ERROR: Writing to PROD file : " . $file );
        return;
      }


      $wp_filetype = wp_check_filetype($filename, null );
      $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title' => sanitize_file_name($filename),
          'post_content' => '',
          'post_status' => 'inherit'
      );

      $attach_id = wp_insert_attachment( $attachment, $file, $post->ID );
      
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
      wp_update_attachment_metadata( $attach_id, $attach_data );
      set_post_thumbnail( $post->ID, $attach_id );
      writeLog("Attached ".$attach_id." to post : " . $post->ID ."\n");

      //$exists = false;
      // check if attach_id is already inserted to table.
      /*
      foreach ($allAttachments as $atmnt) {
        if($atmnt["attach_id"] ==  $attach_id  && $atmnt["file"] == $file)
        {
          $exists = true;
          break;
        }

      }

      if( ! $exists )
      {
        // keep in a table the post, media attachement's id, 
        $att = array();
        $att["post_id"] = $post->ID;
        $att["file"] = $file;
        $att["attach_id"] = $attach_id;
        $allAttachments[$j] = $att;
        $j++;
      }
      */

    //}
    wp_reset_postdata();
    
    echo "<br/> Image attached ok.";
} 

//foreach ($allAttachments as $am) {
//  echo "<br/> attach_id:" . $am['attach_id'] . " post_id:" . $am['post_id'] . " file:" . $am['file'];

}
echo "<br/> Finished uploading all Images for Articles.";
writeLog("Finished uploading all Images for Articles.\n");


function file_get_contents_curl($url) {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
      curl_setopt($ch, CURLOPT_URL, $url);
      
      curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in sconds
      
      //curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

      if( ($data = curl_exec($ch) ) === false)
      {
          echo '<br/> Curl error: ' . curl_error($ch);
          writeLog("Error: " . curl_error($ch) ."\n");
          curl_close($ch);
          return null;
      }
      else
      {
          echo '<br/> Operation completed without any errors';
          curl_close($ch);
          return $data;
      }

}

function writeLog($data)
{
  file_put_contents( $_SERVER['DOCUMENT_ROOT'] . "\\errorLog.txt" ,  date("Y-m-d H:i:s"). " -> " . $data, FILE_APPEND );
}

?>


<?php
  /**
    My special import script for NEWS.GR
   */

ob_implicit_flush(1);

error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('max_execution_time', 18000); // 5 hours! :) 


$servername = "localhost";
$username = "admin";
$password = "123!@#456$%^";


$conn=mysqli_connect("localhost",$username, $password, "ContentDB_161");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  return;
}


echo "<br/> Connection successfully to MySQL.";

$results = mysqli_query($conn, "
                        SELECT 
                              ententityid as ID
                            , entPublished
                            , entPreview as '_thumbnail_id'
                        FROM   contentdb_161.entity 
                        INNER JOIN contentdb_161.category_entity catEntCon
                          ON catEntCon.caeentityid = ententityid 
                        INNER JOIN contentdb_161.category cat 
                          ON cat.catCategoryID = catEntCon.caeCategoryID
                        WHERE  entstatusid = 3 
                          AND entEntityTypeID IN ( 1 ) 
                        ORDER BY entPublished DESC 
                        LIMIT 1000; ");

echo "<br/> Try get results..";

$i = 0;

while ($row = mysqli_fetch_array($results, MYSQL_ASSOC)) 
{
  $post = array();

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


$args = array(
    'posts_per_page' => -1,  // Get all posts
    'post_type' => 'post',
    'order' => 'DESC',
    'orderby' => 'ID'
  );
$allPosts = get_posts( $args );

// upload only images for Articles that already exists.
foreach ( $allPosts as $post ) 
{
    //the_title(); 
    echo "<br/>Reading Post:" . $post->ID;

    $item = $Post_Thumbs[$post->ID];

    if($item == null)
      continue;

    $image_url = $_SERVER['DOCUMENT_ROOT'] . "\\tempNewsMig.jpg";
    $url = 'http://air.news.gr/cov/' .$item["thumb_2"] . '/' . $item["_thumbnail_id"] . '_b1.jpg' ;      // fetch the greatest image from HTTP.
    
    // fix url !
    $url = htmlentities($url);

    echo "<br/>Image url: ";
    echo $url;
    
    $dataImg = file_get_contents_curl( $url );
    if( $dataImg == null)
    {
      return;
    }


    file_put_contents($image_url, $dataImg, LOCK_EX);

    echo "<br/> Get:  " . $url;

    // good
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename =  $item["_thumbnail_id"] . ".jpg";

   
    if( wp_mkdir_p( $upload_dir['basedir'] ."/". $item["thumb_date_path"] . "/") )
      $file = $upload_dir['basedir'] ."/". $item["thumb_date_path"] . "/" . $filename;
    
    
    print_r("<br/> Actual file to upload : " . $file);

    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    set_post_thumbnail( $post_id, $attach_id );

    echo "<br/> Image attached ok.";
  

}
echo "<br/> Finished uploading all Images for Articles.";

wp_reset_postdata();


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

?>

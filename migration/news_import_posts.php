<?php


/**
	My special import script for NEWS.GR
 */

error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('default_socket_timeout', -1);
ini_set('MAX_EXECUTION_TIME', -1);


require('./wp-load.php');

$servername = "localhost";
$username = "admin";
$password = "123!@#456$%^";

$conn=mysqli_connect("localhost",$username, $password, "ContentDB_161");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  writeLog( mysqli_connect_error());
  return;
}


/**
INSERT POSTS !
*/
$limit = 50;
writeLog("Try get all results from DB for POSTS. Limit set to " . $limit);

echo "<br/> Connection successfully to MySQL.";
$results = mysqli_query($conn, "
                               SELECT 
                                  e.ententityid as ID
                                  , (SELECT avaValue FROM contentdb_161.ValueText WHERE (avaEntityID = e.ententityid) AND (avaLanguageID = 1) AND avaSatID = 13) as BODY
                                  , (SELECT avaValue FROM contentdb_161.ValueString WHERE (avaEntityID = e.ententityid) AND (avaLanguageID = 1) AND (avaSatID = 10)) as TITLE
                                  , (select contentdb_161.iGetEntityThirdCategoryID(e.ententityid)) as catID3
                                  , (select contentdb_161.iGetEntitySecondaryCategoryID(e.ententityid)) as catID2
                                  , (select contentdb_161.iGetEntityPrimaryCategoryID(e.ententityid)) as catID1
                                  , entURL
                                  , entPublished
                                  , entModified
                                  , entPreview as '_thumbnail_id'
                                  , catShortName
                                  , catURL
                                  , catCategoryID
                                  , catParentID
                                  , Concat(catURL, '/' , convert(catCategoryID, CHAR(10)) , '/' ) as CategoryURL
                                  , catMETADescription
                                  , catMETAKeywords
                                  , substring(substring_index(entURL,'/',-1), 1, LOCATE('.html', substring_index(entURL,'/',-1))-1) as slugFriendlyNews
                                  , wp_users.ID as UserID
                                FROM   contentdb_161.entity e
                                INNER join
                                ( SELECT  ententityid,
                                  @curRow := @curRow + 1 AS row_number
                                FROM    contentdb_161.entity l
                                JOIN    (SELECT @curRow := 0) r
                                WHERE entstatusid = 3 AND entEntityTypeID IN ( 1 ) 
                                ORDER BY entPublished DESC
                                LIMIT ". $limit . ") cut
                                  ON cut.ententityid = e.ententityid
                                INNER JOIN contentdb_161.category_entity catEntCon
                                  ON catEntCon.caeentityid = e.ententityid 
                                INNER JOIN contentdb_161.category cat 
                                  ON cat.catCategoryID = catEntCon.caeCategoryID
                                LEFT JOIN contentdb_161.Users
                                ON Users.wusUserID = entCreatedBy
                                   and  wusUserID <> 0
                                LEFT JOIN wordpressdb.wp_users
                                  ON wp_users.user_login = Users.wusLogin
                                order by cut.row_number asc;
                              ");

if (!$results) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

$i = 0;

while ($row = mysqli_fetch_array($results, MYSQL_ASSOC)) 
{
  $post = array();
  
  $allcats = array((int)$row['catID1'], (int)$row['catID2'], (int)$row['catID3']);

  $post['import_id'] = $row['ID'];
  $post['post_status'] = 'publish';
  $post['post_date'] = date('Y-m-d H:i:s',strtotime($row['entPublished']));
  $post['post_title'] = $row['TITLE'];
  $post['post_author'] =  $row['UserID'];
  
  if($row['slugFriendlyNews'] != '')
    $post['post_name'] = $row['slugFriendlyNews'];
  else
    // create a new sanitaze friendly URL
    $post['post_name'] = sanitize_title(greeklish_permalinks_sanitize_title($row['TITLE']));

  $post['post_content'] = $row['BODY'];
  $post['post_category'] = $allcats;  

  $posts[$i] = $post;
  $i++;
}
  
writeLog( "<br/>Total articles to be inserted: " . count($posts));

mysqli_free_result($results);
mysqli_close ($conn);





echo "<br/> Start inserting posts ...";
   
writeLog("Start inserting posts...");

foreach ($posts as $post) 
{

  // Insert article only if not exists.
  if( acme_post_exists( $post["import_id"] ) === false ) 
  {

    // insert post
    $wp_error = wp_insert_post( $post, true); 
    
    if( is_wp_error( $wp_error ) ) {
        echo $wp_error->get_error_message();
        writeLog($wp_error->get_error_message());
        return;
    }
    
    echo "<br/> Post created: " . $wp_error;
    writeLog(" Post created: " . $wp_error );
  }

}

echo "<br/> successfully finished uploading articles.";
writeLog(" successfully finished uploading articles");


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
  file_put_contents( $_SERVER['DOCUMENT_ROOT'] . "\\errorLog.txt" ,  date("Y-m-d H:i:s"). " -> " . $data . " \n", FILE_APPEND );
}





function greeklish_permalinks_sanitize_title($text) {


  $expressions = array(

    '/[αΑ][ιίΙΊ]/u' => 'e',

    '/[οΟΕε][ιίΙΊ]/u' => 'i',

    

      '/[αΑ][υύΥΎ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'af$1',

      '/[αΑ][υύΥΎ]/u' => 'av',

      '/[εΕ][υύΥΎ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'ef$1',

      '/[εΕ][υύΥΎ]/u' => 'ev',

    '/[οΟ][υύΥΎ]/u' => 'ou',



      '/(^|\s)[μΜ][πΠ]/u' => '$1b',

      '/[μΜ][πΠ](\s|$)/u' => 'b$1',

      '/[μΜ][πΠ]/u' => 'mp',

      '/[νΝ][τΤ]/u' => 'nt',

      '/[τΤ][σΣ]/u' => 'ts',

      '/[τΤ][ζΖ]/u' => 'tz',

    '/[γΓ][γΓ]/u' => 'ng',

      '/[γΓ][κΚ]/u' => 'gk',

      '/[ηΗ][υΥ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'if$1',

      '/[ηΗ][υΥ]/u' => 'iu',



      '/[θΘ]/u' => 'th',

      '/[χΧ]/u' => 'ch',

      '/[ψΨ]/u' => 'ps',

  

    '/[αάΑΆ]/u' => 'a',

    '/[βΒ]/u' => 'v',

    '/[γΓ]/u' => 'g',

    '/[δΔ]/u' => 'd',

    '/[εέΕΈ]/u' => 'e',

    '/[ζΖ]/u' => 'z',

    '/[ηήΗΉ]/u' => 'i',

    '/[ιίϊΙΊΪ]/u' => 'i',

    '/[κΚ]/u' => 'k',

    '/[λΛ]/u' => 'l',

    '/[μΜ]/u' => 'm',

    '/[νΝ]/u' => 'n',

    '/[ξΞ]/u' => 'x',

    '/[οόΟΌ]/u' => 'o',

    '/[πΠ]/u' => 'p',

    '/[ρΡ]/u' => 'r',

    '/[σςΣ]/u' => 's',

    '/[τΤ]/u' => 't',

    '/[υύϋΥΎΫ]/u' => 'i',

    '/[φΦ]/iu' => 'f',

    '/[ωώ]/iu' => 'o'

  );

  

  $text = preg_replace( array_keys($expressions), array_values($expressions), $text );

  return $text;

}


/*// not used
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



?>	




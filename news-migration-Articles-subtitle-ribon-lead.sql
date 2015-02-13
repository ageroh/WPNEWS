
use wordpressdb;
/*select *
from wp_postmeta
where wp_postmeta.post_id = 204917
*/


# 
#post_id		'lead'         
#post_id		'_lead'		'field_54dcdadd54351'
INSERT INTO wp_postmeta(post_id, meta_key, meta_value)
SELECT DISTINCT 
		  ententityid as ID
		, '_lead_Custom'
        , v.avaValue as LEAD
FROM   contentdb_161.entity 
INNER JOIN contentdb_161.category_entity catEntCon
  ON catEntCon.caeentityid = ententityid 
INNER JOIN contentdb_161.category cat 
  ON cat.catCategoryID = catEntCon.caeCategoryID
inner join wp_posts
	on wp_posts.ID = ententityid
inner join contentdb_161.ValueText v
	on v.avaEntityID = ententityid
		AND v.avaLanguageID = 1
        AND v.avaSatID = 12;
    
/*
INSERT INTO wp_postmeta(post_id, meta_key, meta_value)
SELECT DISTINCT
		  wp_postmeta.post_id
		, '_lead'
        , 'field_54dcdadd54351'
FROM   wp_postmeta 
inner join wp_posts
	on wp_posts.ID = wp_postmeta.post_id
where meta_key = 'lead';
*/    




# insert RIBON
#post_id		'ribon'         
#post_id		'_ribon'		'field_54dce0a284d88'    
INSERT INTO wp_postmeta(post_id, meta_key, meta_value)
SELECT DISTINCT
		  ententityid as ID
		, '_ribon_Custom'
        , v.avaValue as RIBON_ON_IMAGE
FROM   contentdb_161.entity 
INNER JOIN contentdb_161.category_entity catEntCon
  ON catEntCon.caeentityid = ententityid 
INNER JOIN contentdb_161.category cat 
  ON cat.catCategoryID = catEntCon.caeCategoryID
inner join wp_posts
	on wp_posts.ID = ententityid
inner join contentdb_161.ValueString v
	on v.avaEntityID = ententityid
		AND v.avaLanguageID = 1
        AND v.avaSatID = 254;
    
/*    
INSERT INTO wp_postmeta(post_id, meta_key, meta_value)
SELECT DISTINCT
		  wp_postmeta.post_id
		, '_ribon'
        , 'field_54dce0a284d88'
FROM   wp_postmeta 
inner join wp_posts
	on wp_posts.ID = wp_postmeta.post_id
where meta_key = 'ribon';
*/    
    
    
# insert RIBON
#post_id		'Subtitle'         
#post_id		'_Subtitle'		'field_54dcdaa354350'
INSERT INTO wp_postmeta(post_id, meta_key, meta_value)
SELECT DISTINCT
		  ententityid as ID
		, '_subtitle_Custom'
        , v.avaValue as SUBTITLE
FROM   contentdb_161.entity 
INNER JOIN contentdb_161.category_entity catEntCon
  ON catEntCon.caeentityid = ententityid 
INNER JOIN contentdb_161.category cat 
  ON cat.catCategoryID = catEntCon.caeCategoryID
inner join wp_posts
	on wp_posts.ID = ententityid
inner join contentdb_161.ValueString v
	on v.avaEntityID = ententityid
		AND v.avaLanguageID = 1
        AND v.avaSatID = 44;
    

/*    
INSERT INTO wp_postmeta(post_id, meta_key, meta_value)
SELECT DISTINCT
		  wp_postmeta.post_id
		, '_Subtitle'
        , 'field_54dcdaa354350'
FROM   wp_postmeta 
inner join wp_posts
	on wp_posts.ID = wp_postmeta.post_id
where meta_key = 'Subtitle';
*/     



   
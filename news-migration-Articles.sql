use wordpressdb;


/*
# all tags inserted 
select *
from wp_term_taxonomy
inner join wp_terms
on wp_term_taxonomy.term_id = wp_terms.term_id
where taxonomy = 'post_tag'


# all categories inserted.
select *
from wp_term_taxonomy
inner join wp_terms
on wp_term_taxonomy.term_id = wp_terms.term_id
where taxonomy = 'category'

#no need to truncate each time.
 truncate table wp_terms;   
 truncate table wp_term_taxonomy;
 
#delete images- posts- tag relations
 truncate table wp_posts;
 truncate table wp_postmeta;
 truncate table wp_term_relationships;
 truncate wp_post_relationships;
 
*/

## CATEGORY
INSERT INTO wp_terms(term_id, name, slug, term_group)
SELECT DISTINCT catCategoryID
			#, (case when catParentID = 1 or catParentID = 0 then '' else catParentID end) as catParentID
			, catShortName
			, if( LOCATE('/', catURL)>0 , SUBSTRING(catURL, LOCATE('/', catURL)+1), catURL)
			, 0
            #, catURL
			#, catMETADescription
			#, catMETAKeywords
FROM  contentdb_161.entity 
INNER JOIN contentdb_161.category_entity catEntCon
	ON catEntCon.caeentityid = ententityid 
INNER JOIN contentdb_161.category cat 
	ON cat.catCategoryID = catEntCon.caeCategoryID
WHERE  entstatusid = 3 
	AND entEntityTypeID IN ( 1 ) 
	AND catActiveFL = 1
	AND catParentID not in (2)
	AND catCategoryID not in ( 1, 86,87,109,143,144,145,146,147,152,153,154,155,156,157,158,159,160,22,142,82,4,3)
ORDER BY catParentID ASC;


# CATEGORY TAXONOMY
INSERT INTO wp_term_taxonomy(term_id, taxonomy, description, parent, count)
SELECT DISTINCT 
	  catCategoryID as term_id
    , 'category' as taxonomy
	, ifnull(catMETADescription, '')
	, (case when catParentID = 1 or catParentID = 0 then 0 else catParentID end) as catParentID
	, 0
FROM  contentdb_161.entity 
INNER JOIN contentdb_161.category_entity catEntCon
	ON catEntCon.caeentityid = ententityid 
INNER JOIN contentdb_161.category cat 
	ON cat.catCategoryID = catEntCon.caeCategoryID
WHERE  entstatusid = 3 
	AND entEntityTypeID IN ( 1 ) 
	AND catActiveFL = 1
	AND catParentID not in (2)
	AND catCategoryID not in ( 1, 86,87,109,143,144,145,146,147,152,153,154,155,156,157,158,159,160,22,142,82,4,3)
ORDER BY catParentID ASC;



# TAGS
insert into wp_terms(term_id, name, slug, term_group)
-- OLA TA SXETIKA TAGS POY EXOYN XRISIMOPOIH8EI SE ENERGA AR8RA!
select distinct
	  enrEntityID		as term_id
	, Entity.entName as name
    , substring(substring_index(Entity.entURL,'/',-1), 1, LOCATE('.html', substring_index(Entity.entURL,'/',-1))-1) as slug
    , 0
from contentdb_161.Entity_Relation
inner join contentdb_161.Entity
	on Entity.entEntityID = enrEntityID
inner join contentdb_161.Category_Entity
	on caeEntityId = enrEntityID
INNER JOIN contentdb_161.category cat 
  ON cat.catCategoryID = caeCategoryID
  AND  cat.catCategoryID not in ( 1, 86,87,109,143,144,145,146,147,152,153,154,155,156,157,158,159,160,22,142,82,4,3)
where enrRelationID = 20		-- ONLY TAGS
	and entstatusid = 3			-- Article is Active
	and enrEntityID in (
		select distinct x.tag_id 
		from
		(
		-- keep tags with over than 10 articles each.
		select 
				count(enrParentEntityID) as total
			  , enrEntityID as tag_id				
		from contentdb_161.Entity_Relation
		inner join contentdb_161.Entity
			on Entity.entEntityID = enrEntityID
		inner join contentdb_161.Category_Entity
			on caeEntityId = enrEntityID
		where enrRelationID = 20				
			and Entity.entstatusid = 3			
		group by enrEntityID
		having  count(enrParentEntityID) >= 10
		)x	
	)
order by entPublished asc;




# TAGS TAXONOMY ? 
insert ignore into wp_term_taxonomy(term_id, taxonomy, description, parent, count)
select distinct
	  enrEntityID		as term_id
    , 'post_tag' as taxonomy
	, ifnull(Entity.ent_hidden_ART_COM_LEAD_T, '')
	, caeCategoryID 		
    , 0
from contentdb_161.Entity_Relation
inner join contentdb_161.Entity
	on Entity.entEntityID = enrEntityID
inner join contentdb_161.Category_Entity
	on caeEntityId = enrEntityID
INNER JOIN contentdb_161.category cat 
  ON cat.catCategoryID = caeCategoryID
  AND  cat.catCategoryID not in ( 1, 86,87,109,143,144,145,146,147,152,153,154,155,156,157,158,159,160,22,142,82,4,3)
where enrRelationID = 20		
	and entstatusid = 3			
	and enrEntityID in (
		select distinct x.tag_id 
		from
		(
		-- keep tags with over than 10 articles each.
		select 
				count(enrParentEntityID) as total	
			  , enrEntityID as tag_id				
		from contentdb_161.Entity_Relation
		inner join contentdb_161.Entity
			on Entity.entEntityID = enrEntityID
		inner join contentdb_161.Category_Entity
			on caeEntityId = enrEntityID
		where enrRelationID = 20				
			and Entity.entstatusid = 3			
		group by enrEntityID
		having  count(enrParentEntityID) >= 10
		)x	
	)
order by entPublished asc;

/*

DROP FUNCTION IF EXISTS slugify;
DELIMITER ;;
CREATE DEFINER='root'@'localhost'
FUNCTION slugify (temp_string VARCHAR(200) CHARSET utf8)
RETURNS VARCHAR(200)
DETERMINISTIC
BEGIN
DECLARE x, y , z Int;
DECLARE new_string VARCHAR(200);
DECLARE is_allowed Bool;
DECLARE c, check_char VARCHAR(1);
 
SET temp_string = LOWER(temp_string);
 
SET temp_string = REPLACE(temp_string, '&', ' ve ');
 
# fix Turkish chars
SET temp_string = REPLACE(temp_string, 'ı', 'i');
SET temp_string = REPLACE(temp_string, 'İ', 'i');
SET temp_string = REPLACE(temp_string, 'ç', 'c');
SET temp_string = REPLACE(temp_string, 'Ç', 'c');
SET temp_string = REPLACE(temp_string, 'ğ', 'g');
SET temp_string = REPLACE(temp_string, 'Ğ', 'g');
SET temp_string = REPLACE(temp_string, 'ş', 's');
SET temp_string = REPLACE(temp_string, 'Ş', 's');
SET temp_string = REPLACE(temp_string, 'ö', 'o');
SET temp_string = REPLACE(temp_string, 'Ö', 'o');
SET temp_string = REPLACE(temp_string, 'ü', 'u');
SET temp_string = REPLACE(temp_string, 'Ü', 'u');
 
SELECT temp_string Regexp('[^a-z0-9-]+') INTO x;
IF x = 1 THEN
SET z = 1;
WHILE z <= CHAR_LENGTH(temp_string) DO
SET c = SUBSTRING(temp_string, z, 1);
SET is_allowed = FALSE;
IF !((ASCII(c) = 45) OR (ASCII(c) >= 48 AND ASCII(c) <= 57) OR (ASCII(c) >= 97 AND ASCII(c) <= 122)) THEN
SET temp_string = REPLACE(temp_string, c, '-');
END IF;
SET z = z + 1;
END WHILE;
END IF;
 
SELECT temp_string Regexp("^-|-$|'") INTO x;
IF x = 1 THEN
SET temp_string = REPLACE(temp_string, "'", '');
SET z = CHAR_LENGTH(temp_string);
SET y = CHAR_LENGTH(temp_string);
Dash_check: WHILE z > 1 DO
IF STRCMP(SUBSTRING(temp_string, -1, 1), '-') = 0 THEN
SET temp_string = SUBSTRING(temp_string,1, y-1);
SET y = y - 1;
Else
LEAVE Dash_check;
END IF;
SET z = z - 1;
END WHILE;
END IF;
 
REPEAT
SELECT temp_string Regexp("--") INTO x;
IF x = 1 THEN
SET temp_string = REPLACE(temp_string, "--", "-");
END IF;
UNTIL x <> 1 END REPEAT;
 
IF LOCATE('-', temp_string) = 1 THEN
SET temp_string = SUBSTRING(temp_string, 2);
END IF;
 
Return temp_string;
END;;
DELIMITER ;







DROP FUNCTION IF EXISTS contentdb_161.iGetEntitySecondaryCategoryID;
DELIMITER ;;
CREATE DEFINER='root'@'localhost'
FUNCTION contentdb_161.iGetEntitySecondaryCategoryID (iEntityID BIGINT)
RETURNS INT
DETERMINISTIC
BEGIN
DECLARE iRetVal Int;
	SET	iRetVal = 0;
	SET iRetVal = (SELECT caeCategoryID FROM Category_Entity WHERE caeEntityID= iEntityID AND caeCategoryID != iGetEntityPrimaryCategoryID(iEntityID) order by caeRank limit 1);
	
Return iRetVal;
END;;
DELIMITER ;



DROP FUNCTION IF EXISTS contentdb_161.iGetEntityPrimaryCategoryID;
DELIMITER ;;
CREATE DEFINER='root'@'localhost'
FUNCTION contentdb_161.iGetEntityPrimaryCategoryID (iEntityID BIGINT)
RETURNS INT
DETERMINISTIC
BEGIN

	DECLARE sVal Int;
    SET	sVal = 0;
	SET sVal = (SELECT caeCategoryID FROM Category_Entity WHERE caeEntityID = iEntityID order by caeRank limit 1);
	Return 	sVal;
END;;
DELIMITER ;



DROP FUNCTION IF EXISTS contentdb_161.iGetEntityThirdCategoryID;
DELIMITER ;;
CREATE DEFINER='root'@'localhost'
FUNCTION contentdb_161.iGetEntityThirdCategoryID (iEntityID BIGINT)
RETURNS INT
DETERMINISTIC
BEGIN


	DECLARE iRetVal int;
    DECLARE catId1 int;
    DECLARE catId2 int;

	SET	iRetVal = 0;
	SET catId1 = iGetEntityPrimaryCategoryID(iEntityID) ;
	SET catId2 = iGetEntitySecondaryCategoryID(iEntityID); 
	
		
	SET iRetVal = (SELECT caeCategoryID 
					FROM Category_Entity 
					WHERE caeEntityID=iEntityID 
					AND caeCategoryID != catId1
					AND caeCategoryID != catId2
					order by caeRank
                    Limit 1
                    );
                    
	return	iRetVal;

END;;
DELIMITER ;

*/
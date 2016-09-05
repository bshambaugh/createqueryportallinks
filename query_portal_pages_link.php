<?php
//Find the values of the entity_type field and the nodes that they correspond to
// This is like b and nbid..
/* Please Create a Content Type (bundle) containing a fields for the assigned names of
 * the text_field_name and term_reference_field_name variables.
 * If you create a new Content Type containing fields for the assigned names
 * and wish to migrate content to these fields from a content Type
 * containing only a text_field_name name please create a Node Convert Template.
 * This node convert template should map the field name assigned to text_field_name from
 * the source to target content type.
 * If you choose to work with a new content type, please go to Home>Administration>Content in your
 * Drupal 7 Installation after you have created  your Node Convert Template and select
 * your template name in the Update Options along with any checkboxes for the nodes
 * you wish to target for your new content type before running this script.
 */
// Access control to the database
$user = '';
$pass = '';
// Specifiy the node table
$pn = 'pan_node';
// Specify the url alias table
$urlalias = 'pan_url_alias';
// specify the machine name for the link field
$linkfieldmachinename = 'field_query_portal_pages';
// create the table name for the link field
$linkfieldmachinename_table = 'pan_'.'field_data_'.$linkfieldmachinename;
$linkfieldmachinename_revisiontable = 'pan_'.'field_revision_'.$linkfieldmachinename;
// The stuff below (the next two variables) needs to be consistent with what the portal page script  	c2-multiimplodewkey.php found
// among other places https://github.com/bshambaugh/movedrupalpagestomarmottaldp
// Specify a portal page LDP container
$LDPCPortal = 'contentandportalpages';
//Specify the container Marmotta is posting to
$LDPpostcontainer = 'http://investors.ddns.net:8080/marmotta/ldp/';
// Specify the LodLive Path (this assumes a default LDP container for portal pages)
$lodlivepath = 'http://data.thespaceplan.com/LodLive2/app_en.html?'.$LDPpostcontainer.$LDPCPortal.'/';
// The content types of the nodes that you wish to convert. Please change to match your needs.
 $bundle_type = array('semantic_portal_page');
// Set dbg to the integer 1 to allow for debugging
$dbg = 1;
// change dbname to your database name for all instances in the code
// Enter nid array, type, and vid
$nid_array = array();
$vid_array = array();
$type_array = array();
$alias_array = array();
///
$field_query_portal_pages_url_col = $linkfieldmachinename.'_url';
$field_query_portal_pages_title_col = $linkfieldmachinename.'_title';
$field_query_portal_pages_attributes_col = $linkfieldmachinename.'_attributes';
// ...
echo "hello";
$nodename = array();
$nodeid = array();
/// dbname=drupal-7.42
foreach($bundle_type as $k => $type) {
  try {
      $dbh = new PDO('mysql:host=localhost;dbname=spacefin_isa2', $user, $pass);
        foreach($dbh->query("SELECT `$pn`.`nid`, `$pn`.`type`, `$pn`.`vid` from `$pn`
  WHERE `$pn`.`type` LIKE 'semantic_portal_page'") as $row) {
  //    foreach($dbh->query('SELECT * from `pan_node` LIMIT 10') as $row) {
//          print_r($row);
          if($row['nid'] !== NULL) {
          echo($row['nid']);
          array_push($nid_array, $row['nid']);
          }
          if($row['type'] !== NULL) {
          echo($row['type']);
          array_push($type_array, $row['type']);
          }
          if($row['vid'] !== NULL) {
          echo($row['vid']);
          array_push($vid_array, $row['vid']);
          }
      }
      $dbh = null;
  } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
  }


$nid_source_array = array();
$link_title_array = array();

foreach($nid_array as $key => $value) {
    echo 'The nid array is: '.$nid_array[$key]."\r\n";
    echo 'The vid array is: ',$vid_array[$key]."\r\n";
    echo 'The type array is: ',$type_array[$key]."\r\n";
    $source_from_nid = 'node/'.$nid_array[$key];
    $nid_source_array[$key] = $source_from_nid;
}

}

/*
foreach($nid_array as $key => $value) {
	echo $nid_array[$key];
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=spacefin_isa2', $user, $pass);
		foreach($dbh->query("SELECT `pan_url_alias`.`source`, `pan_url_alias`.`alias` FROM `pan_url_alias` WHERE `pan_url_alias`.`source` LIKE 'node/%$nid_array[$key]%'") as $row) {
			if($row['source'] !== NULL) {
				echo($row['source']);
				array_push($source_array, $row['source']);
   	} 		
		}
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	  }


}
 */


foreach($nid_array as $key => $value) {
//	echo $nid_array[$key].' '.$type_array[$key].' '.$vid_array[$key].$field_query_portal_pages_url_col.$field_query_portal_pages_title_col.$field_query_portal_pages_attributes_col.
//		$linkfieldmachinename_table.$linkfieldmachinename_revisiontable."\n";	
	echo $type_array[$key]."\n";
	insert_lodlive_link('node',$type_array[$key],0,$nid_array[$key],$vid_array[$key],'und',0,'queryportalpage','Simple Query Portal for ISP Content','a:0:{}',$field_query_portal_pages_url_col,$field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col,$linkfieldmachinename_revisiontable,$linkfieldmachinename_table,$user,$pass);	
	//echo 'node'.$type_array[$key].'0'.$nid_array[$key].$vid_array[$key].'und'.'0'.'queryportalpages'.'Simple Query Portal for ISP Content'.'a:0:{}'.                                $field_query_portal_pages_url_col.$field_query_portal_pages_title_col.$field_query_portal_pages_attributes_col.$linkfieldmachinename_revisiontable.$linkfieldmachinename_table.$user.$pass;		
//insert_lodlive_link('node',$type_array[$key],0,$nid_array[$key],$vid_array[$key],'und',0,'queryportalpages','Simple Query Portal for ISP Content','a:0:{}',$field_query_portal_pages_url_col,$field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col,$linkfieldmachinename_revisiontable,$linkfieldmachinename_table,$user,$pass)	
	//insert_lodlive_link('node',$type_array[$key],0,$nid_array[$key],$vid_array[$key],'und',0,'queryportalpages','Simple Query Portal for ISP Content','a:0:{}', $field_query_portal_pages_url_col, $field_query_portal_pages_title_col, $field_query_portal_pages_attributes_col, $linkfieldmachinename_revisiontable, $linkfieldmachinename_table, $user, $pass)
}

function test($entity_type,$bundle,$deleted,$entity_id,$revision_id,$language,$delta,$field_query_portal_pages_url,$field_query_portal_pages_title,$field_query_portal_pages_attributes,$field_query_portal_pages_url_col,$field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col,$linkfieldmachinename_revisiontable,$linkfieldmachinename_table,$user,$pass)
{
	echo $user;
	echo $pass;
	echo $linkfieldmachinename_table; 
	echo $linkfieldmachinename_revisiontable; 
	echo $field_query_portal_pages_attributes_col; 
	echo $field_query_portal_pages_title_col; 
	echo $field_query_portal_pages_url_col; 
	echo $field_query_portal_pages_attributes; 
	echo $field_query_portal_pages_title; 
	echo $field_query_portal_pages_url;  
	echo $delta; 
	echo $language; 
	echo $revision_id; 
	echo $entity_id; 
	echo $deleted;  
	echo $bundle;  
	echo $entity_type."\n";	
}

function insert_lodlive_link($entity_type,$bundle,$deleted,$entity_id,$revision_id,$language,$delta,$field_query_portal_pages_url,$field_query_portal_pages_title,$field_query_portal_pages_attributes,$field_query_portal_pages_url_col,$field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col,$linkfieldmachinename_revisiontable,$linkfieldmachinename_table,$user,$pass)
{
	echo $user;
	echo $pass;
	echo $linkfieldmachinename_table;
	echo $linkfieldmachinename_revisiontable;
	echo $field_query_portal_pages_attributes_col;
	echo $field_query_portal_pages_title_col;
	echo $field_query_portal_pages_url_col;
	echo $field_query_portal_pages_attributes;
	echo $field_query_portal_pages_title;
	echo $field_query_portal_pages_url;
	echo $delta;
	echo $language;
	echo $revision_id;
	echo $entity_id;
	echo $deleted;
	echo $bundle;
	echo $entity_type."\n";

	
	try {
		   $dbh = new PDO('mysql:host=localhost;dbname=spacefin_isa2',$user,$pass, array(PDO::ATTR_PERSISTENT => true));
			foreach($dbh->query("INSERT INTO `$linkfieldmachinename_table` (entity_type, bundle, deleted, entity_id, revision_id, language, delta, $field_query_portal_pages_url_col, $field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col) VALUES ('$entity_type', '$bundle', $deleted, $entity_id, $revision_id, '$language', $delta, '$field_query_portal_pages_url', '$field_query_portal_pages_title', '$field_query_portal_pages_attributes')") as $row) {
			}	
	//		$dbh = null;
     	} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
	   }
	 
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=spacefin_isa2',$user,$pass, array(PDO::ATTR_PERSISTENT => true));
		foreach($dbh->query("INSERT INTO `$linkfieldmachinename_revisiontable` (entity_type, bundle, deleted, entity_id, revision_id, language, delta, $field_query_portal_pages_url_col,              $field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col) VALUES ('$entity_type', '$bundle', $deleted, $entity_id, $revision_id, '$language', $delta,'$field_query_portal_pages_url', '$field_query_portal_pages_title', '$field_query_portal_pages_attributes')") as $row) {
			         }
		//    $dbh = null;
		          } catch (PDOException $e) {
		                   print "Error!: " . $e->getMessage() . "<br/>";
		                     die();
		          }
		

	}


/*
function insert_lodlive_link($entity_type, $bundle, $deleted, $entity_id, $revision_id, $language, $delta, $field_query_portal_pages_url, $field_query_portal_pages_title, $field_query_portal_pages_attributes, $field_query_portal_pages_url_col, $field_query_portal_pages_title_col, $field_query_portal_pages_attributes_col, $linkfieldmachinename_revisiontable, $linkfieldmachine_table, $user, $pass) 
//{

/*
//echo $entity_type.$bundle; //.$deleted, $entity_id, $revision_id, $language, $delta, $field_query_portal_pages_url, $field_query_portal_pages_title,                           $field_query_portal_pages_attributes, $field_query_portal_pages_url_col, $field_query_portal_pages_title_col, $field_query_portal_pages_attributes_col, $linkfieldmachinename_revisiontable,    $linkfieldmachine_table, $user, $pass

	
	try {
			$dbh = new PDO('mysql:host=localhost;dbname=spacefi_isa2', $user, $pass, array(PDO::ATTR_PERSISTENT => trueuery("INSERT INTO `$linkfieldmachinename_table` (entity_type, bundle, deleted, entity_id, revision_id, language, delta, $field_query_portal_pages_url_col, $field_query_portal_pages_title_col, $field_query_portal_pages_attributes_col) VALUES ('$entity_type', '$bundle', $deleted , $entity_id , $revision_id , '$language' , $delta , '$field_query_portal_pages_url','$field_query_portal_pages_title', '$field_query_portal_pages_attributes')") as $row) {
				      }
			 $dbh = null;
			   } catch (PDOException $e) {
			         print "Error!: " . $e->getMessage() . "<br/>";
			               die();
 }
	
try {
		 d, $revision_id, $language, $delta, $field_query_portal_pages_url, $field_query_portal_pages_title,                           -->$field_query_portal_pages_attributes, $field_query_portal_pages_url_col, $field_query_portal_pages_title_col, $field_query_portal_pages_attributes_col, $linkfieldmachinename_revisiontable,      -->$linkfieldmachine_table, $user, $pass$dbh = new PDO('mysql:host=localhost;dbname=spacefin_isa2', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
		 foreach($dbh->query("INSERT INTO `$linkfieldmachinename_revisiontable` (entity_type, bundle, deleted, entity_id, revision_id, language, delta,$field_query_portal_pages_url_col, $field_query_portal_pages_title_col,$field_query_portal_pages_attributes_col) VALUES ('$entity_type', '$bundle', $deleted , $entity_id ,$revision_id , '$language' , $delta , '$field_query_portal_pages_url', '$field_query_portal_pages_title', '$field_query_portal_pages_attributes')") as $row) {
			   }
			                                                 $dbh = null;
			                                                        } catch (PDOException $e) {
			                                                         print "Error!: " . $e->getMessage() . "<br/>";
			                                                         die();
		                                                          }

 
 }
 */

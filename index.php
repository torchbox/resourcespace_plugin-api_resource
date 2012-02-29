<?php
$site_root = $_SERVER['DOCUMENT_ROOT'];
$api=true;
include "$site_root/include/db.php";
include "$site_root/include/general.php";
include "$site_root/include/search_functions.php";
include "$site_root/include/resource_functions.php";
include "$site_root/include/authenticate.php";

// required: check that this plugin is available to the user
if (!in_array("api_resource",$plugins)){die("no access");}

$resource=getval("resource","");
$meta=getval("meta","");

if ($api_resource['signed']){

  // test signature? get query string minus leading ? and skey parameter
  $test_query="";
  parse_str($_SERVER["QUERY_STRING"],$parsed);
  foreach ($parsed as $parsed_parameter=>$value){
    if ($parsed_parameter!="skey"){
      $test_query.=$parsed_parameter.'='.$value."&";
    }
  }
  $test_query=rtrim($test_query,"&");

  // get hashkey that should have been used to create a signature.
  $hashkey=md5($api_scramble_key.getval("key",""));

  // generate the signature required to match against given skey to continue
  $keytotest = md5($hashkey.$test_query);

  if ($keytotest <> getval('skey','')){
    header("HTTP/1.0 403 Forbidden.");
    echo "HTTP/1.0 403 Forbidden. Invalid Signature";
    exit;
  }
}
$resources = get_resource_files($resource);

// naive assumption that the metadump.xml is always at the end
if ($meta) {
  $filepath = end($resources);
}
else {
  $filepath = reset($resources);
}

if (!file_exists($filepath)) {
  header("Status: 404 Not Found");
  header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
  echo $_SERVER["SERVER_PROTOCOL"]." 404 Not Found. Resource Not Found";
  exit;
}
$mimetype = mime_content_type($filepath);
header("Content-Type: $mimetype");
readfile($filepath);

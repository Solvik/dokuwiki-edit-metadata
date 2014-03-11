<?php
if ('cli' != php_sapi_name()) die();

ini_set('memory_limit','128M');
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../').'/');
define('NOSESSION',1);
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/common.php');

if ($argc != 3) {
  echo 'Usage: php bin/setmetadata.php <page_id> <json_data>'. PHP_EOL;
  exit(1);
}

$page = $argv[1]; // namespace format (ie: fr:start)
$new_metadata = $argv[2]; // in json

echo 'Getting metadata for page '. $page . PHP_EOL;
$meta = p_get_metadata($page, 'relation', METADATA_DONT_RENDER);
if ($meta == NULL) {
  echo 'Metadata for this page not found, the page may not exists..'. PHP_EOL;
  exit(1);
}
var_dump($meta);

echo 'Setting metadata for page '. $page . PHP_EOL;

$new_data = json_decode($new_metadata, true);
if ($new_data == NULL) {
  echo 'Can\'t decode JSON for metadata update'. PHP_EOL;
  exit(1);
}
p_set_metadata($page, $new_data);

echo 'Getting again metadata for page '. $page . PHP_EOL;
$meta = p_get_metadata($page, 'relation', METADATA_DONT_RENDER);
var_dump($meta);

?>

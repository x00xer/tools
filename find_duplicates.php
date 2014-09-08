<?php
/**
 * In result we will see mext array
 * array(
 *     [firms.inc] => Array
 *         (
 *             [0] => ./admin/funcs
 *             [1] => ./admin/sale/lib
 *             [2] => ./lib
 *         )
 *
 *     [sales_digest.inc] => Array
 *         (
 *             [0] => ./admin/sale/lib
 *             [1] => ./admin/sale/template
 *         )
 * )
 */
error_reporting(E_ALL);
ini_set('display_errors', true);

$all_files = $duplicates = array();
$dir = '.';
readFolderContent($dir);
function readFolderContent($dir)
{
   global $all_files, $duplicates;
   foreach(scandir($dir) as $d) {
      $d = trim($d);
      if($d == '.' || $d == '..') continue;
      if(is_dir($dir .'/'. $d))
         readFolderContent($dir .'/'. $d);
      elseif(is_file($dir.'/'.$d)) {
         $file_ext = pathinfo($dir .'/'.$d, PATHINFO_EXTENSION);
         if(/*$file_ext != 'php' && */$file_ext != 'inc') continue;
         if(isset($all_files[$d])) {
            if(isset($duplicates[$d])) $duplicates[$d][] = $dir;
            else $duplicates[$d] = array($all_files[$d], $dir);
         }
         $all_files[$d] = $dir;
      }
   }
}

print_r($duplicates);
echo count($duplicates) . PHP_EOL;

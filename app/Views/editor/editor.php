<?php
//include 'editor.php';
$html = file_get_contents(APPPATH . 'Views/editor/edits.php');
//search for html files in demo and my-pages folders
$pathh = "src";
function searchHTMLFiles($dir) {
  $htmlFiles = array();

     $files = glob($dir . '/*');
     foreach ($files as $file) {
         if (is_dir($file)) {
             // Recursively search inside directories
             $htmlFiles = array_merge($htmlFiles, searchHTMLFiles($file));
         } else {
             $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
             if ($fileExt === 'html') {
                 $htmlFiles[] = $file;
             }
         }
     }

     return $htmlFiles;
}
//$htmlFiles = glob('{'.$pathh.'*\/*.html, '.$pathh.'*.html, '.$pathh.'/*}',  GLOB_BRACE);
$htmlFiles = searchHTMLFiles($pathh);

$files = '';
foreach ($htmlFiles as $file) {
   if (in_array($file, array('Asset/editor/new-page-blank-template.html', 'edits'))) continue;//skip template files
   $pathInfo = pathinfo($file);
   $filename = $pathInfo['filename'];
   $file_extension = $pathInfo['extension'];
	//folder name ???
   $folder_name = dirname($file);
   $folder = basename($folder_name);
   //$folder = preg_replace('@/.+?$@', '', $pathInfo['dirname']);
   $subfolder = preg_replace('@^.+?/@', '', $pathInfo['dirname']);
   if ($filename == 'index' && $subfolder) {
	   $filename = $subfolder;
   }

	$url = base_url()."home/page/$folder_name/$filename";
  // Parse the URL
  $parsedUrl = parse_url($url);

  // Remove the "src" segment from the path
  $pathSegments = explode('/', $parsedUrl['path']);
  $pathWithoutSrc = array_filter($pathSegments, function ($segment) {
      return strtolower($segment) !== 'src';
  });

  // Reconstruct the path
  $newPath = implode('/', $pathWithoutSrc);

  // Reconstruct the URL without the "src" segment
  $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $newPath;

  if (isset($parsedUrl['query'])) {
      $newUrl .= '?' . $parsedUrl['query'];
  }

  if (isset($parsedUrl['fragment'])) {
      $newUrl .= '#' . $parsedUrl['fragment'];
  }

    $url = $newUrl;

//	$url = base_url()."$folder_name/$filename.$file_extension";
   //$url = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
   $name = ucfirst($filename);
if($folder == "src"){
  $folder = "";
}
$file = "src/$folder/$filename.$file_extension";
  $files .= "{name:'$name', file:'$file', title:'$name',  url: '$url', folder:'$folder'},";
}
//?folder=&page=index.php
$pathh = "src/$folder_pg/";
$pa_val = "";
$htmlFiles = glob('{'.$pathh. $page.'}',  GLOB_BRACE);
foreach ($htmlFiles as $file) {
	if (in_array($file, array('Asset/editor/new-page-blank-template.html', 'edits'))) continue;//skip template files
	$pathInfo = pathinfo($file);
	$filename = $pathInfo['filename'];
	$file_extension = $pathInfo['extension'];
	//folder name ???
	$folder_name = dirname($file);
	$folder_name = basename($folder_name);
	$folder = preg_replace('@/.+?$@', '', $pathInfo['dirname']);
	$subfolder = preg_replace('@^.+?/@', '', $pathInfo['dirname']);

	// if ($filename == 'index' && $subfolder) {
	// 	$filename = $subfolder;
	// }
	//$url = base_url()."$folder_name/$filename.$file_extension";
  $url = base_url()."home/page/$folder_name/$filename";
  // Parse the URL
  $parsedUrl = parse_url($url);

  // Remove the "src" segment from the path
  $pathSegments = explode('/', $parsedUrl['path']);
  $pathWithoutSrc = array_filter($pathSegments, function ($segment) {
      return strtolower($segment) !== 'src';
  });

  // Reconstruct the path
  $newPath = implode('/', $pathWithoutSrc);

  // Reconstruct the URL without the "src" segment
  $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $newPath;

  if (isset($parsedUrl['query'])) {
      $newUrl .= '?' . $parsedUrl['query'];
  }

  if (isset($parsedUrl['fragment'])) {
      $newUrl .= '#' . $parsedUrl['fragment'];
  }

    $url = $newUrl;
	//$file = "../src/$folder_name/$filename.$file_extension";
	//$url = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
	$name = ucfirst($filename);
	$pa_val = "{name:'$name', file:'$file', title:'$name',  url: '$url', folder:'$folder_name'},";
}

//replace files list from html with the dynamic list from demo folder
$html = str_replace('(pages);', "([$files]);", $html);
$html = str_replace('(pa)', "$pa_val", $html);

echo $html;

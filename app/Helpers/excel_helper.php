<?php
require_once APPPATH. "third_party/phpexcel/vendor/autoload.php";
function excel_upload($file,$table_name,$array){
$comman_model = new \App\Models\Comman_model();

  $excel_import = $_FILE[$file]['tmp_name'];
  $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

  if(isset($_FILES[$file]['name']) && in_array($_FILES[$file]['type'], $file_mimes)) {

  $arr_file = explode('.', $_FILES[$file]['name']);
  $extension = end($arr_file);

  if('csv' == $extension) {
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
  } else {
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
  }

  $spreadsheet = $reader->load($_FILES[$file]['tmp_name']);

  $sheetData = $spreadsheet->getActiveSheet()->toArray();

  if (!empty($sheetData)) {
  for ($i=1; $i<count($sheetData); $i++) {
  $excel_id = (rand(0,99999).time()) + time();
  ${"data_" . $excel_id} = array(
'id' => $excel_id,
  );
  foreach($array as $column => $excel_column){
  $hashtags_url = '/&!/i';
  if(preg_match($hashtags_url, $excel_column, $matches)){

  $excel_column = preg_replace($hashtags_url, '', $excel_column);
  ${"var_" . $column} = $sheetData[$i][$excel_column];
  }else{
  ${"var_" . $column} = $excel_column;
  }
  }
  foreach($array as $column => $excel_column){
  ${"data_" . $excel_id}[$column] = ${"var_" . $column};
  }
  $insert_post_toDBi = $comman_model->insert_entry($table_name,${"data_" . $excel_id});

  }
  }
  }
}
?>

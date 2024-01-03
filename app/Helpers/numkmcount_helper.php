<?php
function thousandsCurrencyFormat($num) {
  $x = round($num);
         $x_number_format = number_format($x);
         $x_array = explode(',', $x_number_format);
         $x_parts = array('', 'k', 'm', 'b', 't');
         $x_count_parts = count($x_array) - 1;
         $x_display = $x_array[0];

         if (isset($x_array[1]) && (int)$x_array[1][0] !== 0) {
             $x_display .= '.' . $x_array[1][0];
         }

         $x_display .= $x_parts[$x_count_parts];

         return $x_display;
}
?>

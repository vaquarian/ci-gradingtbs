<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
header('Content-type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment; filename="'.$filename.'"'); 
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache'); 
header('Expires: 0');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ACHIEVEMENT TARGET REPORT</title>
    </head>        
    <body>
      <table border="1" style="font-size:16px;border-spacing:5px;" width="100%">
        <?php echo $tr_title; ?>
        <?php echo $tr_level_filtered; ?>
        <?php echo $tr_column_title; ?>
        <?php echo $tr_column_value; ?>
      </table>
    </body>
</html>
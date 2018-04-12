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
        <title>GRADING REPORT</title>
    </head>        
    <body>
      <table border="1" style="font-size:16px;border-spacing:5px;" width="100%">
        <?php echo $tr_level_filtered; ?>
        <?php echo $tr_title; ?>
        <?php echo $tr_section_one_title; ?>
        <?php echo $tr_parent_level; ?>
        <?php echo $tr_child_level; ?>
        <?php echo $tr_section_one_sample; ?>
        <?php echo $tr_formula; ?>
        <?php echo $tr_section_two_title; ?>
        <?php echo $tr_section_two_sample; ?>
        <?php echo $tr_section_three_title; ?>
        <?php echo $tr_section_three_sample; ?>
        <?php echo $tr_section_four_title; ?>
        <?php echo $tr_section_four_sample; ?>
        <?php echo $tr_section_five_title; ?>
        <?php echo $tr_section_five_sample; ?>
        <?php echo $tr_comment_title; ?>
        <?php echo $tr_comment; ?>
      </table>
    </body>
</html>
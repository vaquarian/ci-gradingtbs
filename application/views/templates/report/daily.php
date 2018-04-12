<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>DAILY REPORT</title>
    </head>        
    <body>
      <table border="1" class="w3-table-all notranslate" style="font-size:16px;border-collapse:separate;border-spacing:2px;" width="100%">
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
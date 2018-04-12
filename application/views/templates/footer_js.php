      <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <!-- Main Footer -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <strong>Version </strong>1.0
        </div>
        <strong>Copyright &copy; <?php echo date("Y"); ?>.</strong> All rights reserved.
      </footer>
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery/jquery.custom.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/datatables/dataTables.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/responsive/dataTables.responsive.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/responsive/responsive.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/fastclick/fastclick.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/sweetalert/sweetalert.min.js'); ?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/admin.min.js'); ?>"></script>
    <?php 
      if ( !empty($js_files) ) :
        foreach ( $js_files as $js_file ) :
    ?> 
    <script type="text/javascript" src="<?php echo $js_file; ?>"></script>
    <?php
        endforeach;
      endif;
    ?>
    <!-- Created by : V.S. -->
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Real Time Data Grading - Clear Login Session</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="<?php echo base_url('assets/css/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/font-awesome/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/ionicons/ionicons.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/responsive/responsive.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
        <?php
          if ( !empty($css_files) ) :
            foreach ( $css_files as $css_file ) :
              echo link_tag( $css_file );
            endforeach;
          endif;
        ?>
        <link href="<?php echo base_url('assets/css/admin.min.css'); ?>" rel="stylesheet" type="text/css">  
        <link href="<?php echo base_url('assets/css/skins/skin-blue.min.css'); ?>" rel="stylesheet" type="text/css">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Google Font -->
        <link href="<?php echo base_url('assets/css/fonts/font-googleapis.css'); ?>" rel="stylesheet" type="text/css">        
    </head>
    <body class="hold-transition skin-blue login-page">
        <div class="login-box">
          <div class="login-logo">
            <a href="<?php echo base_url(); ?>"><b>Real Time</b> Grading</a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <p class="login-box-msg">Clear login session</p>
            <form id="clear-form" role="form" action="#">
              <div class="form-group">
                <input id="user_name_clear" name="user_name_clear" type="text" class="form-control vs-lowercase" placeholder="user id">
                <span class="help-block"></span>
              </div>
              <div class="form-group">
                <input id="userpass_clear" name="userpass_clear" type="hidden" class="form-control">
                <span class="help-block"></span>
              </div>
              <div class="row">
                <div class="col-md-12" style="padding-top: 8px;">
                  <div class="text-right">
                    <button id="btn-clear-web" type="button" class="btn btn-primary vs-custom" style="border-radius: 5px;">Clear Web</button>
                    <button id="btn-clear-mobile" type="button" class="btn btn-primary vs-custom" style="border-radius: 5px;">Clear Mobile</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery/jquery.custom.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/sweetalert/sweetalert.min.js'); ?>"></script>
        <?php 
          if ( !empty($js_files) ) :
            foreach ( $js_files as $js_file ) :
        ?> 
        <script type="text/javascript" src="<?php echo $js_file; ?>"></script>
        <?php
            endforeach;
          endif;
        ?>
    </body>
</html>
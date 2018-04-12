<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Real Time Data Grading - <?php echo $title; ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="<?php echo base_url('assets/css/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/font-awesome/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/ionicons/ionicons.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/responsive/responsive.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
        <?php
          if ( !empty($css_files) ) :
            foreach ( $css_files as $css_file ) :
              echo link_tag( $css_file );
            endforeach;
          endif;
        ?>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href="<?php echo base_url('assets/css/admin.min.css'); ?>" rel="stylesheet" type="text/css">  
        <link href="<?php echo base_url('assets/css/skins/skin-blue.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/fonts/font-googleapis.css'); ?>" rel="stylesheet" type="text/css">  
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
              <!-- Logo -->
              <a href="<?php echo base_url(); ?>" class="logo">
                <span class="logo-mini"><img style="max-width:50px;max-height:50px;" src="<?php echo base_url('assets/img/icon-grading.png'); ?>"></span>
                <span class="logo-lg"><img style="max-width:200px;max-height:45px;" src="<?php echo base_url('assets/img/icon-grading-text.png'); ?>"></span>
              </a>
              <!-- Header Navbar -->
              <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                  <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                      <a href="javascript:void(0)" title="User">
                        <span class="hidden-xs">
                        <?php 
                        if ( $this->session->userdata('logged_in') === true ) : 
                          echo $this->session->userdata('full_name');
                        else :
                          echo 'Anonymous User';
                        endif;
                        ?>
                        </span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('logout') ?>" title="Logout"><i class="fa fa-sign-out"></i></a>
                    </li>
                  </ul>
                </div>
              </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
              <section class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                  <div class="pull-left image">
                    <a href="javascript:void(0)"><i class="fa fa-3x fa-user text-primary"></i></a>
                  </div>
                  <div class="pull-left info">
                    <p>
                    <?php 
                      if ( $this->session->userdata('logged_in') === true ) : 
                        echo $this->session->userdata('full_name');
                      else :
                        echo 'Anonymous User';
                      endif;                      
                    ?></p>
                    <!-- Status -->
                    <a href="javascript:void(0)"><i class="fa fa-circle text-success"></i> Online</a>
                  </div>
                </div>
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                  <li class="header"><center><?php echo date('d F Y H:i:s') ?></center></li>
                  <!-- Optionally, you can add icons to the links -->
                  <?php if ( !empty($allowed_menu) && in_array('User Profile', $allowed_menu) ) : ?>
                  <li class="treeview">
                    <a href="javascript:void(0)"><i class="fa fa-user"></i> <span>User Profile</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if ( !empty($allowed_menu) && in_array('User Management', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('user'); ?>"><i class="fa fa-users"></i> User Management</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Application Role', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('role'); ?>"><i class="fa fa-list-alt"></i> Application Role</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Change Password', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('change_password'); ?>"><i class="fa fa-expeditedssl"></i> Change Password</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if ( !empty($allowed_menu) && in_array('Master', $allowed_menu) ) : ?>
                  <li class="treeview">
                    <a href="javascript:void(0)"><i class="fa fa-gears"></i> <span>Master</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if ( !empty($allowed_menu) && in_array('Master Mill', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('mill'); ?>"><i class="fa fa-industry"></i> Master Mill</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Group Parent', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('group_parent'); ?>"><i class="fa fa-object-group"></i> Master Group Parent</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Group', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('group'); ?>"><i class="fa fa-object-group"></i> Master Group</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Region', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('region'); ?>"><i class="fa fa-object-group"></i> Master Region</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Estate', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('estate'); ?>"><i class="fa fa-object-group"></i> Master Estate</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Division', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('division'); ?>"><i class="fa fa-object-group"></i> Master Division</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Holiday', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('holiday'); ?>"><i class="fa fa-calendar"></i> Master Holiday</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Grading Criteria', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('criteria'); ?>"><i class="fa fa-crop"></i> Master Grading Criteria</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Master Position', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('position'); ?>"><i class="fa fa-black-tie"></i> Master Position</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if ( !empty($allowed_menu) && in_array('Monitoring', $allowed_menu) ) : ?>
                  <li class="treeview">
                    <a href="javascript:void(0)"><i class="fa fa-anchor"></i> <span>Monitoring</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if ( !empty($allowed_menu) && in_array('SPB', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('input_spb'); ?>"><i class="fa fa-barcode"></i> Input SPB</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Grading', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('grading'); ?>"><i class="fa fa-history"></i> Grading</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Grading Priority', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('grading_priority'); ?>"><i class="fa fa-balance-scale"></i> Grading Priority</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if ( !empty($allowed_menu) && in_array('Report', $allowed_menu) ) : ?>
                  <li class="treeview">
                    <a href="javascript:void(0)"><i class="fa fa-clone"></i> <span>Report</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if ( !empty($allowed_menu) && in_array('Grading Report', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('grading_report'); ?>"><i class="fa fa-bar-chart"></i> Grading Report</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Achievement Target Report', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('target_report'); ?>"><i class="fa fa-line-chart"></i> Achievement Target Report</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Daily Report', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('daily_report'); ?>"><i class="fa fa-sellsy"></i> Daily Report</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if ( !empty($allowed_menu) && in_array('Setting', $allowed_menu) ) : ?>
                  <li class="treeview">
                    <a href="javascript:void(0)"><i class="fa fa-stack-overflow"></i> <span>Setting</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if ( !empty($allowed_menu) && in_array('Grading Parameter', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('parameter'); ?>"><i class="fa fa-database"></i> Grading Parameter</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Extreme Condition and Target', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('extreme'); ?>"><i class="fa fa-flash"></i> Extreme Condition and Target</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Extreme Email Template', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('extreme_template'); ?>"><i class="fa fa-envelope-o"></i> Extreme Email Template</a></li>
                      <?php endif; ?>
                      <?php if ( !empty($allowed_menu) && in_array('Report Email Template', $allowed_menu) ) : ?>
                      <li><a href="<?php echo base_url('report_template'); ?>"><i class="fa fa-envelope-o"></i> Report Email Template</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if ( !empty($allowed_menu) && in_array('Audit Log', $allowed_menu) ) : ?>
                  <li>
                    <a href="<?php echo base_url('audit'); ?>"><i class="fa fa-save"></i> <span>Audit Log</span></a>
                  </li>
                  <?php endif; ?>
                </ul>
                <!-- /.sidebar-menu -->
              </section>
              <!-- /.sidebar -->
            </aside>
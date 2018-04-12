<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
      <small><?php echo $description; ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-home active"></i> Home</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="callout callout-info-vs">
      <h4>About application</h4>
      Real Time Data Grading Application can display data in a certain format and has the basic features needed to display data such as sort, search, filter, paging.
      Real Time Data Grading Application is designed to simplify the process and speed up grading time without requiring special knowledge of the user. 
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php echo $daily_target; ?><sup style="font-size: 20px">%</sup></h3>
            <p>Daily Target</p>
          </div>
          <div class="icon">
            <i class="fa fa-bar-chart"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php echo $monthly_target; ?><sup style="font-size: 20px">%</sup></h3>
            <p>Monthly Target</p>
          </div>
          <div class="icon">
            <i class="fa fa-bar-chart"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>
      
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
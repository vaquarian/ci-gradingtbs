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
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?php echo base_url('parameter'); ?>">Setting</a></li>
        <li class="active">Grading Parameter</li>
      </ol>
    </section>
    
    <div class="content">
      <div class="row"> <!-- Main Content -->
        <div class="col-xs-3 col-sm-3">
          <div class="box">
            <div class="box-header text-center">
              <h3 class="box-title">List of Mill</h3>  
            </div>
            <!-- /.box-header-->
            <div class="box-body">
              <ul class="list-group" id="mill-list">  
              <?php 
              if ( !empty($mill_list) ) :
                if ( is_array($mill_list) ) :
                  foreach ( $mill_list as $mill ) : ?>
                  <a href="javascript:void(0)" class="list-group-item list-group-item-action list-group-item-success" onclick="send_action('edit','<?php echo $mill->mill_code; ?>')"><?php echo $mill->mill_name; ?></a>
                  <?php 
                  endforeach;
                else : ?>
                  <a href="javascript:void(0)" class="list-group-item list-group-item-action list-group-item-success" onclick="send_action('edit','<?php echo $mill_list->mill_code; ?>')"><?php echo $mill_list->mill_name; ?></a>
              <?php
                endif;
              endif; ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-xs-9 col-sm-9">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Edit Grading Parameter</h3>  
            </div>
            <form id="parameter-form" class="form-horizontal" role="form" action="">
              <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
              <div class="box-body">
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">% Daily Sampling</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="daily_sampling_percent" name="daily_sampling_percent" placeholder="% Daily Sampling" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">% Monthly Sampling</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="monthly_sampling_percent" name="monthly_sampling_percent" placeholder="% Monthly Sampling" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Num of Grading Each Day</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="num_of_grading_each_day" name="num_of_grading_each_day" placeholder="Num of Grading Each Day" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Num of Team</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="num_of_team" name="num_of_team" placeholder="Num of Team" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Waiting List</label>
                  <div class="col-xs-8 col-md-8">
                      <input id="waiting_list" name="waiting_list" placeholder="Waiting List" class="form-control" type="text">
                      <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Work Hour</label>
                  <div class="col-xs-4 col-md-4">
                    <div class='input-group bootstrap-timepicker'>
                      <input id="start_work_hour" name="start_work_hour" placeholder="Start Hour" type='text' class="form-control timepicker" />
                      <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                  <div class="col-xs-4 col-md-4">
                    <div class='input-group bootstrap-timepicker'>
                      <input id="end_work_hour" name="end_work_hour" placeholder="End Hour" type='text' class="form-control timepicker" />
                      <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Time Interval for Next Grading</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="time_interval_for_next_grading" name="time_interval_for_next_grading" placeholder="Time Interval for Next Grading" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Break Time</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="break_time" name="break_time" placeholder="Break Time" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Max Sampling Each Day (Per Division)</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="max_sampling_each_day" name="max_sampling_each_day" placeholder="Max Sampling Each Day (Per Division)" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Num of Grading Sequence</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="num_of_grading_sequence" name="num_of_grading_sequence" placeholder="Num of Grading Sequence" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Num of Step Sequence</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="num_of_step_sequence" name="num_of_step_sequence" placeholder="Num of Step Sequence" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-xs-4 col-md-4">Limit Day to Activate Emergency Grading</label>
                  <div class="col-xs-8 col-md-8">
                    <input id="limit_day_to_activate_emergency_grading" name="limit_day_to_activate_emergency_grading" placeholder="Limit Day to Activate Emergency Grading" class="form-control" type="text">
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
              <?php if ( $edit_permission == '1' ) : ?>
              <div class="box-footer">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <div class="text-right">
                      <button type="button" class="btn btn-primary vs-custom" id="btn-save" onclick="send_action('save')">Save</button>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->        
      </div>
      <!-- /.row -->
    </div>
    <!-- /.content -->
  </div>
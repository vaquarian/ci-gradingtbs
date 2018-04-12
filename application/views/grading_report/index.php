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
        <li><a href="<?php echo base_url('grading_report'); ?>">Report</a></li>
        <li class="active">Grading Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">&nbsp;</div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="grading-report-form" class="form-horizontal" role="form" action="">              
              <div class="box-body">
                <div class="form-group">
                  <label class="control-label col-md-2" for="spb_date_rpt">Date</label>
                  <div class="col-md-3">
                    <div class='input-group date'>
                      <input id="start_spb_date_rpt" name="start_spb_date_rpt" placeholder="Start Date" type='text' class="form-control" />
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                  <div class="col-md-3">
                    <div class='input-group bootstrap-timepicker'>
                      <input id="end_spb_date_rpt" name="end_spb_date_rpt" placeholder="End Date" type='text' class="form-control" />
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2" for="mill">Mill</label>
                  <div class="col-md-6">
                    <div class="input-group">
                      <input id="mill" name="mill" placeholder="Choose Mill" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#mill-modal">
                      <span class="input-group-btn">
                        <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#mill-modal">...</button>
                      </span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2" for="level">Level</label>
                  <div class="col-md-6">
                    <div class="input-group">
                      <input id="level" name="level" placeholder="Choose Level" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#level-modal">
                      <span class="input-group-btn">
                        <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#level-modal">...</button>
                      </span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2" for="hierarchy">Hierarchy</label>
                  <div class="col-md-6">
                    <div class="input-group">
                      <input id="hierarchy" name="hierarchy" placeholder="Choose Hierarchy" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="">
                      <span class="input-group-btn">
                        <button id="btn-hierarchy" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="">...</button>
                      </span>
                    </div>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div id="hierarchy_child_group" class="form-group" style="display: none;">
                  <label class="control-label col-md-2" for="hierarchy_child">Hierarchy Child</label>
                  <div class="col-md-6">
                    <div class="well" style="max-height: 300px;overflow: auto;">
                      <ul id="list_options" class="list-group checked-list-box"></ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="text-left">
                      <button type="button" href="javascript:void(0)" title="Load" class="btn btn-primary vs-custom" id="btn-load" onclick="send_action('<?php echo $type; ?>','grading')">Load</button>
                      <button type="button" href="javascript:void(0)" title="Export to Excel" class="btn btn-warning vs-custom" id="btn-export" onclick="send_action('export','grading')">Export</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-footer -->
              <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
              <input type="hidden" aria-hidden="true" value="" id="hierarchy_code" name="hierarchy_code"/>
              <input type="hidden" aria-hidden="true" value="" id="hierarchy_desc" name="hierarchy_desc"/>
              <input type="hidden" aria-hidden="true" value="" id="hierarchy_child" name="hierarchy_child"/>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
          <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div id="grading_report_view" class="vs-report-view embed-responsive embed-responsive-16by9"></div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
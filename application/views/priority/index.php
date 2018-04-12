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
      <li><a href="<?php echo base_url('input_spb'); ?>">Monitoring</a></li>
      <li class="active">Grading Priority</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <div class="row">
              <div class="col-xs-12">
                <a class="btn btn-warning vs-custom" href="javascript:void(0)" title="Export to Excel" onclick="window.location='<?php echo site_url('priority/export/xls');?>'"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export</a>
                <a class="btn btn-default vs-custom" href="javascript:void(0)" title="Reload" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;Reload</a>
              </div>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="priority-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Estate</th>
                  <th>Division</th>
                  <th># Last Month Truck</th>
                  <th># Actual Truck</th>
                  <th># Last Month Sampling</th>
                  <th>On Days</th>
                  <th># Current Day Est Sampling</th>
                  <th># Current Day Actual Sampling</th>
                  <th>Gap</th>
                  <th>% Gap</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
      <li class="active">Grading</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <!--<div class="box-header">
            <div class="row">
              <div class="col-xs-12">
                <a class="btn btn-default vs-custom" href="javascript:void(0)" title="Reload" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;Reload</a>
              </div>
            </div>
          </div>-->
          <!-- /.box-header -->
	  <div class="form-group">
              <br/>
              <label class="control-label col-xs-1 col-md-1">Search Date</label>
              <div class="col-md-2">
                <div class='input-group date'>
                    <input id="date_start" name="date" placeholder="Start Date" type='text' class="form-control" />
<!--                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>-->
                </div>
              </div>
              <div class="col-md-2">
                <div class='input-group date'>
                    <input id="date_end" name="date" placeholder="End Date" type='text' class="form-control" />
<!--                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>-->
                </div>
              </div>
              <div class="col-md-2">
                <input class="btn btn-success" type="button" id="search_btn" value="Load" style="width: 170px"/>
              </div>
            </div>
            <br/>
          <div class="box-body">
            <table id="grading-table" class="table table-bordered table-striped table-hover table-responsive" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>SPB No</th>
                  <th>Group</th>
                  <th>Region</th>
                  <th>Estate</th>
                  <th>Division</th>
				  <th>Create Date</th>
                  <th>Time Start</th>
                  <th>Time End</th>
                  <th>Truck Plate No</th>
                  <th>Foreman</th>
                  <th>Witness</th>
                  <th>Assistant</th>
                  <th>Approved By</th>
                  <th>Approved Date</th>
                  <th>Action</th>
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
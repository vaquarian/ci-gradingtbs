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
      <li class="active">Input SPB</li>
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
                <?php if ( $add_permission == '1' ) : ?>
                  <a class="btn btn-success vs-custom" href="javascript:void(0)" title="Add SPB" onclick="send_action('add')"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add SPB</a>
                <?php endif; ?>
                <!--<a class="btn btn-default vs-custom" href="javascript:void(0)" title="Reload" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;Reload</a>-->
              </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
              <div class="form-group">
                <label class="control-label col-xs-2 col-md-2">Filter Date :</label>
                <div class="col-md-2">
                  <div class='input-group date'>
                    <input id="date_start" name="date" placeholder="Start Date" type='text' class="form-control" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div class='input-group date'>
                    <input id="date_end" name="date" placeholder="End Date" type='text' class="form-control" />
                  </div>
                </div>
                <div class="col-md-2">
                  <input id="search_btn" class="btn btn-success vs-custom" type="button" value="Load"/>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
	    <table id="spb-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>SPB No</th>
                  <th>SPB Date</th>
                  <th>Truck Plate No</th>
                  <th>Driver Name</th>
                  <th>Group</th>
                  <th>Region</th>
                  <th>Estate</th>
                  <th>Division</th>
                  <th>Is Grading</th>
                  <th>Reason</th>
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
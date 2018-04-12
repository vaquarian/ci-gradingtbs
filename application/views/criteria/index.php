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
        <li><a href="<?php echo base_url('mill'); ?>">Master</a></li>
        <li class="active">Master Grading Criteria</li>
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
                    <a class="btn btn-success vs-custom" href="javascript:void(0)" title="Add Criteria" onclick="send_action('add')"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add Criteria</a>
                  <?php endif; ?>
                  <a class="btn btn-default vs-custom" href="javascript:void(0)" title="Reload" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;Reload</a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="criteria-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Criteria Index</th>
                    <th>Criteria Code</th>
                    <th>Criteria Name</th>
                    <th>Criteria Type</th>
                    <th>Criteria Condition</th>
                    <th style="width:10%;">Action</th>
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
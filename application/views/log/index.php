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
        <li class="active">Audit Log</li>
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
                  <a class="btn btn-default vs-custom" href="javascript:void(0)" title="Reload" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;Reload</a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="log-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Log ID</th>
                    <th>Module</th>
                    <th>Action</th>
                    <th>Information</th>
                    <th>Modified By</th>
                    <th>Modified Date</th>
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
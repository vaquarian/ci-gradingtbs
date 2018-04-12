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
      <li><a href="<?php echo base_url('user'); ?>">User Profile</a></li>
      <li class="active">Change Password</li>
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
          <form id="change-form" class="form-horizontal" role="form" action="">
            <div class="box-body">
              <div class="form-group">
                <label class="control-label col-md-3" for="old_password">Old Password</label>
                <div class="col-md-9">
                  <input id="old_password" name="old_password" placeholder="Old Password" class="form-control" type="password">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3" for="new_password">New Password</label>
                <div class="col-md-9">
                  <input id="new_password" name="new_password" placeholder="New Password" class="form-control" type="password">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3" for="confirm_password">Confirm New Password</label>
                <div class="col-md-9">
                  <input id="confirm_password" name="confirm_password" placeholder="Confirm New Password" class="form-control" type="password">
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-xs-12">
                  <div class="text-right">
                    <button type="button" class="btn btn-primary vs-custom" id="btn-update" onclick="send_action('update')">Update</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-footer -->
          </form>
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
<!-- Bootstrap modal -->
<div id="force-password-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="force-password-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="force-password-modal-label">Change Password</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="force-password-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="id_force" name="id_force"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="user_name_force">User ID</label>
              <div class="col-md-9">
                <input id="user_name_force" name="user_name_force" placeholder="User ID" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="full_name_force">Full Name</label>
              <div class="col-md-9">
                <input id="full_name_force" name="full_name_force" placeholder="Full Name" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
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
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" id="btn-update-password" onclick="send_action('save')" class="btn btn-primary vs-custom">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
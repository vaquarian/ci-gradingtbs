<!-- Bootstrap modal -->
<div id="approval-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="approval-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="approval-modal-label">User Verification</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="approval-form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="user_id">User ID</label>
              <div class="col-md-9">
                <input id="user_name" name="user_name" placeholder="User ID" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="password">Password</label>
              <div class="col-md-9">
                <input id="password" name="password" placeholder="Password" class="form-control" type="password">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <input id="userpass" name="userpass" type="hidden" class="form-control">
              <span class="help-block"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" id="btn-verify-user" onclick="send_action('verify_user')" class="btn btn-primary vs-custom">Verify</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
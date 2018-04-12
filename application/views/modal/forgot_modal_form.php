<!-- Bootstrap modal -->
<div id="forgot-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="forgot-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="forgot-modal-label">Forgot Password</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="forgot-form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="user_id_forgot">User ID</label>
              <div class="col-md-9">
                <input id="user_name_forgot" name="user_name_forgot" placeholder="User ID" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" id="btn-send-email" onclick="send_action('send_email')" class="btn btn-primary vs-custom">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
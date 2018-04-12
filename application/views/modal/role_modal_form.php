<!-- Bootstrap modal -->
<div id="role-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="role-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="role-modal-label">Add / Edit Role</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="role-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="role_id" name="role_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="role_name">Role Name</label>
              <div class="col-md-9">
                <input id="role_name" name="role_name" placeholder="Role Name" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="description">Description</label>
              <div class="col-md-9">
                <textarea id="description" name="description" placeholder="Description" class="form-control vs-uppercase" rows="4"></textarea>
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-save" onclick="send_action('save')" class="btn btn-primary vs-custom">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
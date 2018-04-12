<!-- Bootstrap modal -->
<div id="group-parent-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="group-parent-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="group-parent-modal-label">Add / Edit Group Parent</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="group-parent-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="group_parent_code" name="group_parent_code"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="group_parent_name">Group Parent Name</label>
              <div class="col-md-9">
                <input id="group_parent_name" name="group_parent_name" placeholder="Group Parent Name" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="description">Description</label>
              <div class="col-md-9">
                <textarea id="description" name="description" placeholder="Description" class="form-control vs-uppercase" rows="3"></textarea>
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary vs-custom" id="btn-save" onclick="send_action('save')">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
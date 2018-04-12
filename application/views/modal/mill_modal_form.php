<!-- Bootstrap modal -->
<div id="mill-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mill-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="mill-modal-label">Add / Edit Mill</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="mill-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="mill_name">Mill Name</label>
              <div class="col-md-9">
                <input id="mill_name" name="mill_name" placeholder="Mill Name" class="form-control vs-uppercase" type="text">
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
          <button type="button" id="btn-save" onclick="send_action('save')" class="btn btn-primary vs-custom">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
<!-- Bootstrap modal -->
<div id="grading-detail-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="grading-detail-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="grading-detail-modal-label">Edit Grading</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="grading-detail-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="spb_num_master" name="spb_num_master"/>
          <input type="hidden" aria-hidden="true" value="" id="criteria_code" name="criteria_code"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="criteria">Criteria</label>
              <div class="col-md-9">
                <input id="criteria" name="criteria" placeholder="Criteria" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="value">Qty</label>
              <div class="col-md-9">
                <input id="value" name="value" placeholder="Value" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-save" onclick="send_action('save_detail')" class="btn btn-primary vs-custom">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
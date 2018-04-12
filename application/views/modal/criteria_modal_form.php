<!-- Bootstrap modal -->
<div id="criteria-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="criteria-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="criteria-modal-label">Add / Edit Grading Criteria</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="criteria-form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="index_num">Criteria Index</label>
              <div class="col-md-9">
                <input id="index_num" name="index_num" placeholder="Criteria Index" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>  
            <div class="form-group">
              <label class="control-label col-md-3" for="criteria_code">Criteria Code</label>
              <div class="col-md-9">
                <input id="criteria_code" name="criteria_code" placeholder="Criteria Code" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="criteria_name">Criteria Name</label>
              <div class="col-md-9">
                <input id="criteria_name" name="criteria_name" placeholder="Criteria Name" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="type">Criteria Type</label>
              <div class="col-md-9">
                <div class="selectContainer">
                  <select id="type" name="type" class="form-control">
                    <option value=""></option>
                    <option value="EXTERNAL">EXTERNAL</option>
                    <option value="INTERNAL">INTERNAL</option>
                  </select>
                </div>
                <span class="help-block"></span>  
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="type">Criteria Condition</label>
              <div class="col-md-9">
                <div class="selectContainer">
                  <select id="state" name="state" class="form-control">
                    <option value=""></option>
                    <option value="ABNORMAL">ABNORMAL</option>
                    <option value="DIGIGIT TIKUS">DIGIGIT TIKUS</option>
                    <option value="NORMAL">NORMAL</option>
                    <option value="SAMPAH">SAMPAH</option>
                  </select>
                </div>
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
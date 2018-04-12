<!-- Bootstrap modal -->
<div id="extreme-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="extreme-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="extreme-modal-label">Edit Extreme Condition</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="extreme-form" class="form-horizontal">
          <div class="form-body">
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
              <label class="control-label col-md-3" for="prefix">Prefix</label>
              <div class="col-md-9">
                <div class="selectContainer">
                  <select id="prefix" name="prefix" class="form-control">
                    <option value=""></option>
                    <option value="MAX">MAX</option>
                    <option value="MIN">MIN</option>
                  </select>
                </div>
                <span class="help-block"></span>  
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="target">Target</label>
              <div class="col-md-9">
                <input id="target" name="target" placeholder="Target" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="type">Is Extreme</label>
              <div class="col-md-9">
                <div class="input-group checkbox">
                  <label>
                    <input id="is_extreme" name="is_extreme" type="checkbox">
                    <i class="fa fa-3x icon-checkbox"></i>                  
                  </label>
                </div>
                <span class="help-block"></span>  
              </div>
            </div>            
            <div id="extreme_value_group" class="form-group">
              <label class="control-label col-md-3" for="extreme_value">Extreme Value</label>
              <div class="col-md-9">
                <input id="extreme_value" name="extreme_value" placeholder="Extreme Value" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" id="btn-cancel" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-save" onclick="send_action('save')" class="btn btn-primary vs-custom">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
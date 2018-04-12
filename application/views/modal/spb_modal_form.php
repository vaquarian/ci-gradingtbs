<!-- Bootstrap modal -->
<div id="spb-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="spb-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="spb-modal-label">Add SPB</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="spb-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="id" name="id"/>
          <input type="hidden" aria-hidden="true" value="" id="group_parent_code" name="group_parent_code"/>
          <input type="hidden" aria-hidden="true" value="" id="group_code" name="group_code"/>
          <input type="hidden" aria-hidden="true" value="" id="region_code" name="region_code"/>
          <input type="hidden" aria-hidden="true" value="" id="estate_code" name="estate_code"/>
          <input type="hidden" aria-hidden="true" value="" id="division_code" name="division_code"/>
          <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
          <input type="hidden" aria-hidden="true" value="" id="spb_num_scan" name="spb_num_scan"/>
          <input type="hidden" aria-hidden="true" value="" id="local_time" name="local_time"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="spb_num">SPB No</label>
              <div class="col-md-9">
                <input id="spb_num" name="spb_num" placeholder="SPB No" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="spb_date">SPB Date</label>
              <div class="col-md-9">
                <input id="spb_date" name="spb_date" placeholder="SPB Date" class="form-control" type="text" aria-readonly=”true” readonly>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="group">Group</label>
              <div class="col-md-9">
                <input id="group" name="group" placeholder="Group" class="form-control" type="text" aria-readonly=”true” readonly>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="region">Region</label>
              <div class="col-md-9">
                <input id="region" name="region" placeholder="Region" class="form-control" type="text" aria-readonly=”true” readonly>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="estate">Estate</label>
              <div class="col-md-9">
                <input id="estate" name="estate" placeholder="Estate" class="form-control" type="text" aria-readonly=”true” readonly>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="division">Division</label>
              <div class="col-md-9">
                <input id="division" name="division" placeholder="Division" class="form-control" type="text" aria-readonly=”true” readonly>
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn_save" onclick="send_action('save')" class="btn btn-primary vs-custom">Save</button>
          <button type="button" id="btn_manual" class="btn btn-warning vs-custom">Manual</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
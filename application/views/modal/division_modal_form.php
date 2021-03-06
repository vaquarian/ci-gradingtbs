<!-- Bootstrap modal -->
<div id="division-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="division-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="division-modal-label">Add / Edit Division</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="division-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="division_code" name="division_code"/>
          <input type="hidden" aria-hidden="true" value="" id="group_parent_code" name="group_parent_code"/>
          <input type="hidden" aria-hidden="true" value="" id="group_code" name="group_code"/>
          <input type="hidden" aria-hidden="true" value="" id="region_code" name="region_code"/>
          <input type="hidden" aria-hidden="true" value="" id="estate_code" name="estate_code"/>
          <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="division_name">Division Name</label>
              <div class="col-md-9">
                <input id="division_name" name="division_name" placeholder="Division Name" class="form-control vs-uppercase" type="text">
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
            <div class="form-group">
              <label class="control-label col-md-3" for="group_parent">Group Parent</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="group_parent" name="group_parent" placeholder="Choose Group Parent" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#group-parent-modal">
                  <span class="input-group-btn">
                    <button id="btn-group-parent" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#group-parent-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="group">Group</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="group" name="group" placeholder="Choose Group" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#group-modal">
                  <span class="input-group-btn">
                    <button id="btn-group" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#group-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="region">Region</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="region" name="region" placeholder="Choose Region" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#region-modal">
                  <span class="input-group-btn">
                    <button id="btn-group" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#region-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="estate">Estate</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="estate" name="estate" placeholder="Choose Estate" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#estate-modal">
                  <span class="input-group-btn">
                    <button id="btn-group" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#estate-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="mill">Mill</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="mill" name="mill" placeholder="Choose Mill" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#mill-modal">
                  <span class="input-group-btn">
                    <button id="btn-group" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#mill-modal">...</button>
                  </span>
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
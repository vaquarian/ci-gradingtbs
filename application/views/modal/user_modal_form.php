<!-- Bootstrap modal -->
<div id="user-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="user-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="user-modal-label">Add / Edit User</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="user-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="id" name="id"/>
          <input type="hidden" aria-hidden="true" value="" id="position_id" name="position_id"/>
          <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
          <input type="hidden" aria-hidden="true" value="" id="hierarchy_code" name="hierarchy_code"/>
          <input type="hidden" aria-hidden="true" value="" id="role_id" name="role_id"/>
          <div class="form-body">
<!--            <div class="form-group">
              <label class="control-label col-md-3" for="user_id">User ID</label>
              <div class="col-md-9">
                <input id="user_id" name="user_id" placeholder="User ID" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>-->
            <div class="form-group">
              <label class="control-label col-md-3" for="user_name">User ID</label>
              <div class="col-md-9">
                <input id="user_name" name="user_name" placeholder="User ID" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="full_name">Full Name</label>
              <div class="col-md-9">
                <input id="full_name" name="full_name" placeholder="Full Name" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="email">Email</label>
              <div class="col-md-9">
                <input id="email" name="email" placeholder="Email" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="imei">IMEI</label>
              <div class="col-md-9">
                <input id="imei" name="imei" placeholder="IMEI" class="form-control vs-uppercase" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="position">Position Title</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="position" name="position" placeholder="Choose Position" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#position-modal">
                  <span class="input-group-btn">
                    <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#position-modal">...</button>
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
                    <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#mill-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="level">Level</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="level" name="level" placeholder="Choose Level" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#level-modal">
                  <span class="input-group-btn">
                    <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#level-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="hierarchy">Hierarchy</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="hierarchy" name="hierarchy" placeholder="Choose Hierarchy" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="">
                  <span class="input-group-btn">
                    <button id="btn-hierarchy" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="role">Role</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="role" name="role" placeholder="Choose Role" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#role-modal">
                  <span class="input-group-btn">
                    <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#role-modal">...</button>
                  </span>
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="active">Active</label>
              <div class="col-md-9">
                <div class="input-group checkbox">
                  <label>
                    <input id="active" name="active" type="checkbox">
                    <i class="fa fa-3x icon-checkbox"></i>                  
                  </label>
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
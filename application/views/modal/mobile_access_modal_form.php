<!-- Bootstrap modal -->
<div id="mobile-access-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mobile-access-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="mobile-access-modal-label">Edit Mobile Access</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="mobile-access-form" class="form-horizontal">   
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
            <!-- show table -->
            <table id="mobile-access-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No.</th>  
                  <th>Menu</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Daftar User</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_register_user" name="view_register_user" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Register Finger Print</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_register_finger_print" name="view_register_finger_print" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>                    
                <tr>
                  <td>3</td>
                  <td>Grading Mobile</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_grading_mobile" name="view_grading_mobile" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Emergency Grading</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_emergency_grading" name="view_emergency_grading" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-save" onclick="send_action('mobile_access_add')" class="btn btn-primary vs-custom">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
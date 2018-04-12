<!-- Bootstrap modal -->
<div id="web-access-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="web-access-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="web-access-modal-label">Edit Web Access</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="web-access-form" class="form-horizontal">
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
            <table id="web-access-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No.</th>  
                  <th>Menu</th>
                  <th>View</th>
                  <th>Add</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>User Management</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_user_management" name="view_user_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_user_management" name="add_user_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>    
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_user_management" name="edit_user_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_user_management" name="delete_user_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Application Role</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_role_management" name="view_role_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>                        
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_role_management" name="add_role_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>                        
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_role_management" name="edit_role_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>                        
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_role_management" name="delete_role_management" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>                 
                </tr>                    
                <tr>
                  <td>3</td>
                  <td>Change Password</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_change_password" name="view_change_password" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>                    
                <tr>
                  <td>4</td>
                  <td>Master Mill</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_mill" name="view_mst_mill" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_mill" name="add_mst_mill" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_mill" name="edit_mst_mill" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_mill" name="delete_mst_mill" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Master Group Parent</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_group_parent" name="view_mst_group_parent" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_group_parent" name="add_mst_group_parent" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_group_parent" name="edit_mst_group_parent" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_group_parent" name="delete_mst_group_parent" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Master Group</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_group" name="view_mst_group" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_group" name="add_mst_group" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_group" name="edit_mst_group" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_group" name="delete_mst_group" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>Master Region</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_region" name="view_mst_region" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_region" name="add_mst_region" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_region" name="edit_mst_region" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_region" name="delete_mst_region" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>Master Estate</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_estate" name="view_mst_estate" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_estate" name="add_mst_estate" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_estate" name="edit_mst_estate" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_estate" name="delete_mst_estate" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>Master Division</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_division" name="view_mst_division" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_division" name="add_mst_division" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_division" name="edit_mst_division" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_division" name="delete_mst_division" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>Master Holiday</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_holiday" name="view_mst_holiday" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_holiday" name="add_mst_holiday" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_holiday" name="edit_mst_holiday" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_holiday" name="delete_mst_holiday" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>11</td>
                  <td>Master Grading Criteria</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_grading_criteria" name="view_mst_grading_criteria" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_grading_criteria" name="add_mst_grading_criteria" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_grading_criteria" name="edit_mst_grading_criteria" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_grading_criteria" name="delete_mst_grading_criteria" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>12</td>
                  <td>Master Position</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_mst_position" name="view_mst_position" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_mst_position" name="add_mst_position" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_mst_position" name="edit_mst_position" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_mst_position" name="delete_mst_position" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>13</td>
                  <td>SPB</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_spb" name="view_spb" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_spb" name="add_spb" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>14</td>
                  <td>Grading</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_grading" name="view_grading" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_grading" name="edit_grading" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>15</td>
                  <td>Grading Priority</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_grading_priority" name="view_grading_priority" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>16</td>
                  <td>Grading Report</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_grading_report" name="view_grading_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>17</td>
                  <td>Achievement Target Report</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_achievement_target_report" name="view_achievement_target_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
		<tr>
                  <td>18</td>
                  <td>Daily Report</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_daily_report" name="view_daily_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>19</td>
                  <td>Grading Parameter</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_grading_parameter" name="view_grading_parameter" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_grading_parameter" name="edit_grading_parameter" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>20</td>
                  <td>Extreme Condition and Target</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_extreme_condition" name="view_extreme_condition" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_extreme_condition" name="edit_extreme_condition" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>21</td>
                  <td>Extreme Email Template</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_email_condition" name="view_email_condition" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_email_condition" name="add_email_condition" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_email_condition" name="edit_email_condition" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_email_condition" name="delete_email_condition" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>22</td>
                  <td>Report Email Template</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_email_report" name="view_email_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="add_email_report" name="add_email_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="edit_email_report" name="edit_email_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="delete_email_report" name="delete_email_report" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>23</td>
                  <td>Audit Log</td>
                  <td>
                    <div class="input-group checkbox">
                      <label>
                        <input type="checkbox" id="view_audit_log" name="view_audit_log" value="1" />
                        <i class="fa fa-2x icon-checkbox"></i>
                      </label>
                    </div>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger vs-custom" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-save" onclick="send_action('web_access_add')" class="btn btn-primary vs-custom">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Bootstrap modal -->
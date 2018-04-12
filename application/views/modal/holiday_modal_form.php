<!-- Bootstrap modal -->
<div id="holiday-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="holiday-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="holiday-modal-label">Add / Edit Holiday</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="holiday-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="holiday_id" name="holiday_id"/>
          <!--<input type="hidden" aria-hidden="true" value="" id="holiday_date_bfr" name="holiday_date_bfr"/>-->
          <input type="hidden" aria-hidden="true" value="" id="mill_code" name="mill_code"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="holiday_date">Holiday Date</label>
              <div class="col-md-9">
                <div class="input-group date">
                  <input id="holiday_date" name="holiday_date" type="text" class="form-control" />
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
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
              <label class="control-label col-md-3" for="mill">Mill Name</label>
              <div class="col-md-9">
                <div class="input-group">
<!--                  <div class="radio" style="display:none">
                    <label>
                      <input name="mill_option" type="radio" value="none" checked="">
                      <i class="fa fa-2x icon-radio"></i>
                      None
                    </label>
                  </div>  -->
                  <div class="radio">
                    <label>
                      <input id="mill_option_1" name="mill_option" type="radio" value="ALL">
                      <i class="fa fa-2x icon-radio"></i>
                      All Mill
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input id="mill_option_2" name="mill_option" type="radio" value="SPECIFIC">
                      <i class="fa fa-2x icon-radio"></i>
                      Specific Mill
                    </label>
                  </div>                   
                </div>
                <span class="help-block"></span>
              </div>
            </div>
            <div id="mill-input" class="form-group">
              <label class="control-label col-md-3" for="mill">&nbsp;</label>
              <div class="col-md-9">
                <div class="input-group">
                  <input id="mill" name="mill" placeholder="Choose Mill" class="form-control" type="text" aria-readonly=”true” readonly data-toggle="modal" data-target="#mill-modal">
                  <span class="input-group-btn">
                    <button id="btn-mill" class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#mill-modal">...</button>
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
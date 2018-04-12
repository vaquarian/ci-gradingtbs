<!-- Bootstrap modal -->
<div id="grading-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="grading-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="grading-modal-label">Edit Grading</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="grading-form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3" for="spb_num">SPB No</label>
              <div class="col-md-9">
                <input id="spb_num" name="spb_num" placeholder="SPB No" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="spb_date">SPB Date</label>
              <div class="col-md-9">
                <input id="spb_date" name="spb_date" placeholder="SPB Date" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="truck_num">Truck Plate No</label>
              <div class="col-md-9">
                <input id="truck_num" name="truck_num" placeholder="Truck Plate No" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="brondolan_on_spb">Brondolan on SPB<br/>(kg)</label>
              <div class="col-md-9">
                <input id="brondolan_on_spb" name="brondolan_on_spb" placeholder="Brondolan on SPB (kg)" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="actual_brondolan_on_pks">Actual Brondolan on PKS<br/>(kg)</label>
              <div class="col-md-9">
                <input id="actual_brondolan_on_pks" name="actual_brondolan_on_pks" placeholder="Actual Brondolan on PKS (kg)" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="num_of_janjang">Number of Janjang</label>
              <div class="col-md-9">
                <input id="num_of_janjang" name="num_of_janjang" placeholder="Number of Janjang" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="foreman">Foreman</label>
              <div class="col-md-9">
                <input id="foreman" name="foreman" placeholder="Foreman" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="witness">Witness</label>
              <div class="col-md-9">
                <input id="witness" name="witness" placeholder="Witness" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="assistant">Assistant</label>
              <div class="col-md-9">
                <input id="assistant" name="assistant" placeholder="Assistant" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="assistant">Time Start</label>
              <div class="col-md-9">
                <input id="time_start" name="time_start" placeholder="Time Start" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="assistant">Time End</label>
              <div class="col-md-9">
                <input id="time_end" name="time_end" placeholder="Time End" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="estate">Estate</label>
              <div class="col-md-9">
                <input id="estate" name="estate" placeholder="Estate" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="division">Division</label>
              <div class="col-md-9">
                <input id="division" name="division" placeholder="Division" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                <table id="grading-detail-table" class="table table-bordered table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Grading Criteria</th>
                      <th>Is Extreme</th>
                      <th>Qty</th>
                      <th>Percent (%)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
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
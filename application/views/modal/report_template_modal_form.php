<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Bootstrap modal -->
<div id="report-template-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="report-template-modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="report-template-modal-label">Add / Edit Template</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="report-template-form" class="form-horizontal">
          <input type="hidden" aria-hidden="true" value="" id="template_id" name="template_id"/>
          <input type="hidden" aria-hidden="true" value="" id="estate_code" name="estate_code"/>
          <div class="form-body">
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
              <label class="control-label col-md-3" for="email_to">Email To</label>
              <div class="col-md-9">
                <input id="email_to" name="email_to" placeholder="Email To" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="email_reply_to">Email Reply-To</label>
              <div class="col-md-9">
                <input id="email_reply_to" name="email_reply_to" placeholder="Email Reply-To" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="email_cc">Email CC</label>
              <div class="col-md-9">
                <input id="reply_to" name="email_cc" placeholder="Email CC" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="email_bcc">Email BCC</label>
              <div class="col-md-9">
                <input id="reply_to" name="email_bcc" placeholder="Email BCC" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="email_subject">Email Subject</label>
              <div class="col-md-9">
                <input id="reply_to" name="email_subject" placeholder="Email Subject" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="type">Predefined Variable</label>
              <div class="col-md-9">
                <div class="selectContainer">
                  <select id="type" name="type" class="form-control">
                      <option value=""></option>  
                      <option value="::Period">::Period</option>                      
                  </select>
                </div>
                <span class="help-block"></span>  
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3" for="email_body">Email Body</label>
              <div class="col-md-9">
                <textarea id="email_body" name="email_body" placeholder="Email Body" class="form-control" rows="5"></textarea>
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
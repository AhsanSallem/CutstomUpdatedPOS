<!-- Fix for scroll issue in new booking -->
<style type="text/css">
  .modal {
    overflow-y:auto; 
  }
</style>
<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => $notification_template['template_for'] == 'send_ledger' ? action([\App\Http\Controllers\ContactController::class, 'sendLedger']) : action([\App\Http\Controllers\NotificationController::class, 'send']), 'method' => 'post', 'id' => 'send_notification_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'lang_v1.send_notification' ) - {{$template_name}}</h4>
    </div>

    <div class="modal-body">
        <div>
            <strong>@lang('lang_v1.available_tags'):</strong> 
            @include('notification_template.partials.tags', ['tags' => $tags])
        </div>
        <div class="box-group" id="accordion">
            {{-- email --}}
            <div class="panel box box-solid">
              <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#email_collapse" aria-expanded="true">
                   @lang('lang_v1.send_email')
                  </a>
                </h4>
              </div>
              <div id="email_collapse" class="panel-collapse collapse in" aria-expanded="true">
                <div class="box-body">
                    @if($notification_template['template_for'] == 'send_ledger')
                        <div class="form-group">
                            {!! Form::label('ledger_format', __('lang_v1.ledger_format').':') !!}
                            {!! Form::select('ledger_format', ['format_1' => __('lang_v1.format_1'), 'format_2' => __('lang_v1.format_2')], $ledger_format, ['class' => 'form-control']); !!}
                        </div>
                    @endif
                    <div class="form-group @if($notification_template['template_for'] == 'send_ledger') hide @endif">
                        <label>
                          {!! Form::checkbox('notification_type[]', 'email', true, ['class' => 'input-icheck notification_type']); !!} @lang('lang_v1.send_email')
                        </label>
                    </div>
                  <div id="email_div">
                    <div class="form-group">
                      {!! Form::label('to_email', __('lang_v1.to').':') !!} @show_tooltip(__('lang_v1.notification_email_tooltip'))
                      {!! Form::text('to_email', $contact->email, ['class' => 'form-control' , 'placeholder' => __('lang_v1.to')]); !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('subject', __('lang_v1.email_subject').':') !!}
                      {!! Form::text('subject', $notification_template['subject'], ['class' => 'form-control' , 'placeholder' => __('lang_v1.email_subject')]); !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('cc', 'CC:') !!}
                      {!! Form::email('cc', $notification_template['cc'], ['class' => 'form-control' , 'placeholder' => 'CC']); !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('bcc', 'BCC:') !!}
                      {!! Form::email('bcc', $notification_template['bcc'], ['class' => 'form-control' , 'placeholder' => 'BCC']); !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('email_body', __('lang_v1.email_body').':') !!}
<<<<<<< HEAD
                      {!! Form::textarea('email_body', $notification_template['email_body'], ['class' => 'form-control', 'placeholder' => __('lang_v1.email_body'), 'rows' => 6]); !!}
=======
                      {!! Form::text('email_body', $notification_template['email_body'], ['class' => 'form-control', 'placeholder' => __('lang_v1.email_body'), 'rows' => 6]); !!}
>>>>>>> 057d6f0509a0904381860dc4403b5e03ce995bfd
                    </div>
                    @if(config('constants.enable_download_pdf') && $notification_template['template_for'] == 'new_sale')
                        <label>
                          {!! Form::checkbox('attach_pdf', true, false, ['class' => 'input-icheck notification_type']); !!}
                          @lang('lang_v1.attach_pdf_in_email')
                        </label>
                    @endif
                    @if($notification_template['template_for'] == 'send_ledger')
                      <p class="help-block">*@lang('lang_v1.ledger_attacment_help')</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            {{-- sms /whatsapp--}}
            @if($notification_template['template_for'] != 'send_ledger')
                <div class="panel box box-solid">
                  <div class="box-header with-border">
                    <h5 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#sms_collapse" class="collapsed" aria-expanded="false">
                        @lang('lang_v1.send_sms_whatsapp_notification')
                      </a>
                    </h5>
                  </div>
                  <div id="sms_collapse" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                        <div class="form-group @if($notification_template['template_for'] == 'send_ledger') hide @endif">
                            <label>
                              {!! Form::checkbox('notification_type[]', 'sms', false, ['class' => 'input-icheck notification_type']); !!} @lang('lang_v1.send_sms')
                            </label>
                            <label>
                              {!! Form::checkbox('notification_type[]', 'whatsapp', false, ['class' => 'input-icheck notification_type']); !!} @lang('lang_v1.send_whatsapp')
                            </label>
                          </div>
                            <div class="form-group">
                            {!! Form::label('mobile_number', __('lang_v1.mobile_number').':') !!}
                            {!! Form::text('mobile_number', $contact->mobile, ['class' => 'form-control', 'placeholder' => __('lang_v1.mobile_number')]); !!}
                            </div>
                          <div id="sms_div" class="hide">
                            <div class="form-group">
                              {!! Form::label('sms_body', __('lang_v1.sms_body').':') !!}
<<<<<<< HEAD
                              {!! Form::textarea('sms_body', $notification_template['sms_body'], ['class' => 'form-control', 'placeholder' => __('lang_v1.sms_body'), 'rows' => 6]); !!}
=======
                              {!! Form::text('sms_body', $notification_template['sms_body'], ['class' => 'form-control', 'placeholder' => __('lang_v1.sms_body'), 'rows' => 6]); !!}
>>>>>>> 057d6f0509a0904381860dc4403b5e03ce995bfd
                            </div>
                          </div>
                          <div id="whatsapp_div" class="hide">
                              {!! Form::label('whatsapp_text', __('lang_v1.whatsapp_text').':') !!}
<<<<<<< HEAD
                              {!! Form::textarea('whatsapp_text', $notification_template['whatsapp_text'], ['class' => 'form-control', 'placeholder' => __('lang_v1.whatsapp_text'), 'rows' => 6]); !!}
=======
                              {!! Form::text('whatsapp_text', $notification_template['whatsapp_text'], ['class' => 'form-control', 'placeholder' => __('lang_v1.whatsapp_text'), 'rows' => 6]); !!}
>>>>>>> 057d6f0509a0904381860dc4403b5e03ce995bfd
                          </div>
                    </div>
                  </div>
                </div>
            @endif
        </div>
        
        @if(!empty($transaction))
            {!! Form::hidden('transaction_id', $transaction->id); !!}
        @endif

        @if($notification_template['template_for'] == 'send_ledger')
            {!! Form::hidden('contact_id', $contact->id); !!}
            {!! Form::hidden('start_date', $start_date); !!}
            {!! Form::hidden('end_date', $end_date); !!}
            {!! Form::hidden('location_id', $location_id); !!}
        @endif
        {!! Form::hidden('template_for', $notification_template['template_for']); !!}
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="send_notification_btn">@lang('lang_v1.send')</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>
        {!! Form::close() !!}
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
// Fix for not updating textarea value on modal
  // CKEDITOR.on('instanceReady', function(){
  //    $.each( CKEDITOR.instances, function(instance) {
  //     CKEDITOR.instances[instance].on("change", function(e) {
  //         for ( instance in CKEDITOR.instances )
  //         CKEDITOR.instances[instance].updateElement();
  //     });
  //    });
  // });

  if (_.isNull(tinyMCE.activeEditor)) {
        tinymce.init({
            selector: 'textarea#email_body',
        });
    }
    
  $(document).ready(function(){
    //initialize iCheck
    $('input[type="checkbox"].input-icheck, input[type="radio"].input-icheck').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue'
    });
  });

  $(document).on('ifChanged', '.notification_type', function(){
    var notification_type = $(this).val();
    console.log(notification_type);
    if (notification_type == 'email') {
      if ($(this).is(':checked')) {
        $('div#email_div').removeClass('hide');
      } else {
        $('div#email_div').addClass('hide');
      }
    } else if(notification_type == 'sms'){
      if ($(this).is(':checked')) {
        $('div#sms_div').removeClass('hide');
      } else {
        $('div#sms_div').addClass('hide');
      }
    } else if(notification_type == 'whatsapp'){
      if ($(this).is(':checked')) {
        $('div#whatsapp_div').removeClass('hide');
      } else {
        $('div#whatsapp_div').addClass('hide');
      }
    }
  });
  $('#send_notification_form').submit(function(e){
    e.preventDefault();
    tinyMCE.triggerSave();
    var data = $(this).serialize();
    var btn = $('#send_notification_btn');
    btn.text("@lang('lang_v1.sending')...");
    btn.attr('disabled', 'disabled');
    $.ajax({
      method: "POST",
      url: $(this).attr("action"),
      dataType: "json",
      data: $(this).serialize(),
      beforeSend: function(xhr) {
          __disable_submit_button(btn);
      },
      success: function(result){
        if(result.success == true){
          if (result.whatsapp_link) {
            window.open(result.whatsapp_link);
          }
          $('div.view_modal').modal('hide');
          toastr.success(result.msg);
        } else {
          toastr.error(result.msg);
        }
        $('#send_notification_btn').text("@lang('lang_v1.send')");
        $('#send_notification_btn').removeAttr('disabled');
      }
    });
  });
</script>
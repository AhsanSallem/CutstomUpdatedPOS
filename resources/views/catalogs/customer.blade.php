<div class="modal-dialog" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action([\App\Http\Controllers\CatalogController::class, 'submitWhatsapp']), 'method' => 'post', 'id' => 'send_whatsapp_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Send Customers</h4>
    </div>

    <div class="modal-body">
      <input type="hidden" name="catalog_id" value="{{$catalog_id}}">

    <div class="form-group">
      {!! Form::label('customers', __('Customers') . ':') !!}
      <br>
      {!! Form::select('customers[]', $customers->pluck('name', 'id'), null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'customer-select']) !!}
  </div>
  
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn  btn-info send_whatsapp_button"><i class="fab fa-whatsapp"></i> WhatsApp</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
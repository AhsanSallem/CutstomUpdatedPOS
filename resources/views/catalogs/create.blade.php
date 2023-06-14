<div class="modal-dialog" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action([\App\Http\Controllers\CatalogController::class, 'store']), 'method' => 'post', 'id' => 'catalog_add_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'messages.add' )</h4>
    </div>

    <div class="modal-body">
      <input type="hidden" name="catalog_type" value="{{$catalog_type}}">
      @php
        $name_label = !empty($module_catalog_data['catalog_label']) ? $module_catalog_data['catalog_label'] : __( 'Catalog Name' );
        $cat_code_enabled = isset($module_catalog_data['enable_catalog_code']) && !$module_catalog_data['enable_catalog_code'] ? false : true;

        $cat_code_label = !empty($module_catalog_data['catalog_code_label']) ? $module_catalog_data['catalog_code_label'] : __( 'Code' );

      @endphp
      <div class="form-group">
        {!! Form::label('name', $name_label . ':*') !!}
          {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => $name_label]); !!}
      </div>
      @if($cat_code_enabled)
      <div class="form-group">
        {!! Form::label('code', $cat_code_label . ':') !!}
        {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => $cat_code_label]); !!}
      </div>
      @endif
      {{-- <div class="form-group">
        {!! Form::label('products', __('Products') . ':') !!}
        <br>
        @foreach ($products as $product)
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('products[]', $product->id, false) !!}
                    {{ $product->name }}
                </label>
            </div>
        @endforeach
    </div> --}}
    {{-- <div class="form-group">
      {!! Form::label('products', __('Products') . ':') !!}
      <br>
      {!! Form::select('products[]', $products->pluck('name', 'id'), null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'product-select']) !!}
  </div> --}}
  
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
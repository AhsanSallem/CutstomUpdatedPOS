@if(!session('business.enable_price_tax')) 
  @php
    $default = 0;
    $class = 'hide';
  @endphp
@else
  @php
    $default = null;
    $class = '';
  @endphp
@endif

<div class="table-responsive">
    <table class="table table-bordered add-product-price-table table-condensed {{$class}}">
        <tr>
          <th>@lang('product.default_purchase_price')</th>
          <th>@lang('product.profit_percent') @show_tooltip(__('tooltip.profit_percent'))</th>
          <th>@lang('product.default_selling_price')</th>
          <!-- @if(empty($quick_add))
            <th>@lang('lang_v1.product_image')</th>
          @endif -->
        </tr>
        <tr>
          <td>
            <div class="col-sm-4">
              {!! Form::label('single_dpp_inc_tax2', trans('product.exc_of_tax') . ':*') !!}

              {!! Form::text('single_dpp_inc_tax2', $default, ['class' => 'form-control input-sm dpp input_number', 'placeholder' => __('product.exc_of_tax'), 'required']); !!}
            </div>

            <div class="col-sm-4">
              {!! Form::label('list_discount', trans('product.list_discount') . ':*') !!}
            
              {!! Form::text('list_discount', $default, ['class' => 'form-control input-sm list_discount input_number', 'placeholder' => __('product.list_discount'), 'required']); !!}
            </div>


            <div class="col-sm-4">
              {!! Form::label('single_dpp', trans('product.inc_of_tax') ) !!}
            
              {!! Form::text('single_dpp', $default, ['class' => 'form-control input-sm dpp_inc_tax input_number', 'placeholder' => __('product.inc_of_tax'), 'required']); !!}
            </div>

            <!-- <div class="col-sm-4">
              {!! Form::label('single_dpp_inc_tax', trans('product.exc_of_tax') . ':*') !!}

              {!! Form::text('single_dpp_inc_tax', $default, ['class' => 'form-control input-sm dpp input_number', 'placeholder' => __('product.exc_of_tax'), 'required']); !!}
            </div> -->


           

          </td>

          <td>
            <br/>
            {!! Form::text('profit_percent', @num_format($profit_percent), ['class' => 'form-control input-sm input_number', 'id' => 'profit_percent', 'required']); !!}
          </td>

          <td>
            
              <div class="col-sm-6">
              <label><span class="dsp_label">@lang('product.unit_sell_ex')</span></label>
                    {!! Form::text('single_dsp_inc_tax', $default, ['class' => 'form-control input-sm  input_number', 'placeholder' => __('product.unit_sell_ex'), 'id' => 'single_dsp', 'required']); !!}


              </div>

              <div class="col-sm-6">
              <label><span class="dsp_label">@lang('product.unit_sell_in')</span></label>

              {!! Form::text('single_dsp', $default, ['class' => 'form-control input-sm  input_number', 'placeholder' => __('product.unit_sell_in'), 'id' => 'single_dsp_inc_tax', 'required']); !!}
        
              </div>
            </td>

          



          <!-- @if(empty($quick_add))
          <td>
              <div class="form-group">
                {!! Form::label('variation_images', __('lang_v1.product_image') . ':') !!}
                {!! Form::file('variation_images[]', ['class' => 'variation_images', 
                    'accept' => 'image/*', 'multiple']); !!}
                <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>
              </div>
          </td>
          @endif -->
        </tr>
    </table>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $(".list_discount").keyup(function(){
        // alert('da')
       var value =  $(".dpp").val();
       var dis =  $(this).val();
       var get =  (value/100) * dis ;
       var total_dis = value - get ;


       $(".dpp_inc_tax").val(total_dis);
      });
    });
  </script>
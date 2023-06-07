@php
$cat_code_enabled = isset($module_catalog_data['enable_catalog_code']) && !$module_catalog_data['enable_catalog_code'] ? false : true;
@endphp
@can('catalog.create')
	<button type="button" class="btn btn-sm pull-right btn-primary btn-modal" data-href="{{action([\App\Http\Controllers\ ::class, 'create'])}}?type={{$catalog_type}}" data-container=".category_modal">
		<i class="fa fa-plus"></i>
		@lang( 'messages.add' )
	</button>
	<br><br>
@endcan

 @can('catalog.view')
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="category_table" style="width: 100%;">
            <thead>
                <tr>
                    <th>@if(!empty($module_catalog_data['catalog_label'])) {{$module_catalog_data['catalog_label']}} @else Catalog @endif</th>
                    @if($cat_code_enabled)
                        <th>{{ $module_catalog_data['catalog_code_label'] ?? __( 'Code' )}}</th>
                    @endif
                    <th>Products</th>
                    <th>@lang( 'messages.action' )</th>
                </tr>
            </thead>
        </table>
    </div>
@endcan

<div class="modal fade catalog_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
</div>
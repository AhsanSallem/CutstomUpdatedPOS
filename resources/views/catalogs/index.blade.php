@extends('layouts.app')
@php
    $heading = !empty($module_catalog_data['heading']) ? $module_catalog_data['heading'] : __('Catalogs');
    $navbar = !empty($module_catalog_data['navbar']) ? $module_catalog_data['navbar'] : null;
@endphp
@section('title', $heading)

@section('content')
@if(!empty($navbar))
    @include($navbar)
@endif
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{$heading }}
        <small>
            {{ $module_catalog_data['sub_heading'] ?? __( 'Manage Your Catalogs' ) }}
        </small>
        @if(isset($module_catalog_data['heading_tooltip']))
            @show_tooltip($module_catalog_data['heading_tooltip'])
        @endif
    </h1>
</section>
   

<!-- Main content -->
<section class="content">
    <div id="successMessage" data-success="{{ session('success') }}"></div>
    @php
    $cat_code_enabled = isset($module_catalog_data['enable_catalog_code']) && !$module_catalog_data['enable_catalog_code'] ? false : true;
    @endphp
    <input type="hidden" id="catalog_type" value="{{request()->get('type')}}">
    @php
        $can_add = true;
        if(request()->get('type') == 'product' && !auth()->user()->can('catalog.create')) {
            $can_add = false;
        }
    @endphp
    @component('components.widget', ['class' => 'box-solid', 'can_add' => $can_add])
    @if($can_add)
    @slot('tool')
        <div class="box-tools">
            <button type="button" class="btn-pill btn btn-block btn-primary btn-modal" 
            data-href="{{action([\App\Http\Controllers\CatalogController::class, 'create'])}}?type={{request()->get('type')}}" 
            data-container=".catalog_modal">
            <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
        </div>
    @endslot
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="catalog_table">
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
@endcomponent
<div class="modal fade catalog_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

</section>
<!-- /.content -->
@stop
@section('javascript')
@includeIf('catalogs.catalog_js')
@endsection

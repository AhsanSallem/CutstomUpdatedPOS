<div class="container" style="margin-right: auto; margin-left: auto; max-width: 1140px; padding-right: 15px; padding-left: 15px;">
    <h1>Plumb Part Glasgow</h1>
    <div class="row" style="content: ''; display: table; clear: both;">
        @foreach($products as $item)
            <div class="col-md-4" style="width: 33.33%; float: left; padding-right: 15px; padding-left: 15px;">
                <div class="card mb-4" style="margin-bottom: 20px;">
                    <img src="data:image/png;base64,{{ $item['base64_image'] }}" alt="Product image" class="product-thumbnail-small" style="width: 100%; height: auto;">
                    <div class="card-body" style="padding: 20px;">
                        <h5 class="card-title" style="margin-top: 0; margin-bottom: 0.75rem;">{{ $item['name'] }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

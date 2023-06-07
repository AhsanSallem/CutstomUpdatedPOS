<script type="text/javascript">
    $(document).ready( function() {
        var successMessage = $('#successMessage').data('success');
    if (successMessage) {
        toastr.success(successMessage);
    }
        // var catalog_table;
        function getcatalogsIndexPage () {
            var data = {catalog_type : $('#catalog_type').val()};
            $.ajax({
                method: "GET",
                dataType: "html",
                url: '/catalogs-ajax-index-page',
                data: data,
                async: false,
                success: function(result){
                    $('.taxonomy_body').html(result);
                }
            });
        }

        function initializeCatalogDataTable() {
    if ($('#catalog_table').length) {
          catalog_table = $('#catalog_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/catalogs?type=' + $('#catalog_type').val(),
            columns: [
                { data: 'name', name: 'name' },
                @if($cat_code_enabled)
                { data: 'code', name: 'code' },
                @endif
                { data: 'assign_to', name: 'assign_to' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    } 
}


        @if(empty(request()->get('type')))
            getTaxonomiesIndexPage();
        @endif

        initializeCatalogDataTable();
    });
    $(document).on('submit', 'form#catalog_add_form', function(e) {
        // alert(catalog_type);
        // console.log(catalogTable);return false;
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();
        
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            beforeSend: function(xhr) {
                __disable_submit_button(form.find('button[type="submit"]'));
            },
            success: function(result) {
                if (result.success === true) {
                    $('div.catalog_modal').modal('hide');
                    toastr.success(result.msg);
                    if(typeof catalog_table !== 'undefined') {
                        catalog_table.ajax.reload();
                    }

                    var evt = new CustomEvent("categoryAdded", {detail: result.data});
                    window.dispatchEvent(evt);

                    //event can be listened as
                    //window.addEventListener("categoryAdded", function(evt) {}
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
    
    $(document).on('click', 'button.edit_catalog_button', function() {
        $('div.catalog_modal').load($(this).data('href'), function() {
            $(this).modal('show');

            $('form#catalog_edit_form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                
                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    beforeSend: function(xhr) {
                        __disable_submit_button(form.find('button[type="submit"]'));
                    },
                    success: function(result) {
                        if (result.success === true) {
                            $('div.catalog_modal').modal('hide');
                            toastr.success(result.msg);
                            catalog_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });
    $(document).on('click', 'button.send_whatsapp_button', function() {
        $('div.catalog_modal').load($(this).data('href'), function() {
            $(this).modal('show');

            $('form#send_whatsapp_form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                // console.log(data);return false;
                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    beforeSend: function(xhr) {
                        __disable_submit_button(form.find('button[type="submit"]'));
                    },
                    success: function(result) {
                        alert('yes');
                        // if (result.success === true) {
                        //     $('div.category_modal').modal('hide');
                        //     toastr.success(result.msg);
                        //     catalog_type.ajax.reload();
                        // } else {
                        //     toastr.error(result.msg);
                        // }
                    },
                });
            });
        });
    });
    $(document).on('click', 'button.download_catalog_button', function() {
            var href = $(this).data('href');
            var data = $(this).serialize();
            $.ajax({    
                method: 'GET',
                url: href,
                dataType: 'json',
                data: data,
                success: function(result) {
                    console.log(result);return false;
                    if (result.success === true) {
                        toastr.success(result.msg);
                        catalog_table.ajax.reload(); // <-- Use catalogTable instead of catalog_type
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
    });
    $(document).on('click', 'button.download_catalog_button', function() {
    var href = $(this).data('href');

    // Open the PDF in a new window
    window.open(href, '_blank');
});
    $(document).on('click', 'button.delete_catalog_button', function() {
    swal({
        title: LANG.sure,
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then(willDelete => {
        if (willDelete) {
            var href = $(this).data('href');
            var data = $(this).serialize();
            $.ajax({
                method: 'DELETE',
                url: href,
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success === true) {
                        toastr.success(result.msg);
                        // setTimeout(function() {
      catalog_table.ajax.reload();
    // }, 500);
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        }
    });
});

$(document).ready(function() {
    $('.select2').select2();
});

</script>
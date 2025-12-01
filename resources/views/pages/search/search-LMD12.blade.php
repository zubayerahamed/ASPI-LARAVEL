<div class="col-md-12 p-0">
    <div class="table-responsive">
        <table class="table table-hover table-bordered p-0 m-0 datatable-fragment {{ $tablename }}">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Product Type</th>
                    <th>Is Active?</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script type="text/javascript" th:inline="javascript">
    $(document).ready(function() {
        var fieldId = "{{ $fieldId }}";
        var suffix = "{{ $suffix }}";
        var mainscreen = {{ $mainscreen ? 'true' : 'false' }};
        var mainreloadurl = "{{ $mainreloadurl }}";
        var mainreloadid = "{{ $mainreloadid }}";
        var detailreloadurl = "{{ $detailreloadurl }}";
        var detailreloadid = "{{ $detailreloadid }}";
        var additionalreloadurl = "{{ $additionalreloadurl }}";
        var additionalreloadid = "{{ $additionalreloadid }}";
        var extrafieldcontroller = "{{ $extrafieldcontroller }}";
        var dependentParam = "{{ $dependentParam ?? '' }}";
        var resetParam = "{{ $resetParam ?? '' }}";
        var searchValue = "{{ $searchValue ?? '' }}";
        var tablename = "{{ $tablename }}";
        var fragmentcode = "{{ $fragmentcode }}";
        var orderarr = [0, 'desc'];

        var columns = [
            {
                suffix: [0],
                name: 'id',
                rendername: 'id',
                render: function(data, type, row, meta) {
                    return '<a data-prompt="' + row['name'] + '" data-value="' + data + '" style="cursor: pointer;" class="dataindex" href="#">' + row['name'] + '</a>';
                }
            }, {
                suffix: [0],
                name: 'item_group',
                rendername: 'item_group',
            }, {
                suffix: [0],
                name: 'product_type',
                rendername: 'product_type',
            }, {
                suffix: [0],
                name: 'is_active',
                rendername: 'is_active',
            }
        ];

        orderarr = [0, 'asc'];

        var columnDefs = [];
        var targetCounter = 0;
        $.each(columns, function(index, el) {
            if (el.suffix.includes(0)) {
                columnDefs.push({
                    name: el.name,
                    targets: targetCounter++,
                });
            }
        });

        var dataRetreiver = [];
        $.each(columns, function(index, el) {
            if (el.suffix.includes(0)) {
                dataRetreiver.push({
                    data: el.rendername,
                    render: el.render,
                    class: el.class
                });
            }
        });

        var dt = $('.' + tablename).DataTable({
            "deferLoading": true,
            "processing": true,
            "serverSide": true,
            "order": [orderarr],
            "columnDefs": columnDefs,
            "ajax": {
                "url" : "{{ route('search.LMD12', ['suffix' => $suffix, 'dependentparam' => $dependentParam ?? '' ]) }}",
                "type": 'POST', 
                "headers": {
                    'X-CSRF-TOKEN': getCSRFToken()
                }
            },
            "columns": dataRetreiver,
            "search": {
                "search": searchValue
            }
        });

        //make ajax to call server
        dt.draw();

        $('.' + tablename).on('click', 'a.dataindex', function(e) {
            e.preventDefault();

            if (mainscreen == true) {
                $('#searchSuggestTableModal').modal('hide');

                var value = $(this).data('value');

                sectionReloadAjaxReq({
                    id: mainreloadid,
                    url: (mainreloadurl + value).replace(/&amp;/g, "&")
                });

                if (detailreloadid) {
                    sectionReloadAjaxReq({
                        id: detailreloadid,
                        url: (detailreloadurl + value).replace(/&amp;/g, "&")
                    });
                }

                if (additionalreloadid) {
                    sectionReloadAjaxReq({
                        id: additionalreloadid,
                        url: (additionalreloadurl + value).replace(/&amp;/g, "&")
                    });
                }
            } else {
                var prompt = $(this).data('prompt');
                var value = $(this).data('value');

                $('#searchSuggestTableModal').modal('hide');

                $('input[name="' + fieldId + '"]').val(value);
                $('#' + fieldId).val(prompt);

                if (resetParam != undefined && resetParam != '') {
                    var resetFields = resetParam.split(',');
                    $.each(resetFields, function(i, j) {
                        if (j != undefined && j != '') {
                            $('#' + j).val("");
                            $('input[name="' + j + '"]').val("");
                        }
                    });
                }
            }
        });
    })
</script>

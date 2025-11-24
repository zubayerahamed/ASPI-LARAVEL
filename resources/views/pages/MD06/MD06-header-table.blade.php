@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of tags</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 MD06-datatable-fragment">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center" data-no-sort="Y">Background Color</th>
                        <th class="text-center" data-no-sort="Y">Text Color</th>
                        <th class="text-center" data-no-sort="Y">Preview</th>
                        <th class="text-center">Is Active?</th>
                        @if($allowCustomProductLabels)
                            <th class="text-right" data-no-sort="Y">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                @if($allowCustomProductLabels)
                                    <a data-reloadurl="{{ route('MD06', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                                @else
                                    {{ $x->name }}
                                @endif
                            </td>
                            <td>
                                <div class="border m-auto rounded" style="width: 30px; height: 30px; background-color: {{ $x->bg_color }};"></div>
                            </td>
                            <td>
                                <div class="border m-auto rounded" style="width: 30px; height: 30px; background-color: {{ $x->text_color }};"></div>
                            </td>
                            <td>
                                <div class="border m-auto d-flex justify-content-center align-items-center rounded" style="width: 100px; height: 30px; background-color: {{ $x->bg_color }}; color: {{ $x->text_color }};">
                                    {{ $x->name }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($x->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            @if($allowCustomProductLabels)
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button data-url="{{ route('MD06.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            kit.ui.config.initDatatable('MD06-datatable-fragment');

            $('.MD06-datatable-fragment').on('click', 'a.detail-dataindex', function(e){
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.MD06-datatable-fragment').on('click', 'button.btn-table-delete', function(e){
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif

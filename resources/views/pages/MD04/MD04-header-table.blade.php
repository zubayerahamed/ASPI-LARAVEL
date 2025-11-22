@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of options for Attribute: <a href="{{ route('AD04', ['id' => $attribute->id]) }}" class="screen-item" data-screen="AD04?id={{ $attribute->id }}">{{ $attribute->name }}</a></h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 MD04-datatable-fragment">
                <thead>
                    <tr>
                        <th>Option</th>
                        <th class="text-center" data-no-sort="Y">Color</th>
                        <th class="text-center" data-no-sort="Y">Thumbnail</th>
                        <th class="text-center">Sequence</th>
                        <th class="text-center">Is Default?</th>
                        <th class="text-right" data-no-sort="Y">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('MD04', ['id' => $x->id, 'attribute_id' => $x->attribute_id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                            </td>
                            <td class="text-center">
                                <div class="border m-auto" style="width: 50px; height: 50px; background-color: {{ $x->color }};"></div>
                            </td>
                            <td class="text-center">
                                @if ($x->thumbnail)
                                    <img src="{{ $x->thumbnail->originalFile }}" class="media-file img-thumbnail" style="width: 50px; height: 50px;" />
                                @else
                                    <span class="text-muted">No Thumbnail</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td class="text-center">
                                @if ($x->is_default)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('MD04.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            kit.ui.config.initDatatable('MD04-datatable-fragment');

            $('.MD04-datatable-fragment').on('click', 'a.detail-dataindex', function(e){
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.MD04-datatable-fragment').on('click', 'button.btn-table-delete', function(e){
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif

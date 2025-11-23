@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of attributes</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 MD03-datatable-fragment">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Options</th>
                        <th class="text-center">Sequence</th>
                        <th class="text-center">Is Active?</th>
                        @if ($allowCustomAttribute)
                            <th class="text-right" data-no-sort="Y">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                @if ($allowCustomAttribute)
                                    <a data-reloadurl="{{ route('MD03', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                                @else
                                    {{ $x->name }}
                                @endif
                            </td>
                            <td>
                                <div>
                                    @foreach ($x->terms as $term)
                                        <p class="p-0 m-0 text-sm text-muted">{{ $term->name }}</p>
                                    @endforeach
                                </div>
                                @if ($allowCustomAttribute)
                                    <a href="{{ route('MD04', ['attribute_id' => $x->id]) }}" class="text-sm screen-item" data-screen="MD04?attribute_id={{ $x->id }}">Configure Options</a>
                                @endif
                            </td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td class="text-center">
                                @if ($x->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            @if ($allowCustomAttribute)
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button data-url="{{ route('MD03.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('MD03-datatable-fragment');

            $('.MD03-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.MD03-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif

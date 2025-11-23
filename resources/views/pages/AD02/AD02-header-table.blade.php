@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of menus</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 AD02-datatable-fragment">
                <thead>
                    <tr>
                        <th>Menu Code</th>
                        <th>Title</th>
                        <th>Parent Menu</th>
                        <th class="text-center">Sequence</th>
                        <th data-no-sort="Y">Icon</th>
                        @if ($allowCustomMenu)
                            <th class="text-right" data-no-sort="Y">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                @if ($allowCustomMenu)
                                    <a data-reloadurl="{{ route('AD02', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->xmenu }}</a>
                                @else
                                    {{ $x->xmenu }}
                                @endif
                            </td>
                            <td>{{ $x->title }}</td>
                            <td>
                                <span class="badge bg-{{ $x->parent_menu_id ? 'primary' : 'warning' }}">{{ $x->parent_menu_id ? $x->parentMenu->xmenu . ' - ' . $x->parentMenu->title : 'No Parent' }}</span>
                            </td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="{{ $x->icon }}"></i>
                                    <span>{{ $x->icon }}</span>
                                </div>
                            </td>
                            @if ($allowCustomMenu)
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button data-url="{{ route('AD02.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('AD02-datatable-fragment');

            $('.AD02-datatable-fragment').on('click', 'a.detail-dataindex', function(e){
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.AD02-datatable-fragment').on('click', 'button.btn-table-delete', function(e){
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif

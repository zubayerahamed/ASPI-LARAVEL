@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of Product Specification Tables</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 MD10-datatable-fragment">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Selected Groups</th>
                        <th class="text-right" data-no-sort="Y">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('MD10', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                            </td>
                            <td>
                                {{ $x->description }}
                            </td>
                            <td>
                                <!-- Display the name of each group associated with this table as a badge and sequence -->
                                <!-- Add arrows to change the sequence -->
                                @foreach ($x->groups()->orderBy('product_specification_table_groups.seqn')->get() as $group)
                                    <div class="d-flex justify-content-start align-items-center mb-1 gap-2">
                                        <span class="badge badge-primary">{{ $group->name }}</span>
                                        <div class="d-flex align-items-center gap-1">
                                            <!-- If seqneucen is greater than 1, show up arrow -->
                                            @if ($loop->first == false)
                                                <button data-reloadurl="{{ route('MD10.update-sequence', ['id' => $x->id, 'groupId' => $group->id, 'sequenceDirection' => 'up']) }}" type="button" class="btn btn-sm btn-link p-0 m-0 text-dark btn-sequence-change"><i class="ph ph-caret-up"></i></button>
                                            @endif
                                            <!-- If not last, show down arrow -->
                                            @if ($loop->last == false)
                                                <button data-reloadurl="{{ route('MD10.update-sequence', ['id' => $x->id, 'groupId' => $group->id, 'sequenceDirection' => 'down']) }}" type="button" class="btn btn-sm btn-link p-0 m-0 text-dark btn-sequence-change"><i class="ph ph-caret-down"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('MD10.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('MD10-datatable-fragment');

            $('.MD10-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.MD10-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });

            $('.MD10-datatable-fragment').on('click', 'button.btn-sequence-change', function(e) {
                e.preventDefault();
                actionPostRequest($(this).data('reloadurl'));
            });

        })
    </script>
@endif

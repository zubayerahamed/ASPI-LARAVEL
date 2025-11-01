@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Business Categories List</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Code</th>
                        <th class="text-center">Is Active?</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a class="detail-dataindex" data-reloadid="main-form-container" data-reloadurl="/SA05?id={{ $x->id }}" href="#">{{ $x->name }}</a>
                            </td>
                            <td>{{ $x->xcode }}</td>
                            <td class="text-center">{{ $x->is_active ? 'Y' : 'N' }}</td>
                            <td class="text-right">
                                <button type="button" data-url="{{ route('SA05.delete', ['id' => $x->id]) }}" class="btn btn-danger btn-sm btn-table-delete"><i class="ph ph-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('a.detail-dataindex').off('click').on('click', function(e) {
                e.preventDefault();
    
                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });
    
            $('.btn-table-delete').off('click').on('click', function(e) {
                e.preventDefault();
                if (!confirm("Are you sure, to delete this?")) {
                    return;
                }
                deleteRequest($(this).data('url'));
            });
        })
    </script>
@endif




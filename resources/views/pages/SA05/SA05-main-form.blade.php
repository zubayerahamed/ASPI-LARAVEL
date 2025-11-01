<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $businessCategory->id == null ? route('SA05.create') : route('SA05.update', ['id' => $businessCategory->id]) }}" method="POST">
            @csrf
            @if ($businessCategory->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $businessCategory->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Category name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $businessCategory->name }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="xcode">Category code</label>
                        <input type="text" class="form-control" id="xcode" name="xcode" value="{{ $businessCategory->xcode }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="is_active">Is Active?</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $businessCategory->is_active ? 'checked' : '' }}>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button type="reset" 
                        data-reloadid="main-form-container" 
                        data-reloadurl="/SA05?id=RESET" 
                        data-detailreloadid="header-table-container" 
                        data-detailreloadurl="/SA05/header-table"
                        class="btn btn-default btn-reset">Clear</button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($businessCategory->id == null)
                        <button type="submit" class="btn btn-primary btn-submit d-flex align-items-center ml-2"><i class="ph ph-floppy-disk mr-2"></i> <span>Save</span></button>
                    @else
                        <button type="button" data-url="{{ route('SA05.delete', ['id' => $businessCategory->id]) }}" class="btn btn-danger btn-delete d-flex align-items-center ml-2"><i class="ph ph-trash mr-2"></i> <span>Delete</span></button>
                        <button type="submit" class="btn btn-primary btn-submit d-flex align-items-center ml-2"><i class="ph ph-pencil mr-2"></i> <span>Update</span></button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        kit.ui.init();

        $('.btn-reset').off('click').on('click', function(e) {
            e.preventDefault();

            sectionReloadAjaxReq({
                id: $(this).data('reloadid'),
                url: $(this).data('reloadurl')
            });

            sectionReloadAjaxReq({
                id: $(this).data('detailreloadid'),
                url: $(this).data('detailreloadurl')
            });
        });

        $('.btn-submit').off('click').on('click', function(e) {
            e.preventDefault();
            submitMainForm();
        });

        $('.btn-delete').off('click').on('click', function(e) {
            e.preventDefault();
            if (!confirm("Are you sure, to delete this?")) {
                return;
            }
            deleteRequest($(this).data('url'));
        });
    })
</script>

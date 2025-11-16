<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $tag->id == null ? route('AD06.create') : route('AD06.update', ['id' => $tag->id]) }}" method="POST">
            @csrf
            @if ($tag->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $tag->id }}">
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Tag</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}" required>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="5">{{ $tag->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $tag->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD06', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD06.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($tag->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD06.delete', ['id' => $tag->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
                            <i class="ph ph-trash"></i> <span>Delete</span>
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Update</span>
                        </button>
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
            sweetAlertConfirm(() => {
                deleteRequest($(this).data('url'));
            });
        });
    })
</script>
<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $taxComponent->id == null ? route('AD17.create') : route('AD17.update', ['id' => $taxComponent->id]) }}" method="POST">
            @csrf
            @if ($taxComponent->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $taxComponent->id }}">
            @endif

            <div class="row">
                <!-- name -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $taxComponent->code }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $taxComponent->name }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $taxComponent->description }}">
                    </div>
                </div>
                
               <div class="col-md-12"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_recoverable" name="is_recoverable" {{ $taxComponent->is_recoverable ? 'checked' : '' }}>
                            <label for="is_recoverable" class="custom-control-label form-label">Is Recoverable?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD17', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD17.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($taxComponent->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD17.delete', ['id' => $taxComponent->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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

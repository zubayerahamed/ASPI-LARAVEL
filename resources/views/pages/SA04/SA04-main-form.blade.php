<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $screen->id == null ? route('SA04.create') : route('SA04.update', ['id' => $screen->id]) }}" method="POST">
            @csrf
            @if ($screen->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $screen->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="xscreen">Screen Code</label>
                        @if ($screen->id == null)
                            <input type="text" class="form-control" id="xscreen" name="xscreen" value="{{ $screen->xscreen }}" required>
                        @else
                            <input type="text" class="form-control" value="{{ $screen->xscreen }}" disabled>
                            <input type="hidden" id="xscreen" name="xscreen" value="{{ $screen->xscreen }}">
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $screen->title }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="type">Type</label>
                        <select class="form-control select2bs4" id="type" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="SCREEN" {{ $screen->type == 'SCREEN' ? 'selected' : '' }}>Screen</option>
                            <option value="REPORT" {{ $screen->type == 'REPORT' ? 'selected' : '' }}>Report</option>
                            <option value="SYSTEM" {{ $screen->type == 'SYSTEM' ? 'selected' : '' }}>System</option>
                            <option value="DEFAULT" {{ $screen->type == 'DEFAULT' ? 'selected' : '' }}>Default</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="xnum">Transaction Begins</label>
                        <input type="number" class="form-control" id="xnum" name="xnum" value="{{ $screen->xnum }}" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence number</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $screen->seqn }}" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="icon">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{ $screen->icon }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="keywords">Keywords</label>
                        <textarea class="form-control" rows="1" id="keywords" name="keywords">{{ $screen->keywords }}</textarea>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('SA04', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('SA04.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($screen->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('SA04.delete', ['id' => $screen->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
            if (!confirm("Are you sure, to delete this?")) {
                return;
            }
            deleteRequest($(this).data('url'));
        });
    })
</script>

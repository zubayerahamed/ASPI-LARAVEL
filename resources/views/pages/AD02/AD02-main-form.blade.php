<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $menuScreen->id == null ? route('AD02.create') : route('AD02.update', ['id' => $menuScreen->id]) }}" method="POST">
            @csrf
            @if ($menuScreen->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $menuScreen->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="menu_id">Menu</label>
                        <select class="form-control select2bs4" id="menu_id" name="menu_id" required>
                            <option value="">-- Select Menu --</option>
                            @include('pages.AD02.AD02-menu-recursive', [
                                'menuTree' => $menus,
                                'count' => 0,
                            ])
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="screen_id">Screen/Report</label>
                        <select class="form-control select2bs4" id="screen_id" name="screen_id" required>
                            <option value="">-- Select Screen --</option>
                            @foreach ($screens as $screen)
                                <option value="{{ $screen->id }}" {{ $menuScreen->screen_id == $screen->id ? 'selected' : '' }}>{{ $screen->xscreen }} - {{ $screen->title }} - {{ $screen->type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="alternate_title">Alternate Title</label>
                        <input type="text" class="form-control" id="alternate_title" name="alternate_title" value="{{ $menuScreen->alternate_title }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence number</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $menuScreen->seqn }}" min="0">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD02', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD02.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($menuScreen->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD02.delete', ['id' => $menuScreen->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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

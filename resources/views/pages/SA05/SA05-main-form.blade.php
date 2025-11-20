<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $menu->id == null ? route('SA05.create') : route('SA05.update', ['id' => $menu->id]) }}" method="POST">
            @csrf
            @if ($menu->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $menu->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="xmenu">Menu Code</label>
                        @if ($menu->id == null)
                            <input type="text" class="form-control" id="xmenu" name="xmenu" value="{{ $menu->xmenu }}" required>
                        @else
                            <input type="text" class="form-control" value="{{ $menu->xmenu }}" disabled>
                            <input type="hidden" id="xmenu" name="xmenu" value="{{ $menu->xmenu }}">
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $menu->title }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="type">Parent Menu</label>
                        <select class="form-control select2bs4" id="parent_menu_id" name="parent_menu_id">
                            <option value="">-- Select Parent Menu --</option>
                            @include('pages.SA05.SA05-menu-recursive', [
                                'menuTree' => $menuTree,
                                'count' => 0,
                            ])
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="icon">Icon</label>
                        <div class="icon-picker-container">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i id="selectedIconPreview" class="{{ $menu->icon }}"></i></span>
                                </div>
                                <input type="text" class="form-control icon-input" name="icon" value="{{ $menu->icon }}">
                                <div class="input-group-append">
                                    <div class="input-group-text toggle-icon-picker"><i class="ph ph-caret-down"></i></div>
                                </div>
                            </div>

                            <div class="icon-picker-dropdown" id="iconPickerDropdown">
                                <div class="icon-picker-search">
                                    <div class="input-group">
                                        <input type="text" id="iconSearch" class="form-control icon-search" placeholder="Search icons...">
                                        <div class="input-group-append">
                                            <div class="input-group-text reset-icon-search"><i class="ph ph-arrows-clockwise"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-picker-icons" id="iconPickerIcons">
                                    <!-- Icons will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence number</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $menu->seqn }}" min="0">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('SA05', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('SA05.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($menu->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('SA05.delete', ['id' => $menu->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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

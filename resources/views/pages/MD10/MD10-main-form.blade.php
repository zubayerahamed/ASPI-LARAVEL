<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $psTable->id == null ? route('MD10.create') : route('MD10.update', ['id' => $psTable->id]) }}" method="POST">
            @csrf
            @if ($psTable->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $psTable->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $psTable->name }}" required>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $psTable->description }}">
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h5 class="m-0 text-bold">Select the groups to display in this table</h5>
                    <span class="text-muted">At least one group must be selected</span>
                    <hr>
                </div>

                @foreach ($psGroups as $group)
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="group_{{ $group->id }}" name="group_ids[]" value="{{ $group->id }}" {{ in_array($group->id, old('group_ids', $psTable->groups->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="group_{{ $group->id }}" class="custom-control-label form-label">{{ $group->name }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD10', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('MD10.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($psTable->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD10.delete', ['id' => $psTable->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $xcodes->id == null ? route('SA05.create') : route('SA05.update', ['id' => $xcodes->id]) }}" method="POST">
            @csrf
            @if ($xcodes->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $xcodes->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="type">Code Type</label>
                        <select class="form-control select2bs4" id="type" name="type" required>
                            <option value="">-- Select Code Type --</option>
                            <option value="Code Type" {{ $xcodes->type == 'Code Type' ? 'selected' : '' }}>Code Type</option>
                            @foreach ($codeTypes as $bc)
                                <option value="{{ $bc->xcode }}" {{ $xcodes->type == $bc->xcode ? 'selected' : '' }}>
                                    {{ $bc->xcode }}
                                    @if ($bc->description)
                                        {{ ' - ' . $bc->description }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="xcode">Code</label>
                        <input type="text" class="form-control" id="xcode" name="xcode" value="{{ $xcodes->xcode }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $xcodes->description }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence number</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $xcodes->seqn }}" min="0" required>
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
                    @if ($xcodes->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('SA05.delete', ['id' => $xcodes->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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

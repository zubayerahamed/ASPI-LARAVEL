@if (isset($productOptionDetail) && $productOptionDetail != null && $productOptionDetail->product_option_id != 'RESET')
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Product option details</h3>
        </div>

        <div class="card-body">
            <form id="detailform" action="{{ $productOptionDetail->id == null ? route('MD07.detail-table.create') : route('MD07.detail-table.update', ['id' => $productOptionDetail->id]) }}" method="POST">
                @csrf
                @if ($productOptionDetail->id != null)
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $productOptionDetail->id }}">
                    
                @endif

                <input type="hidden" name="product_option_id" value="{{ $productOptionDetail->product_option_id }}">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="label">Label</label>
                            <input type="text" class="form-control" id="label" name="label" value="{{ $productOptionDetail->label }}" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="additional_price">Additional Price</label>
                            <input type="number" class="form-control" id="additional_price" name="additional_price" value="{{ $productOptionDetail->additional_price }}" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="price_type">Price Type</label>
                            <select class="form-control select2bs4" id="price_type" name="price_type" required>
                                <option value="">-- Select Price Type --</option>
                                <option value="fixed" {{ $productOptionDetail->price_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percentage" {{ $productOptionDetail->price_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="seqn">Sequence</label>
                            <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $productOptionDetail->seqn }}" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 text-left">
                        <button
                                data-reloadid="detail-table-container"
                                data-reloadurl="{{ route('MD07.detail-table', ['id' => 'RESET', 'product_option_id' => $productOptionDetail->product_option_id]) }}"
                                type="reset"
                                class="btn btn-sm btn-default btn-detail-reset d-flex align-items-center gap-2">
                            <i class="ph ph-broom"></i> <span>Clear</span>
                        </button>
                    </div>
                    <div class="flex-grow-1 justify-content-end d-flex gap-2">
                        @if ($productOptionDetail->id == null)
                            <button type="submit" class="btn btn-sm btn-primary btn-detail-submit d-flex align-items-center gap-2">
                                <i class="ph ph-floppy-disk"></i> <span>Save</span>
                            </button>
                        @else
                            <button data-url="{{ route('MD07.detail-table.delete', ['id' => $productOptionDetail->id]) }}" type="button" class="btn btn-sm btn-danger btn-detail-delete d-flex align-items-center gap-2">
                                <i class="ph ph-trash"></i> <span>Delete</span>
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary btn-detail-submit d-flex align-items-center gap-2">
                                <i class="ph ph-floppy-disk"></i> <span>Update</span>
                            </button>
                        @endif
                    </div>
                </div>

            </form>
        </div>

        @if (!$detailList->isEmpty())
            <div class="table-responsive data-table-responsive">
                <table class="table table-hover table-bordered p-0 m-0 MD07-datatable-fragment">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Additional Price</th>
                            <th>Price Type</th>
                            <th class="text-center">Sequence</th>
                            <th class="text-right" data-no-sort="Y">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailList as $x)
                            <tr>
                                <td>
                                    <a data-reloadurl="{{ route('MD07.detail-table', ['id' => $x->id, 'product_option_id' => $x->product_option_id]) }}" class="detail-dataindex" data-reloadid="detail-table-container" href="#">{{ $x->label }}</a>
                                </td>
                                <td>{{ $x->additional_price }}</td>
                                <td>{{ $x->price_type }}</td>
                                <td class="text-center">{{ $x->seqn }}</td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button data-url="{{ route('MD07.detail-table.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            kit.ui.init();

            $('.btn-detail-reset').off('click').on('click', function(e){
				e.preventDefault();

				sectionReloadAjaxReq({
					id : $(this).data('reloadid'),
					url : $(this).data('reloadurl')
				});
			});

            $('.btn-detail-submit').off('click').on('click', function(e){
                console.log('here');
				e.preventDefault();
				submitMainForm(null, $('form#detailform'));
			});

			$('.btn-detail-delete').off('click').on('click', function(e){
				e.preventDefault();
				sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
			});


            $('.MD07-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            
            $('.MD07-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif

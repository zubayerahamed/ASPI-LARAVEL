<div class="row">
    <div class="d-flex justify-content-center flex-wrap" style="width: 100%;">
        @if ($businesses->isEmpty())
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No businesses available.
                </div>
            </div>
        @endif
        @foreach ($businesses as $business)
            <div class="col-md-4">
                <a href="{{ route('business.selection', ['id' => $business->id]) }}" class="d-block business-card text-center pt-4 pb-4 p-3 mb-4 border rounded bg-white text-white cursor-pointer">
                    <h4>{{ $business->name }}</h4>
                    <p class="text-sm text-muted">Joined {{ date('d-M-Y', strtotime($business->created_at)) }}</p>
                    <div class="col-md-12 d-flex justify-content-between align-items-center gap-3">
                        <div class="d-flex flex-column justify-content-center">
                            <div><i class="ph ph-check text-success"></i></div>
                            <div>In house</div>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <div><i class="ph ph-check text-success"></i></div>
                            <div>Pickup</div>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <div><i class="ph ph-check text-success"></i></div>
                            <div>Delivery</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
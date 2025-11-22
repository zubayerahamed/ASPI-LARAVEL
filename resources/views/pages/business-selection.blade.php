<div class="row">
    <div class="d-flex justify-content-center flex-wrap" style="width: 100%;">
        @if ($businesses->isEmpty())
            <div class="col-12">
                <h1 class="text-center">
                    Business Not Created Yet.
                </h1>
            </div>
        @endif
        @foreach ($businesses as $business)
            <div class="col-md-3">
                <a  href="{{ route('business-selection.select', ['id' => $business->id]) }}" 
                    class="d-block  text-center mb-4 border bg-white cursor-pointer" style="border-radius: 5px; overflow: hidden;">
                    <div class="bg-primary p-2">
                        <h4 class="mt-2 mb-0 text-bold">{{ $business->name }}</h4>
                        <p class="text-sm">Joined {{ date('d-M-Y', strtotime($business->created_at)) }}</p>
                    </div>
                    <div class="bg-white p-2">
                        <div class="mt-2 mb-2">Active {{ $business->activeBranches() }} Branches</div>
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column justify-content-center flex-grow-1 p-2">
                                @if ($business->is_inhouse)
                                    <div><i class="ph ph-check text-success"></i></div>
                                @else
                                    <div><i class="ph ph-x text-danger"></i></div>
                                @endif
                                <div class="text-uppercase">In house</div>
                            </div>
                            <div class="d-flex flex-column justify-content-center border-left border-right flex-grow-1 p-2">
                                @if ($business->is_pickup)
                                    <div><i class="ph ph-check text-success"></i></div>
                                @else
                                    <div><i class="ph ph-x text-danger"></i></div>
                                @endif
                                <div class="text-uppercase">Pickup</div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-grow-1 p-2">
                                @if ($business->is_delivery)
                                    <div><i class="ph ph-check text-success"></i></div>
                                @else
                                    <div><i class="ph ph-x text-danger"></i></div>
                                @endif
                                <div class="text-uppercase">Delivery</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
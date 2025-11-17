<div class="row">
    <div class="d-flex justify-content-center flex-wrap" style="width: 100%;">
        @foreach ($businesses as $business)
            <div class="col-md-4">
                <a href="{{ route('business.selection', ['id' => $business->id]) }}" class="d-block business-card text-center pt-4 pb-4 p-3 mb-4 border rounded bg-primary text-white cursor-pointer">
                    <h4>{{ $business->name }}</h4>
                    <p>Joined {{ date('d-M-Y', strtotime($business->created_at)) }}</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <div>
                            
                        </div>
                        <div>2</div>
                        <div>3</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
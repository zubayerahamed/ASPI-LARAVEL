<div class="row">
    <div class="d-flex justify-content-center flex-wrap" style="width: 100%;">
        @if ($profiles->isEmpty())
            <div class="col-12">
                <h1 class="text-center">
                    {{ getSelectedProfile() == null ? 'Profiles Not Assigned Yet.' : 'No other profile available to switch.' }}
                </h1>
            </div>
        @endif
        @foreach ($profiles as $profile)
            <div class="col-md-3">
                <a  href="{{ route('profile-selection.select', ['id' => $profile->id]) }}" 
                    class="d-block text-center border bg-white cursor-pointer" style="border-radius: 5px; overflow: hidden;">
                    <div class="bg-success p-2">
                        <h4 class="text-bold m-0 p-3">{{ $profile->name }}</h4>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
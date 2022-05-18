@if( isset($shopper['status']['name']) )

    @switch( $shopper['status']['name'] )
        @case('Active')
        <form method="post" action="{{ route('store.location.checkout', ['storeUuid' => $store]) }}">
            @csrf
            <input type="hidden" name="location_id" value="{{ $location['id'] }}">
            <input type="hidden" name="locationUuid" value="{{ $location['uuid'] }}">
            <input type="hidden" name="email" value="{{ $shopper['email'] }}">
            <input type="hidden" name="shopper_id" value="{{ $shopper['id'] }}">
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">
                Checkout
            </button>
        </form>
        @break

        @case('Completed')
        {{ $shopper['check_out'] }}
        @break

        @default
        
        @break
    @endswitch
@endif

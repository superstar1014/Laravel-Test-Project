<x-table-column>
    <x-shopper.status :shopper="$shopper"/>
</x-table-column>

<x-table-column>
    {{ $shopper['first_name'] }} {{ $shopper['last_name'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['email'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['check_in'] }}
</x-table-column>

<x-table-column>
    <x-shopper.checkout :shopper="$shopper" :store="$store" :location="$location"/>
</x-table-column>

{{--<x-table-column>--}}

{{--</x-table-column>--}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if( isset($location['location_name']))
                {{ __( $location['location_name'] . ' Shoppers') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                                Register Shopper
                            </h2>
                            <form method="post" action="{{ route('store.location.shopperSave', ['storeUuid' => $store]) }}">

                                @csrf
                                <input type="hidden" name="location_id" value="{{ $location['id'] }}">
                                <input type="hidden" name="locationUuid" value="{{ $location['uuid'] }}">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="firstName">
                                        First Name
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstName" name="first_name" type="text" placeholder="First Name">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="lastName">
                                        Last Name
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastName" name="last_name" type="text" placeholder="Last Name">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Email">
                                </div>

                                <div class="mb-4">
                                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="w-full whitespace-no-wrapw-full whitespace-no-wrap mt-6">
                        <thead>
                        <tr>
                            <th>
                                Status
                            </th>
                            <th>
                                Shopper Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Check-In
                            </th>
                            <th>
                                Check-Out
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if( isset( $shoppers['active'] ) && is_iterable( $shoppers['active'] ) )
                            @if( count( $shoppers['active'] )  >= 1 )
                                @foreach( $shoppers['active'] as $shopper )
                                    <tr class="text-center">
                                        <x-shopper.listing :shopper="$shopper" :store="$store" :location="$location"/>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        @if( isset( $shoppers['pending'] ) && is_iterable( $shoppers['pending'] ) )
                            @if( count( $shoppers['pending'] )  >= 1 )
                                @foreach( $shoppers['pending'] as $shopper )
                                    <tr class="text-center">
                                        <x-shopper.listing :shopper="$shopper" :store="$store" :location="$location"/>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        @if( isset( $shoppers['completed'] ) && is_iterable( $shoppers['completed'] ) )
                            @if( count( $shoppers['completed'] )  >= 1 )
                                @foreach( $shoppers['completed'] as $shopper )
                                    <tr class="text-center">
                                        <x-shopper.listing :shopper="$shopper" :store="$store" :location="$location"/>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

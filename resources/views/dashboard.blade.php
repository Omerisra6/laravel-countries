<x-app-layout>
    @php
        $updateCountryErrors = $errors->getBag('UpdateCountryForm');
        $storeCountryErrors  = $errors->getBag('StoreCountryForm');
    @endphp

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <div class="flex justify-center align-center">

        <div class="bg-white w-11/12 rounded-md mt-8">
        
            <div>

                <div class="bg-white  border-b border-gray-200 py-3 px-0 rounded-t-md">

                    <div class="text-sm px-3 bold">
                        You're logged in!
                    </div>

                </div>
                
            </div>

            <div class="py-12 p-3 gap-3 flex flex-wrap justify-center">    

                <div class="w-11/12  border-2 border-slate-100 rounded-sm h-fit sm:w-1/4">

                    <div class="bg-gray-100 w-100 text-xs px-3 py-2">Add New Country</div>
                
                    <form method="POST" action="/countries">

                        @csrf

                        <div class="w-100 py-2 px-3 text-zinc-500">

                            <div class="mb-4">

                                <label for="name" class="block mb-2  text-xs">Name</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-0 border rounded">
                                @if ( $storeCountryErrors->has( 'name' ) )
                                    <div class="text-red-500 text-xs">{{ $storeCountryErrors->first( 'name' ) }}</div>
                                @endif
                    
                            </div>

                            <div class="mb-4">

                                <label for="ISO" class="block mb-2 text-xs">ISO</label>
                                <input type="text" id="ISO" name="ISO" class="w-full px-4 py-0 border rounded">
                                @if ( $storeCountryErrors->has( 'ISO' ) )
                                    <div class="text-red-500 text-xs">{{ $storeCountryErrors->first( 'ISO' ) }}</div>
                                @endif

                            </div>

                        </div>

                        <div class="bg-gray-100 w-100 px-3 py-2 flex align-center">

                            <button type="submit" class="px-3 py-1 bg-slate-950 text-white rounded text-xs bold ml-auto hover:bg-slate-800">Save</button>

                        </div>
                        
                    </form>

                </div>

                <div class="w-11/12 sm:w-4/6">

                    <div class="bg-white">
                        
                        <div class="border-2 border-slate-100 rounded-sm">

                            <div class="bg-gray-100 w-100 text-xs px-3 py-2">List of countries</div>
                            <table class="w-full table-auto border-collapse text-sm">

                                <thead class="text-left">

                                    <tr class="border">

                                        <th class="px-3 py-1 w-1/4">#</th>
                                        <th class="px-3 py-1 w-1/4">

                                            <div>Name</div>
                                            @if ( $updateCountryErrors->has( 'name' ) )
                                                <div class="text-red-500 text-xs">{{ $updateCountryErrors->first( 'name' ) }}</div>
                                            @endif

                                        </th>
                                        <th class="px-3 py-1 w-1/4">

                                            <div>ISO</div>
                                            @if ( $updateCountryErrors->has( 'ISO' ) )
                                                <div class="text-red-500 text-xs">{{ $updateCountryErrors->first( 'ISO' ) }}</div>
                                            @endif

                                        </th>
                                        <th class="px-3 py-1 w-1/4">Edit</th>

                                    </tr>

                                </thead>
                                
                                <tbody>

                                    @foreach($countries as $country)

                                        <tr class="border">

                                            <form method="POST" action="/countries/{{ $country->id }}">

                                                <td class="px-3 py-1 w-1/4">

                                                    <div>{{ $loop->index + 1 }}</div>

                                                </td>
                                                @csrf
                                                @method('PUT')
                                                <td class="px-3 py-1 w-1/4">

                                                    <input type="text" name="name" value="{{ $country->name }}" class="w-full px-4 py-0 rounded">
                                                    
                                                </td>
                                                <td class="px-3 py-1 w-1/4">
                                                    
                                                    <input type="text" name="ISO" value="{{ $country->ISO }}" class="w-full px-4 py-0 rounded">
                                                
                                                </td>

                                                <td class="px-3 py-1 w-1/4">

                                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-400">Edit</button>

                                                </td>

                                            </form>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</x-app-layout>
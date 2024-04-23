<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4">
                        <div class="mb-4">
                            <a
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                Create Product
                            </a>
                        </div>
                    </div>

                    <div class="overflow-hidden overflow-x-auto mb-4 min-w-full align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td class="px-2 py-2">
                                        <input wire:model.live.debounce="searchColumns.name" type="text"
                                            placeholder="Search..."
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                    </td>
                                    <td class="px-2 py-1">
                                        <select wire:model.live="searchColumns.category_id"
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">-- choose category --</option>
                                            @foreach ($form->categories as $id => $category)
                                                <option value="{{ $id }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-1">
                                        <select wire:model.live="searchColumns.country_id"
                                            class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">-- choose country --</option>
                                            @foreach ($form->countries as $id => $country)
                                                <option value="{{ $id }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-1 text-sm">
                                        <div>
                                            From
                                            <input wire:model.live.debounce="searchColumns.price.0" type="number"
                                                class="mr-2 w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                        </div>
                                        <div>
                                            to
                                            <input wire:model.live.debounce="searchColumns.price.1" type="number"
                                                class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>ٍ
                                <tr>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Name</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Categories</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Country</span>
                                    </th>
                                    <th class="px-6 py-3 w-32 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Price</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($products as $product)
                                    <tr class="bg-white">
                                        <td class="px-4 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            <input type="checkbox" value="{{ $product->id }}"
                                                wire:model.live="selected">
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $product->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @foreach ($product->categories as $category)
                                                <span
                                                    class="px-2 py-1 text-xs text-indigo-700 bg-indigo-200 rounded-md">{{ $category->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $product->countryName }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            ${{ number_format($product->price / 100, 2) }}
                                        </td>
                                        <td>
                                            <a
                                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                                Edit
                                            </a>
                                            <button
                                                class="px-4 py-2 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            No products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{ $products->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
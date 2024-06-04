@extends('pages.merchant.merchant')

@section('title', 'Merchant Home')

@section('content')
    <div class="w-full h-full" id="merchant-home-screen">
        <div class="w-full p-10 flex flex-col h-fit gap-4">
            <div class="bg-black p-8 rounded-md bg-opacity-40 flex flex-col gap-4">
                <h1 class="text-white font-bold text-2xl">
                    Pending Orders
                </h1>
                <div class="flex flex-row flex-wrap gap-4">
                    @if($pendingOrders->count() < 1)
                        <div class="w-full h-full py-2 flex flex-col gap-2 justify-center place-items-center">
                            <img alt="Placeholder" src="{{ url(asset('assets/merchants/no-pending.png')) }}"
                                 class="w-auto h-64">
                            <div class="text-gray-100 font-bold text-3xl">
                                No Pending Orders
                            </div>
                            <div class="text-gray-100 text-base">
                                Start promoting your products to reach more customers
                            </div>
                        </div>
                    @endif
                    @foreach($pendingOrders as $pending)
                        <div class="flex-grow bg-white p-4 rounded-md flex flex-col gap-4">
                            <div class="flex flex-row gap-4 place-items-center">
                                <div class="font-semibold text-sm">
                                    {{ $pending->transactionHeader->user->username }}
                                </div>
                                <div class="flex flex-row gap-1">
                                    <div class="text-xs">
                                        {{ $pending->transactionHeader->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs">
                                        {{ $pending->transactionHeader->created_at->format('H:m') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row gap-4">
                                <img alt="Product Image"
                                     src="{{ asset($pending->product->productImages->first()->image) }}"
                                     class="w-16 h-16 rounded-md">
                                <div class="flex flex-col justify-center">
                                    <div class="font-semibold">
                                        {{ $pending->product->name }}
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $pending->productVariant->name }}
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        {{ $pending->quantity }} pcs x
                                        Rp{{ formatPrice($pending->productVariant->price) }}
                                    </div>
                                </div>
                            </div>
                            <a class="relative" href="{{asset("/storage/transaction/receipt/".$pending->image)}}"
                               target="_blank">
                                <img src="{{asset("/storage/transaction/receipt/".$pending->image)}}" alt="Receipt"
                                     class="w-full object-cover h-48">
                                <div
                                    class="absolute bg-black text-white w-full h-full top-0 flex place-items-center bg-opacity-0 hover:bg-opacity-40 justify-center text-medium text-lg opacity-0 hover:opacity-100
                                    hover:duration-500 z-30 gap-4">
                                    <div class="w-10 h-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m9 14.25 6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185ZM9.75 9h.008v.008H9.75V9Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008V13.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                        </svg>
                                    </div>
                                    View Receipt
                                </div>
                            </a>
                            <div class="justify-end flex flex-row gap-2">
                                <button
                                    class="bg-red-400 max-w-md flex-grow hover:bg-red-500 py-2 px-4 text-white rounded-md font-bold"
                                    onclick="rejectOrder('{{$pending->transaction_id}}' , '{{$pending->variant_id}}', '{{$pending->product_id}}')">
                                    Reject Order
                                </button>
                                <button
                                    class="bg-indigo-600 max-w-md flex-grow hover:bg-indigo-700 py-2 px-4 text-white rounded-md font-bold"
                                    onclick="completeOrder('{{$pending->transaction_id}}' , '{{$pending->variant_id}}', '{{$pending->product_id}}')">
                                    Complete Order
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-black p-8 rounded-md bg-opacity-40 flex flex-col gap-4">
                <h1 class="text-white font-bold text-2xl">
                    Shipped Orders
                </h1>
                <div class="flex flex-row flex-wrap gap-4">
                    @if($shippingOrders->count() < 1)
                        <div class="w-full h-full py-2 flex flex-col gap-2 justify-center place-items-center">
                            <img alt="Placeholder" src="{{ url(asset('assets/merchants/no-shipping.png')) }}"
                                 class="w-auto h-64">
                            <div class="text-gray-100 font-bold text-3xl">
                                No Shipped Orders
                            </div>
                            <div class="text-gray-100 text-base">
                                Start completing pending orders
                            </div>
                        </div>
                    @endif
                    @foreach($shippingOrders as $shipped)
                        <div class="w-96 bg-white p-4 rounded-md flex flex-col gap-4">
                            <div class="flex flex-row gap-4 place-items-center">
                                <div class="font-semibold text-sm">
                                    {{ $shipped->transactionHeader->user->username }}
                                </div>
                                <div class="flex flex-row gap-1">
                                    <div class="text-xs">
                                        {{ $shipped->transactionHeader->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs">
                                        {{ $shipped->transactionHeader->created_at->format('H:m') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row gap-4 pb-4 border-b-2 border-gray-200">
                                <img alt="Product Image"
                                     src="{{ asset($shipped->product->productImages->first()->image) }}"
                                     class="w-16 h-16 rounded-md">
                                <div class="flex flex-col justify-center">
                                    <div class="font-semibold">
                                        {{ $shipped->product->name }}
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $shipped->productVariant->name }}
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        {{ $shipped->quantity }} pcs x
                                        Rp{{ formatPrice($shipped->productVariant->price) }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <div class="font-bold"> Shipping Details</div>
                                <div>
                                    Shipment Type: <span class="text-gray-600">{{ $shipped->shipment->name }}</span>
                                </div>
                                <div>
                                    Shipment Date: <span
                                        class="text-gray-600">{{ $shipped->updated_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">

                                <div class="font-semibold">
                                    Destination Address
                                </div>
                                <div class="text-base text-gray-500">
                                    {{ $shipped->transactionHeader->location->city }},
                                    {{ $shipped->transactionHeader->location->country }}
                                </div>
                                <div class="text-base text-gray-500">
                                    {{ $shipped->transactionHeader->location->postal_code }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <style>
    </style>
    <script>

        function completeOrder(transaction_id, variant_id, product_id) {
            let data = {
                product_id: product_id,
                variant_id: variant_id,
                transaction_id: transaction_id,
                _token: "{{ csrf_token() }}"
            }

            fetch('/transaction/complete-order', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => response.json())
                .then(() => {
                    window.location.reload();
                })
                .catch((error) => {
                    console.error('Error:', error);
                })
        }

        function rejectOrder(transaction_id, variant_id, product_id) {
            let data = {
                product_id: product_id,
                variant_id: variant_id,
                transaction_id: transaction_id,
                _token: "{{ csrf_token() }}"
            }

            fetch('/transaction/reject-order', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => response.json())
                .then(() => {
                    window.location.reload();
                })
                .catch((error) => {
                    console.error('Error:', error);
                })
        }
    </script>
@endsection

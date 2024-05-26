<a href="/product-detail/{{ $product->id }}" class="z-10 bg-white rounded-md">
    <div class="w-36 min-h-[320px] md:w-48 md:min-h-[320px] rounded-md shadow-md flex flex-col">
        <img src="{{ $product->image }}" alt="{{ $product->name }}"
             class="h-36 md:h-48 rounded-t-md w-full object-cover"/>
        <div class="m-2 flex flex-col gap-0.5">
            <div class="text-md">
                {{ $product->name }}
                {{--                {{ substr($product->name, 0, 19) . (strlen($product->name) > 19 ? '...' : '') }}--}}
            </div>
            <div class="text-md">
                <div class="font-bold">
                    Rp{{ formatPrice($product->price) }}
                </div>
                {{-- Rp{{$product->price}} --}}
            </div>
            <div class="text-xs text-gray-500">
                {{ $product->Merchant->Location[0]->city }}
            </div>
            <div class="flex flex-ro place-items-center gap-1 text-xs text-gray-500">
                {{-- SVG and Ratings Here --}}
                {{ $product->reviews->count() }} | {{ $product->sold }} terjual
            </div>
        </div>
    </div>
</a>


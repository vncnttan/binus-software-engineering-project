<div class="flex flex-col p-12 place-items-center gap-8">
    <div class="font-bold text-xl">Select Shipment Address</div>

    <div class="flex flex-col gap-2">
        @foreach($user->location as $loc)
            <div wire:click="selectLocation('{{ $loc->id }}')" class="w-full h-44">
                <div
                    class="{{ $loc->id == $selected_location_id ? 'border-indigo-600 bg-indigo-50' : 'border-gray-600'}} hover:bg-indigo-100 border-[1px] rounded-lg h-full w-full flex flex-col py-5 px-6 justify-between relative">
                    <div class="flex flex-col">
                        <div class="font-bold">
                            {{ $user->username }}
                        </div>
                        <div>
                            {{ $loc->city }}, {{$loc->country}}
                        </div>
                        <div>
                            {{ $loc->address }}, {{ $loc->postal_code }}
                        </div>
                        <div>
                            {{ $loc->notes }}
                        </div>
                    </div>

                </div>
            </div>

        @endforeach
    </div>
</div>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        </h2>
    </x-slot>

    <div class="py-12  relative" x-data="{ itemlist: [], differ: false }"  >
        <div id="blocker" class="bg-stone-100/10 w-full h-full absolute top-0 right-0 " x-show="{{ Auth::user()?'true':'false' }}"></div>
        <form method="POST" action="{{ route('store') }}"
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 grid-rows-1 gap-x-2 min-h-screen">
            @csrf @method('POST')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-2 row-span-1 ">
                <div class="p-6 text-gray-900 w-full grid  grid-cols-3  gap-3 ">
                    @forelse (App\Models\Product::all() as $item)
                        <div class=" col-span-1 h-56 grid grid-rows-4 bg-stone-100 rounded-lg border-2 border-black p-1">
                            <img src="" alt="" class="bg-slate-200 row-span-1">
                            <p class="row-span-2 flex-1 ">
                                {{ $item->ProductName }}
                                <br>
                                {{ $item->Price }}
                            </p>
                            <input type="checkbox" name="items[]" value="{{ $item->id }}" id=""
                                class="row-span-1 col-span-1">
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-1 row-span-1">
                <div class="p-6 text-gray-900">



                    <label for="">
                        <span>Customer</span>
                        <div class="grid grid-cols-5">
                            <template x-if="!differ">
                                <select name="customer" class="rounded-l-full col-span-4">
                                    <option value="" selected disabled>select</option>

                                    @forelse (App\Models\Customer::all() as $customers)
                                        <option value="{{ $customers->id }}" >
                                            {{ $customers->CustomerName }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </template>
                            <template x-if="differ">
                                <input type="text" name="customer_name" class="rounded-full col-span-4"
                                    x-show="differ" placeholder="customer Name"></template>

                            <template x-if="differ">
                                <input type="text" name="customer_addres" class="rounded-full col-span-4"
                                    x-show="differ" placeholder="Addres">
                            </template>
                            <template x-if="differ">
                                <input type="text" name="customer_phone" class="rounded-l-full col-span-4"
                                    x-show="differ" placeholder="Phone Number">
                            </template>
                            <button type="button" class="rounded-r-full bg-yellow-200 col-span-1"
                            @click="differ=!differ" x-text="differ?'cancel':'new'"></button>
                        </div>
                    </label>

                    <button class="bg-green-500 col-span-1 w-full h-12 rounded-full ">Finish</button>
                </div>

        </form>

    </div>
    </div>
</x-app-layout>

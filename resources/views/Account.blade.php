<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account
        </h2>
    </x-slot>
    {{-- @dd($data) --}}
    <div class="py-12" x-data="{ Update: false, Create: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="flex-1 p-8" x-data="{ editform: {}, modal: false }">
                        <h1 class="text-3xl font-bold mb-6 text-stone-700">Account</h1>

                        <div class="bg-white p-6 rounded-xl shadow-md border border-stone-300" x-data="bookTable">
                            <div class="flex flex-row justify-between mb-6">
                                <div class="relative">
                                    <input type="text" x-model="search" @input="currentPage = 1"
                                        placeholder="Search by name / email / role"
                                        class="w-80 p-2 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-400 outline-none">
                                    <i class="fa fa-search absolute left-3 top-3 text-slate-400"></i>
                                </div>
                                <button @click="modal=true;Create=true;Update=false"
                                    class="rounded-lg px-6 py-2 bg-sky-500 text-white font-bold hover:bg-sky-600 transition shadow-md">
                                    + Create
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="table-auto border-collapse w-full">
                                    <thead>
                                        <tr class="bg-sky-100">
                                            <th class="p-3 text-left border-b w-16">ID</th>
                                            <th class="p-3 text-left border-b">User name</th>
                                            <th class="p-3 text-left border-b">email</th>
                                            <th class="p-3 text-left border-b w-20">role</th>
                                            <th class="p-3 text-center border-b w-40">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(book, index) in paginatedBooks" :key="index">
                                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                                <td class="p-3 text-stone-500"
                                                    x-text="((currentPage - 1) * pageSize) + index + 1"></td>
                                                <td class="p-3 font-semibold" x-text="book.name"></td>
                                                <td class="p-3 text-stone-500 italic text-sm" x-text="book.email"></td>
                                                <td class="p-3 text-stone-600" x-text="book.role"></td>
                                                <td class="p-3">
                                                    <div class="flex gap-2 justify-center">
                                                        <button
                                                            @click="modal=true;Update=true;Create=false; editform={...book}"
                                                            class="bg-yellow-400 hover:bg-yellow-500 px-4 py-1 rounded-lg text-xs font-bold transition">EDIT</button>
                                                        <form action="{{ route('account.delete2') }}" method="POST">
                                                            @method('POST') @csrf
                                                            <input type="hidden" name="id" x-model="book.id">
                                                            <button
                                                                class="bg-red-500 hover:bg-red-600 px-4 py-1 rounded-lg text-xs font-bold text-white transition">DELETE</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-between items-center bg-slate-50 p-3 rounded-lg">
                                <span class="text-sm text-gray-600"
                                    x-text="`Showing ${paginatedBooks.length} of ${filteredBooks.length} entries` "></span>
                                <div class="flex gap-2">
                                    <button @click="currentPage--" :disabled="currentPage === 1"
                                        class="px-4 py-1 border bg-white rounded-md disabled:opacity-30 hover:bg-slate-100 transition">Prev</button>
                                    <button @click="currentPage++" :disabled="currentPage === totalPages"
                                        class="px-4 py-1 border bg-white rounded-md disabled:opacity-30 hover:bg-slate-100 transition">Next</button>
                                </div>
                            </div>
                        </div>

                        <div x-show="modal"
                            class="fixed inset-0 bg-stone-900/50 backdrop-blur-sm z-50 flex justify-center items-center"
                            x-transition>
                            <div class="bg-white w-[450px] p-6 rounded-2xl shadow-2xl border-2 border-sky-400"
                                @click.away="modal=false">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-2xl font-bold text-stone-800">Edit Book Data</h2>
                                    <button @click="modal=false"
                                        class="text-stone-400 hover:text-red-500 text-2xl">&times;</button>
                                </div>
                                <form action="{{ route('account.update2') }}" method="POST" x-show="Update"
                                    id="UpdateModal">
                                    @csrf
                                    @method('POST')
                                    <div class="space-y-4">
                                        <input type="hidden" name="id" x-model="editform.id">
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">name</label>
                                            <input type="text" x-model="editform.name" name="name"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">role</label>
                                            <select x-model="editform.role" name="role"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none h-24">
                                                <option value="admin">admin</option>
                                                <option value="worker">worker</option>
                                                <option value="" selected disabled>select role</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">email</label>
                                            <input type="email" x-model="editform.email" name="email"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">password</label>
                                            <input type="password" x-model="editform.password" name="password"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                                        </div>
                                    </div>

                                    <div class="flex gap-3 mt-8">
                                        <button @click="modal=false;Update=false;Create=false" type="submit"
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-lg transition shadow-md">SAVE
                                            CHANGES</button>
                                        <button @click="modal=false;Update=false;Create=false" type="reset"
                                            class="flex-1 bg-stone-200 hover:bg-stone-300 text-stone-700 font-bold py-2 rounded-lg transition">CANCEL</button>
                                    </div>
                                </form>

                                <form action="{{ route('account.store') }}" method="POST" x-show="Create"
                                    id="CreateModal">
                                    @csrf
                                    @method('POST')
                                    <div class="space-y-4">
                                        <input type="hidden" name="id" x-model="editform.id">
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">name</label>
                                            <input type="text" name="name" placeholder="amat..."
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">role</label>
                                            <select x-model="editform.role" name="role"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none h-24">
                                                <option value="admin">admin</option>
                                                <option value="worker">worker</option>
                                                <option value="" selected disabled>select role</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">email</label>
                                            <input type="email" name="email" placeholder="apalah@gmail.com"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-stone-700 mb-1">password</label>
                                            <input type="password" x-model="editform.password" name="password"
                                                class="w-full p-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                                        </div>
                                    </div>

                                    <div class="flex gap-3 mt-8">
                                        <button @click="modal=false;Update=false;Create=false" type="submit"
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-lg transition shadow-md">SAVE
                                            CHANGES</button>
                                        <button @click="modal=false;Update=false;Create=false" type="reset"
                                            class="flex-1 bg-stone-200 hover:bg-stone-300 text-stone-700 font-bold py-2 rounded-lg transition">CANCEL</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    </main>

                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('bookTable', () => ({
                                search: '',
                                currentPage: 1,
                                pageSize: 5,
                                allBooks: @json($data),

                                get filteredBooks() {
                                    if (!this.search) return this.allBooks;
                                    return this.allBooks.filter(book =>
                                        book.name.toLowerCase().includes(this.search.toLowerCase()) ||
                                        book.role.toLowerCase().includes(this.search.toLowerCase()) ||
                                        book.email.toLowerCase().includes(this.search.toLowerCase())
                                    );
                                },

                                get paginatedBooks() {
                                    let start = (this.currentPage - 1) * this.pageSize;
                                    return this.filteredBooks.slice(start, start + this.pageSize);
                                },

                                get totalPages() {
                                    return Math.ceil(this.filteredBooks.length / this.pageSize);
                                },
                            }))
                        })
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

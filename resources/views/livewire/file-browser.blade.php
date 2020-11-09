<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div>
                <div class="flex flex-wrap items-center justify-between mb-4">
                    <div class="flex-grow mr-0 mt-4 md:mt-2 w-full md:w=auto order-3 md-order-1">
                        <input type="search" placeholder="Search files and folders" class="w-full px-3 h-12 border-2 rounded-lg outline-none">
                    </div>
                    <div class="order-2">
                        <div>
                            <button class="bg-gray-200 px-6 h-12 rounded-lg mr-2">
                                New folder
                            </button>
                            <button class="bg-blue-600 text-white px-6 h-12 rounded-lg mr-2 font-bold">
                                Upload files
                            </button>
                        </div>
                    </div>
                </div>
                <div class="border-2 border-gray-200 rounded-lg">
                    <div class="py-2 px-3">
                        <div class="flex items-center">
                            <a href="" class="font-bold text-gray-400">Breadcrumb</a>
                            <svg class="mx-1 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="overflow-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left py-2 px-3">Name</th>
                                <th class="text-left py-2 px-3 w-2/12">Size</th>
                                <th class="text-left py-2 px-3 w-3/12">Created</th>
                                <th class="p-2 w-2/12"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($object->children as $child)
                                <tr class="border-b-2 border-gray-100 hover:bg-gray-100">
                                <td class="flex items-center py-2 px-3">
                                    @if($child->isFile())
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <a href="#" class="p-2 font-bold text-blue-700 flex-grow">
                                            {{ $child->objectable->name }}
                                        </a>
                                    @endif
                                    @if($child->isFolder())
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-700" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                        </svg>
                                        <a href="{{ route('files', ['uuid' => $child->uuid]) }}" class="p-2 font-bold text-blue-700 flex-grow">
                                            {{ $child->objectable->name }}
                                        </a>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($child->isFile())
                                        {{ $child->objectable->size }}
                                    @else
                                        &mdash;
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    {{ $child->created_at }}
                                </td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center justify-end">
                                        <ul class="flex items-center">
                                            <li class="mr-2">
                                                <button class="text-gray-400 font-bold">Rename</button>
                                            </li>
                                            <li class="mr-2">
                                                <button class="text-red-400 font-bold">Delete</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr class="border-b-2 border-gray-100 hover:bg-gray-100">
                                    <td class="py-2 px-3">
                                        this folder is empty
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
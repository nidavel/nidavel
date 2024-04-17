<?php
$i = 0;
?>

<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                    <path d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 00-3-3h-3.879a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H6a3 3 0 00-3 3v3.162A3.756 3.756 0 014.094 9h15.812zM4.094 10.5a2.25 2.25 0 00-2.227 2.568l.857 6A2.25 2.25 0 004.951 21H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-2.227-2.568H4.094z" />
                </svg>
            </div>
            <span class="flex gap-4 items-center">
                <h2 class="font-black text-black inline-block">Exports >> {{ $subtitle }}</h2>
            </span>
        </div>

        <div class="flex flex-col gap-8">
            <div>
                <p class="font-bold text-lg">Control your exports</p>
            </div>

            <div class="flex flex-wrap gap-16">
                <div class="flex flex-col gap-4">
                    <div class="sub-list">
                        <span class="text-blue-500"><a href="/dashboard?route=exports/all/posts">Posts</a></span>
                        <span class="text-gray-300">|</span>
                        <span class="text-blue-500"><a href="/dashboard?route=exports/all/homepage">Homepage</a></span>
                        <span class="text-gray-300">|</span>
                        <span class="text-blue-500"><a href="/dashboard?route=exports/all/pages">Pages</a></span>
                        <span class="text-gray-300">|</span>
                        {{-- <span class="text-blue-500"><a href="/dashboard?route=exports/all/authors">Authors</a></span>
                        <span class="text-gray-300">|</span>
                        <span class="text-blue-500"><a href="/dashboard?route=exports/all/author-posts">Author's posts</a></span> --}}

                        <span class="sub-list-btn text-sm">
                            <form method="POST" action="/exports/clear-orphaned">
                                <label>
                                    <input type="submit" value="Clear orphaned exports" class="border border-red-500 text-red-500 rounded-lg p-2 cursor-pointer" />
                                </label>
                            </form>
                        </span>
                    </div>

                    <div class="w-full overflow-x-auto border shadow">
                        @if (count($exports) == 0)
                            Empty. Nothing to see here.
                        @else
                            <table class="w-full border-collapse bg-white text-left text-sm text-gray-700">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">#</th>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Export</th>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($exports as $export)
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-6 py-4 text-gray-500">{{ ++$i }}</a></td>

                                        <td class="px-6 py-4 text-blue-500">{{ $export }}</a></td>
                                        
                                        <td class="px-6 py-4">
                                            <form onsubmit="return deleteExport()" method="post" action="/exports/delete/{{$export}}">
                                                @method('delete')
                                                <input type="hidden" name="subdirectory" value="{{strtolower($subtitle)}}">
                                                <input id="delete_{{rtrim($export, '.html')}}" class="hidden" type="submit">
                                            </form>
                                            <label for="delete_{{rtrim($export, '.html')}}" class="inline-block text-red-500 cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                                </svg>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function deleteExport()
{
    let conf = confirm("Warning!\n\nYou are about to delete an export.\nThis action is not reversible.");
    return conf;
}

</script>

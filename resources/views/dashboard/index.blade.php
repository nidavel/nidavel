<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                    <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                </svg>
            </div>
            <h2 class="font-black text-black">Dashboard Home</h2>
        </div>

        {{-- Overview --}}
        <div class="">
            <div class="flex flex-col gap-4">
                <div>
                    <h3 class="font-bold inline-block">Overview</h3>
                </div>
                <div class="flex w-full justify-between flex-wrap gap-4 text-white">
                    <div class="flex flex-col justify-between gap-4 p-8 w-full sm:w-56 md:w-64 lg:w-[30%] bg-gradient-to-br from-red-400 via-purple-400 to-orange-400 shadow">
                        <div class="flex justify-between items-center">
                            <p class="text-xl">Posts</p>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-7xl font-bold">
                            {{ $postCount }}
                        </div>
                    </div>

                    <div class="flex flex-col justify-between gap-4 p-8 w-full sm:w-56 md:w-64 lg:w-[30%] bg-gradient-to-br from-blue-400 via-cyan-400 to-green-400 shadow">
                        <div class="flex justify-between items-center">
                            <p class="text-xl">Pages</p>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M15.75 8.25a.75.75 0 01.75.75c0 1.12-.492 2.126-1.27 2.812a.75.75 0 11-.992-1.124A2.243 2.243 0 0015 9a.75.75 0 01.75-.75z" />
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM4.575 15.6a8.25 8.25 0 009.348 4.425 1.966 1.966 0 00-1.84-1.275.983.983 0 01-.97-.822l-.073-.437c-.094-.565.25-1.11.8-1.267l.99-.282c.427-.123.783-.418.982-.816l.036-.073a1.453 1.453 0 012.328-.377L16.5 15h.628a2.25 2.25 0 011.983 1.186 8.25 8.25 0 00-6.345-12.4c.044.262.18.503.389.676l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.575 15.6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-7xl font-bold">
                            {{ $pageCount }}
                        </div>
                    </div>

                    <div class="flex flex-col justify-between gap-4 p-8 w-full sm:w-56 md:w-64 lg:w-[30%] bg-gradient-to-br from-lime-400 via-fuschia-400 to-pink-400 shadow">
                        <div class="flex justify-between items-center">
                            <p class="text-xl">Exports</p>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 00-3-3h-3.879a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H6a3 3 0 00-3 3v3.162A3.756 3.756 0 014.094 9h15.812zM4.094 10.5a2.25 2.25 0 00-2.227 2.568l.857 6A2.25 2.25 0 004.951 21H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-2.227-2.568H4.094z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-7xl font-bold">
                            {{ $exportCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Posts --}}
        <div class="flex flex-col gap-4 p-8 bg-white shadow">
            <span><h3 class="font-bold inline-block">Recent posts and pages</h3> :: <a class="underline" href="/dashboard?route=posts/all">See all posts</a></span>
            <div class="flex flex-wrap gap-4">
            @foreach ($posts as $post)
                <div class="border w-full sm:w-[46%] md:w-56 shadow">
                    <div class="w-full h-full flex flex-col gap-2">
                        {{-- Post featured image --}}
                        <div class="w-full h-32 sm:h-32 md:h-40 overflow-hidden">
                            <img src="<?= $post->featured_image != null
                                            ? asset('my_exports/uploads/' . $post->featured_image)
                                            : asset('my_exports/uploads/images/post_default_image.png') ?>"
                            style="width: 100%; height: 100%; object-position: center; object-fit: cover;" />
                        </div>

                        {{-- Post body --}}
                        <div class="px-4 flex flex-col gap-2">
                            {{-- Post title --}}
                            <div class="text-sm font-bold">
                                <p>{{ $post->title }}</p>
                            </div>

                            {{-- Post actions --}}
                            <div class="flex gap-4 flex-wrap text-sm pb-4">
                                <span>
                                    Status: {{ $post->status }} | 
                                    <?= $post->status === 'published'
                                        ? '<a target="_blank" class="font-bold text-xs text-blue-500" href="/posts/'.$post->id.'">View post</a>'
                                        : '<a class="font-bold text-xs text-blue-500" href="/dashboard?route=posts/edit/'.$post->id.'">Edit post</a>'
                                    ?>
                                </span>

                                {{-- Some action icons --}}
                                {{-- <div class="flex justify-between items-center">
                                    <span>
                                        
                                    </span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
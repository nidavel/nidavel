
<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                    <path d="M19.906 9c.382 0 .749.057 1.094.162V9a3 3 0 00-3-3h-3.879a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H6a3 3 0 00-3 3v3.162A3.756 3.756 0 014.094 9h15.812zM4.094 10.5a2.25 2.25 0 00-2.227 2.568l.857 6A2.25 2.25 0 004.951 21H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-2.227-2.568H4.094z" />
                </svg>
            </div>
            <span class="flex gap-4 items-center"><h2 class="font-black text-black inline-block">{{ $subtitle ?? '' }}</h2>
                <span class="inline-block px-2 py-1 border bg-gray-50 border-blue-400 text-blue-500 transition duration-400 rounded-lg cursor-pointer" onclick="toggleAddMedia()">
                    Add {{ rtrim(strtolower($subtitle), 's') }}
                </span>
            </span>
        </div>

        <div class="flex flex-col gap-4">
            <div class="sub-list">
                <span class="text-blue-500"><a href="/dashboard?route=media/all/images">Images</a></span>
                <span class="text-gray-300">|</span>
                <span class="text-blue-500"><a href="/dashboard?route=media/all/audios">Audios</a></span>
                <span class="text-gray-300">|</span>
                <span class="text-blue-500"><a href="/dashboard?route=media/all/videos">Videos</a></span>
                {{-- <span class="justify-self-end ml-auto hidden lg:inline-block">
                    <form method="GET">
                        @csrf
                        <input type="search" placeholder="Search posts" class="shadow border-gray-300"/>
                        <input type="submit" value="Search" class="border border-gray-300 hover:border-gray-400 p-2 cursor-pointer shadow" />
                    </form>
                </span> --}}
            </div>
            <div class="w-full">
                @if (count($media) == 0)
                    Empty. Nothing to see here.
                @else
                    <div class="flex gap-8 flex-wrap">
                    @foreach ($media as $medium)
                        @if ($medium == 'post_default_image.png')
                            @continue
                        @endif
                        <div class="media-img-container" title="{{$medium}}">
                            <object
                             width="100%"
                             height="100%"
                             data="/uploads/{{$subtitle}}/{{$medium}}"
                             style="width: 100%; height: 100%; object-position: center; object-fit: cover;"
                             >
                            </object>
                            <div class="media-img-container-options">
                                <div class="flex items-center justify-around w-full">
                                    <div class="inline-block cursor-pointer" title="Preview {{rtrim(strtolower($subtitle), 's')}}: {{$medium}}" onclick="previewMedia(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="blue" data-slot="icon" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </div>

                                    <div class="inline-block cursor-pointer" title="Copy link to clipboard" onclick="copyMedia(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="black" data-slot="icon" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    </div>

                                    <input type="hidden" name="" value="/uploads/{{$subtitle}}/{{$medium}}">

                                    <div class="inline-block cursor-pointer" title="Remove {{$medium}} from storage" onclick="removeMedia(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" data-slot="icon" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Add media form --}}

<div class="media-preview-backdrop hidden" id="add_media">
    <div class="z-50">
        <div class="absolute inline-block ml-auto top-20 right-10 text-gray-200 cursor-pointer" onclick="toggleAddMedia()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </div>

        <div class="media-preview-object">
            <form action="/media/add" method="post" enctype="multipart/form-data">
                <input type="hidden" name="media_type" value="{{ strtolower($subtitle) }}">

                <input
                 type="file"
                 name="files[]"
                 accept="{{ rtrim(strtolower($subtitle), 's') }}/*"
                 multiple
                 >

                <button type="submit">Done</button>
            </form>
        </div>
    </div>
</div>

{{-- Toggle preview --}}

<div class="media-preview-backdrop hidden" id="preview">
    <div class="z-50">
        <div class="absolute inline-block ml-auto top-20 right-10 text-gray-200 cursor-pointer" onclick="togglePreview()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </div>

        <div class="media-preview-object">
            <object
             width="100%"
             height="auto"
             data=""
             style="width: 100%; height: 100%; object-position: center; object-fit: cover;"
             >
            </object>
        </div>
    </div>
</div>

<script>

    var showPreview = false;
    var showAddMedia = false;

    document.addEventListener('keydown', (e) => {
        if (e.keyCode === 27) {
            if (showPreview === true) {
                togglePreview();
            }
            if (showAddMedia === true) {
                toggleAddMedia();
            }
        } else {
            return;
        }
    });

    function toggleAddMedia()
    {
        showAddMedia = !showAddMedia;
        let media = document.querySelector('#add_media');
        media.classList.toggle('flex');
        media.classList.toggle('hidden');
    }

    function copyMedia(e)
    {
        let text = e.nextElementSibling;
        navigator.clipboard.writeText(text.value);
    }

    function previewMedia(e)
    {
        let data = e.nextElementSibling.nextElementSibling.value;
        let preview = document.querySelector('#preview');
        preview = preview.getElementsByTagName('object')[0];
        preview.data = data;
        togglePreview();
    }

    function togglePreview()
    {
        showPreview = !showPreview;
        let preview = document.querySelector('#preview');
        preview.classList.toggle('flex');
        preview.classList.toggle('hidden');
    }

    function removeMedia(e)
    {
        let val = e.previousElementSibling;
        let origin = window.location.origin;
        let remove = confirm("Removing this media may cause some broken links on live site. Are you sure you want to continue? \nThis action is not reversible.");

        if (remove === false) {
            return;
        }

        val = val.value;

        fetch(`${origin}/media/delete`, {
            method: "DELETE",
            body: val
        })
        .then((res) => {
            if (res.ok) {
                return res.json();
            } else {
                // 
            }
        })
        .then((data)        => {
            window.location.reload();
        });
    }

</script>

<main>
    <div class="flex flex-col gap-8">
        {{-- Post title --}}
        <div class="">
            <h1 class="text-4xl font-bold text-black">{{ $post->title }}</h1>
        </div>

        {{-- Post meta --}}
        <div class="text-xs">
            <p>By <a class="link" href="">{{ $post->author }}</a> | On {{ date('l jS F Y, h:ia', strtotime($post->updated_at)) }}</p>
        </div>

        {{-- Post content --}}
        <div class="flex flex-col gap-4">
            {!! $post->content !!}
        </div>
    </div>
</main>
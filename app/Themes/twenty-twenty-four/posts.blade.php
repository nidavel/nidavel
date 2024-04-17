
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
        <link rel="stylesheet" href="{{ homeUrl('/assets/css/style.css', 1) }}">
        <script type="text/javascript" src="{{ homeUrl('/assets/js/script.js', 1) }}" defer></script>
        <title>{{ settings('r', "general.name", "Nidavel") }} | Home</title>
    </head>

    <body>
        <div class="">
            {{-- Nav --}}
            <div>
                @include('front.parts.nav')
                <div class="header-img">
                    <img src="{{ homeUrl("/assets/img/pexels--931887.jpg", 0) }}"
                    style="width: 100%; height: 100%; object-position: center; object-fit: cover;"
                    alt="Header Image" />
                </div>
            </div>

            <div class="flex flex-col gap-16">
                {{-- Main section --}}
                <div class="body-margin">
                    <div class="flex flex-wrap gap-16 justify-between mt-16">
                        {{-- Post content --}}
                        <div class="posts-list">
                            @foreach ($posts as $post)
                                <div class="post-container">
                                    {{-- Featured image --}}
                                    <div class="post-list-img">
                                        <img src="<?= $post->featured_image != null
                                            ? asset('/uploads/' . $post->featured_image)
                                            : asset('/uploads/images/post_default_image.png') ?>"
                                            style="width: 100%; height: 100%; object-position: center; object-fit: cover;" />
                                    </div>
                                    <div class="post-list-body">
                                        <div class="post-title">
                                            <h4>{{ $post->title}}</h4>
                                        </div>
                                        <div class="post-desc">
                                            <p><?= $post->description != null
                                                ? substr($post->description, 0, 75)
                                                : substr($post->content, 0, 75) ?>
                                            </p>
                                        </div>
                                        <div class="post-list-footer-sm">
                                            <a class="md:hidden" href="{{ exportLink("/posts/$post->link") }}"><span>Read</span></a>
                                        </div>
                                    </div>
                                    <div class="hidden md:flex post-list-footer">
                                        <a href="{{ exportLink("/posts/$post->link") }}"><span>Read</span></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Sidebar --}}
                        <div class="sidebar">
                            @include('front.parts.sidebar')
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div>
                    @include('front.parts.footer')
                </div>
            </div>
        </div>
    </body>
</html>

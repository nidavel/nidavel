@php
    $menus = getMenu();
@endphp

<nav class="nav">
    <div class="body-margin">
        <div class="flex justify-between items-center h-24">
            <div>
                <a href="{{ homeUrl() }}" class="font-bold link text-xl uppercase">{{ settings('r', 'general.name') }}</a>
            </div>

            <div>
                <ul class="menu-bar">
                    @foreach ($menus as $menu)
                        <li class="menu-item">{!! $menu !!}</li>
                    @endforeach
                </ul>
                <div class="menu-mobile-btn" onclick="handleNav()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</nav>

<button id="show_nav" class="hidden" type="button" onclick="handleNav()"></button>

<label id="label_nav_collapsed" for="show_nav" class="fixed w-full h-full bg-black z-40 opacity-70 transition duration-300 ease-in-out delay-500"></label>
<div id="nav_collapsed" class="fixed nav-collapse">
    <div class="flex flex-col gap-8">
        <div class="nav-collapsed-header">
            <a class="font-bold text-primary-color" href="{{ homeUrl() }}"><h2>{{ settings('r', 'general.name') }}</h2></a>
            <label class="cursor-pointer" for="show_nav">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" view-box="0 0 24 24" stroke-width="1.5" stroke="white" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </label>
        </div>

        <ul class="flex flex-col gap-4 items-start">
            @foreach ($menus as $menu)
                <li class="menu-item-mobile">{!! $menu !!}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="h-24"></div>

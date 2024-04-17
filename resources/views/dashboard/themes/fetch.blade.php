<?php
$activeTheme = getActiveTheme();
?>

<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M20.599 1.5c-.376 0-.743.111-1.055.32l-5.08 3.385a18.747 18.747 0 00-3.471 2.987 10.04 10.04 0 014.815 4.815 18.748 18.748 0 002.987-3.472l3.386-5.079A1.902 1.902 0 0020.599 1.5zm-8.3 14.025a18.76 18.76 0 001.896-1.207 8.026 8.026 0 00-4.513-4.513A18.75 18.75 0 008.475 11.7l-.278.5a5.26 5.26 0 013.601 3.602l.502-.278zM6.75 13.5A3.75 3.75 0 003 17.25a1.5 1.5 0 01-1.601 1.497.75.75 0 00-.7 1.123 5.25 5.25 0 009.8-2.62 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="flex gap-4 items-center">
                <h2 class="font-black text-black inline-block">Themes</h2>
            </span>
        </div>

        <div class="flex flex-col gap-8">
            <div class="flex gap-8 items-center">
                <p class="font-bold text-lg">Choose theme</p>

                <div>
                    <form id="theme_search_form">
                        <div class="flex gap-2 items-center">
                            <label class="flex gap-4 items-center">
                                {{-- <p>Search themes</p> --}}
                                <input id="q" class="menu-text-input" type="text" placeholder="Search themes">
                            </label>
                            <button type="submit" class="bg-blue-500 text-white rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex flex-wrap gap-16" id="themes_list">
                @foreach ($themes as $theme)
                    @if ($theme->name === $activeTheme)
                        @continue
                    @endif
                    <div class="theme-container">
                        <div class="theme-img-container">
                            <img
                             style="width: 100%; height: 100%; object-position: center; object-fit: cover;"
                             src="{{$theme->img_url}}"
                             alt="{{$theme->name}}">
                        </div>
                        <div class="theme-name-container">
                            <span>{{ucFirst(dashToSpace($theme->name))}}</span>
                            <span class="theme-activate-container">
                                <a href="/themes/download/?theme_name={{$theme->name}}&theme_url={{$theme->url}}&theme_version={{$theme->version}}">Download</a>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>

let searchForm = document.querySelector('#theme_search_form');
let themesList = document.querySelector('#themes_list');
let queryInput = document.querySelector('#q');
var themeContainer = '';
var timer;
searchForm.onsubmit = (e) => {
    e.preventDefault();
    themesList.innerHTML = '';
    fetchTheme(queryInput.value);
}

queryInput.onkeyup = (e) => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        if (queryInput.value.length == '') {
            themesList.innerHTML = '';
            fetchTheme(`http://localhost:5000/api/v0/free`, true);
        }
        else if (queryInput.value.length < 3) {
            return;
        } else {
            themesList.innerHTML = '';
            fetchTheme(queryInput.value);
        }
    }, 2000)
}

function fetchTheme(themeQuery, fullUrl = false)
{
    let url = '';
    if (fullUrl === false) {
        url = `http://localhost:5000/api/v0/search-free/${themeQuery}`;
    } else {
        url = themeQuery;
    }

    fetch(url)
    .then((res) => res.json())
    .then((data) => {
        data.data.map((theme) => {
            themeContainer = `<div class="theme-container">`;
            themeContainer += `<div class="theme-img-container">`;
            themeContainer += `<img style="width: 100%; height: 100%; object-position: center; object-fit: cover;"`;
            themeContainer += ` src="${theme.img_url}"`;
            themeContainer += ` alt="${theme.name}">`;
            themeContainer += `</div>`;
            themeContainer += `<div class="theme-name-container">`;
            themeContainer += `<span>${theme.name}</span>`;
            themeContainer += `<span class="theme-activate-container">`;
            themeContainer += `<a href="/themes/download/?theme_name=${theme.name}&theme_url=${theme.url}&theme_version=${theme.version}">Download</a>`;
            themeContainer += `</span>`;
            themeContainer += `</div>`;
            themeContainer += `</div>`;

            themesList.innerHTML += themeContainer;
        })
    });
}

</script>

<?php
$widgets = getWidgets();
$widgetAreas = getWidgetAreas();
?>

<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 01-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 016.126 3.537zM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 010 .75l-1.732 3.001c-.229.396-.76.498-1.067.16A5.231 5.231 0 016.75 12c0-1.362.519-2.603 1.37-3.536zM10.878 17.13c-.447-.097-.623-.608-.394-1.003l1.733-3.003a.75.75 0 01.65-.375h3.465c.457 0 .81.408.672.843a5.252 5.252 0 01-6.126 3.538z" />
                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 000-1.5h-.783a8.22 8.22 0 00-.237-1.357l.734-.267a.75.75 0 10-.513-1.41l-.735.268a8.24 8.24 0 00-.689-1.191l.6-.504a.75.75 0 10-.964-1.149l-.6.504a8.3 8.3 0 00-1.054-.885l.391-.678a.75.75 0 10-1.299-.75l-.39.677a8.188 8.188 0 00-1.295-.471l.136-.77a.75.75 0 00-1.477-.26l-.136.77a8.364 8.364 0 00-1.377 0l-.136-.77a.75.75 0 10-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 00-1.3.75l.392.678a8.29 8.29 0 00-1.054.885l-.6-.504a.75.75 0 00-.965 1.149l.6.503a8.243 8.243 0 00-.689 1.192L3.8 8.217a.75.75 0 10-.513 1.41l.735.267a8.222 8.222 0 00-.238 1.355h-.783a.75.75 0 000 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 10.513 1.41l.735-.268c.197.417.428.816.69 1.192l-.6.504a.75.75 0 10.963 1.149l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 101.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.771a.75.75 0 101.477.26l.137-.772a8.376 8.376 0 001.376 0l.136.773a.75.75 0 101.477-.26l-.136-.772a8.19 8.19 0 001.294-.47l.391.677a.75.75 0 101.3-.75l-.393-.679a8.282 8.282 0 001.054-.885l.601.504a.75.75 0 10.964-1.15l-.6-.503a8.24 8.24 0 00.69-1.191l.735.268a.75.75 0 10.512-1.41l-.734-.268c.115-.438.195-.892.237-1.356h.784zm-2.657-3.06a6.744 6.744 0 00-1.19-2.053 6.784 6.784 0 00-1.82-1.51A6.704 6.704 0 0012 5.25a6.801 6.801 0 00-1.225.111 6.7 6.7 0 00-2.15.792 6.784 6.784 0 00-2.952 3.489.758.758 0 01-.036.099A6.74 6.74 0 005.251 12a6.739 6.739 0 003.355 5.835l.01.006.01.005a6.706 6.706 0 002.203.802c.007 0 .014.002.021.004a6.792 6.792 0 002.301 0l.022-.004a6.707 6.707 0 002.228-.816 6.781 6.781 0 001.762-1.483l.009-.01.009-.012a6.744 6.744 0 001.18-2.064c.253-.708.39-1.47.39-2.264a6.74 6.74 0 00-.408-2.308z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="flex gap-4 items-center"><h2 class="font-black text-black inline-block">Widgets</h2>
                
            </span>
        </div>

        <div class="flex flex-col gap-8">
            <div>
                <p class="font-bold text-lg">Customize widgets</p>
            </div>

            <div class="widgets-customize-container">
                <div class="widgets-customize-list-widgets">
                    @if (!empty($widgets))
                        @foreach ($widgets as $widget => $props)
                            <div class="draggable cursor-grab" draggable="true">
                                <div>
                                    <span class="hidden">{{ $widget }}</span>
                                    <div class="flex flex-col gap-4 text-center bg-gray-300 border border-gray-400 w-64 py-2 rounded">
                                        <div class="widget-title">
                                            <div>{{ $widget }}</div>
                                            <div class="widget-chevron" onclick="handleWidgetShowOptions(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div id="widget_option_{{toSnakeCase(' ', $widget)}}" class="bg-gray-400 mx-4 mb-4 rounded p-4 collapsed">
                                            <form onsubmit="widgetSubmit(this)">
                                                    <input type="hidden" name="widget_name" value="{{$widget}}">
                                                    {{-- <input type="hidden" name="widget_title" value="{{$props['title']}}"> --}}
                                                    <input type="hidden" name="widget_body" value="{{$props['body']}}">

                                                    <div class="flex flex-col gap-4">
                                                        @if (!empty($props['options']))
                                                            <input type="hidden" name="props" value="Not empty">
                                                        <fieldset class="flex flex-col gap-4">
                                                            <legend>Options</legend>
                                                            @foreach ($props['options'] as $type => $label)
                                                            @php
                                                                $type = optionTypeIsAllowed($type) ? $type : 'text';
                                                            @endphp
                                                            <div class="flex flex-col gap-4">
                                                                <label class="text-sm text-left flex flex-col gap-1">
                                                                    <div>{{ $label }}</div>
                                                                    <div>
                                                                        <input class="widget-input" type="{{$type}}" name="{{toSnakeCase(' ', $label)}}" id="">
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                            <input class="hidden" id="{{toSnakeCase(' ', $widget)}}" type="submit" value="Done">
                                                        @endif
                                                        <div class="flex justify-end items-center">
                                                            <button type="button" onclick="removeWidgetNode(this)" class="widget-remove">Remove</button>
                                                        </div>
                                                    </div>
                                                    </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="widgets-customize-list-widget-areas">
                    @if (!empty($widgetAreas))
                        @foreach ($widgetAreas as $widgetArea)
                            <div class="widget-area {{spaceToDash($widgetArea)}} flex flex-col gap-4 border border-gray-400 p-4 rounded bg-gray-200">
                                <div class="flex flex-col gap-4">
                                    <div class="font-bold text-center">
                                        {{ ucFirst(dashToSpace($widgetArea)) }}
                                    </div>

                                    @php
                                        $activeWidgets = loadWidgets($widgetArea);
                                    @endphp

                                    @if (!empty($activeWidgets))
                                        @foreach ($activeWidgets as $activeWidget)
                                            <span class="hidden">{{ $activeWidget->name }}</span>
                                            <div class="flex flex-col gap-4 text-center bg-gray-300 border border-gray-400 w-64 py-2 rounded">
                                                <div class="widget-title">
                                                    <div>{{ $activeWidget->name }}</div>
                                                    <div class="widget-chevron" onclick="handleWidgetShowOptions(this)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div id="widget_option_{{toSnakeCase(' ', $activeWidget->name)}}" class="bg-gray-400 mx-4 mb-4 rounded p-4 collapsed hidden">
                                                    <form>
                                                            <input type="hidden" name="widget_name" value="{{$activeWidget->name}}">
                                                            {{-- <input type="hidden" name="widget_title" value="{{$activeWidget->title}}"> --}}
                                                            <input type="hidden" name="widget_body" value="{{$activeWidget->body}}">
            
                                                            @php
                                                                $props = getWidget($activeWidget->name);
                                                            @endphp
                                                            
                                                            <div class="flex flex-col gap-4">
                                                                @if (!empty($props['options']))
                                                                    <input type="hidden" name="props" value="Not empty">
                                                                <fieldset class="flex flex-col gap-4">
                                                                    <legend>Options</legend>
                                                                    @foreach ($props['options'] as $type => $label)
                                                                    @php
                                                                        $type = optionTypeIsAllowed($type) ? $type : 'text';
                                                                    @endphp
                                                                    <div class="flex flex-col gap-4">
                                                                        <label class="text-sm text-left flex flex-col gap-1">
                                                                            <div>{{ ucFirst($label) }}</div>
                                                                            <div>
                                                                                <input class="widget-input" type="{{$type}}" name="{{toSnakeCase(' ', $label)}}" id="" value="{{ getWidgetOption($widgetArea, $activeWidget->name, toSnakeCase(' ', $label))}}">
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                    @endforeach
                                                                @endif
                                                                <div class="flex justify-end items-center">
                                                                    <button type="button" onclick="removeWidgetNode(this)" class="widget-remove">Remove</button>
                                                                </div>
                                                            </div>
                                                            </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                            <span class="hidden widget-count"></span>
                                            {{--  --}}
                                        @endforeach
                                    @endif
                                </div>
                                    <div class="w-64 text-gray-500 italic text-center border border-2 border-dashed rounded border-gray-400 py-2 dropzone">Drag widgets here</div>
                                    <button type="button" class="widget-done" onclick="widgetAreaSubmit(this, '{{$widgetArea}}')">Done</button>
                            </div>
                        @endforeach                            
                    @else
                        <div>No widget area detected</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function handleWidgetShowOptions(e)
{
    let widgetNode = e.parentNode.nextElementSibling;
    widgetNode.classList.toggle("hidden");
}

function removeWidgetNode(e)
{
    let confirmation = confirm('Press OK to confirm delete. Otherwise press cancel');
    if (confirmation === false) {
        return;
    }

    let node        = e.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
    let parentNode  = node.parentNode;
    parentNode.removeChild(node);
}

function widgetAreaSubmit(e, theWidgetArea)
{
    e.disabled      = true;
    e.textContent   = 'Loading';
    e.classList.add('opacity-50');
    let widgetArea  = e.parentNode;
    let forms       = widgetArea.getElementsByTagName('form');

    let data = [];
    for (const form of forms) {
        let widgetData      = {};
        widgetData.name     = form.widget_name.value;
        // widgetData.title    = form.widget_title.value;
        widgetData.body     = form.widget_body.value;

        if (form.props != null) {
            let inputs  = form.querySelectorAll('input.widget-input');
            let options = [];
            for(const input of inputs) {
                let key         = input.name;
                let value       = input.value;
                let element     = {};
                element[key]    = value
                options.push(element);
            };
            widgetData.options = options
        } else {
            widgetData.options = null;
        }
        data.push(widgetData);
    }

    let finalData               = {};
    finalData[theWidgetArea]    = data;
    finalData                   = JSON.stringify(finalData);
    let origin                  = window.location.origin;

    fetch(`${origin}/widgets/set`, {
        method: "POST",
        body: finalData
    })
    .then((res) => {
        if (res.ok) {
            return res.json();
        } else {
            // 
        }
    })
    .then((data)        => {
        e.disabled      = false;
        e.textContent   = 'Done';
        e.classList.remove('opacity-50');
    });
}

document.body.addEventListener('dragstart', handleDragStart);
document.body.addEventListener('drop', handleDrop);
document.body.addEventListener('dragover', handleDragOver);
document.body.addEventListener('dragenter', handleDragEnter);
document.body.addEventListener('dragover', handleDragOver);
document.body.addEventListener('mousedown', handleMouseDown);
document.body.addEventListener('mouseup', handleMouseUp);

function handleDragStart(e) {
    let obj     = e.target;
    let data    = '';

    if (obj.classList.contains('draggable')) {
        data = obj.innerHTML;
        e.dataTransfer.setData('text/html', data);
    }
}

function handleDrop(e) {
    let obj     = e.target;
    let btn     = obj.nextElementSibling;
    let data    = '';

    if (obj.classList.contains('dropzone')) {
        e.preventDefault();
        let parentNode      = obj.parentNode;
        data                = e.dataTransfer.getData('text/html');

        let tempData        = data.trimStart();
        let needle          = tempData.substring(0, 64);
        let haystackNode    = parentNode;
        let haystack        = haystackNode.innerHTML;
        if (haystack.includes(needle)) {
            return;
        }

        parentNode.removeChild(obj);
        parentNode.removeChild(btn);
        parentNode.innerHTML += data;
        parentNode.appendChild(obj);
        parentNode.appendChild(btn);
    }
}

function handleDragOver(e)
{
    let obj = e.target;

    if (obj.classList.contains('dropzone')) {
        e.preventDefault();
    }
}

function handleDragEnter(e)
{
    let obj = e.target;

    if (obj.classList.contains('dropzone')) {
    }
}

function handleMouseDown(e)
{
    let obj = e.target;

    if (obj.classList.contains('draggable')) {
        obj.classList.remove('cursor-grab');
        obj.classList.add('cursor-grabbing');
    }
}

function handleMouseUp(e)
{
    let obj = e.target;

    if (obj.classList.contains('draggable')) {
        obj.classList.remove('cursor-grabbing');
        obj.classList.add('cursor-grab');
    }
}

</script>

<?php
$themeColor = settings('r', 'general.theme_color') ?? '#000000';

$customizableSelectors = getCustomizeableSelectors();
?>

<div class="flex flex-col gap-8">
    <div class="customize-each-container">
        <div class="font-bold">Theme color</div>

        <div>
            <form class="flex flex-col items-start gap-8" action="/customize-theme/set-theme-color" method="post">
                <label for="theme_color">
                    <div>Click the box to chose a color</div>
                    <input id="theme_color" class="w-8 h-8 border border-0 rounded cursor-pointer" type="color" name="theme_color" id="" value="{{ $themeColor }}">
                    <div id="theme_color_label">
                        {{--  --}}
                    </div>
                </label>
                
                <input class="customize-submit-btn" type="submit" value="Set theme color">
            </form>
        </div>
    </div>

    @foreach ($customizableSelectors as $name => $selectors)
        <div class="customize-each-container">

            <div class="font-bold flex gap-8">
                <input class="w-4 h-4 rounded-full" type="checkbox" {{ isStyleCustomized($name) == true ? 'checked' : '' }} id="" onchange="toggleName(this, '{{$name}}')">
                <div>{{ dashToSpace(ucFirst($name)) }}</div>
            </div>

            <form action="" method="post" class="flex flex-col gap-8 ml-4">
                <fieldset {{ isStyleCustomized($name) == true ? '' : 'disabled' }}>
                @foreach ($selectors as $selector => $properties)
                    <div class="flex flex-col mt-4">
                        <label class="mt-4 flex gap-4 items-center">
                            <input class="w-4 h-4 rounded-full" type="checkbox" id="" onchange="toggleProperty(this)">
                            <div>{{$selector}}</div>
                        </label>

                        <div>
                            <fieldset class="ml-4 mt-4 flex flex-col gap-4">
                                @foreach ($properties as $property)
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <input class="w-4 h-4 rounded-full" type="checkbox" name="{{"$name-$selector-$property"}}" id="" onchange="toggleProperty(this)">
                                        <div>{{$property}}</div>
                                    </div>

                                    <div class="px-8">
                                        <fieldset>
                                            <input type="hidden" name="selector" value="{{$selector}}">
                                            <div class="flex gap-4">
                                                <input type="hidden" name="name" value="{{$name}}">
                                            </div>
                                            <div class="flex flex-col gap-4">
                                                <div class="flex gap-8 justify-start items-start">
                                                    <div class="flex flex-col w-96 gap-8 justify-start">
                                                        <div class="flex gap-2">
                                                            <div>R</div>
                                                            <div>
                                                                <input class="" type="range" name="red" min="0" max="255" id="">
                                                            </div>
                                                        </div>

                                                        <div class="flex gap-2">
                                                            <div>G</div>
                                                            <div>
                                                                <input class="" type="range" name="green" min="0" max="255" id="">
                                                            </div>
                                                        </div>

                                                        <div class="flex gap-2">
                                                            <div>B</div>
                                                            <div>
                                                                <input class="" type="range" name="blue" min="0" max="255" id="">
                                                            </div>
                                                        </div>

                                                        <div class="flex gap-2">
                                                            <div>A</div>
                                                            <div>
                                                                <input class="" type="range" name="opacity" min="0" max="100" id="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-center w-32 h-32 rounded border" style="{{$property}}:{{getCustomizedPropertyValue($name."'".$selector."'".$property)}}">Sample text</div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    @if ($property !== end($properties))
                                        <hr class="border-gray-200">
                                    @endif
                                </div>
                                @endforeach
                            </fieldset>
                        </div>
                    </div>
                    @if ($selector !== end($selectors))
                        <hr class="border-gray-400">
                    @endif

                @endforeach
                </fieldset>
                <div>
                    <input class="customize-submit-btn" type="submit" value="Done">
                </div>
            </form>

        </div>
    @endforeach
</div>

<script>
let themeColorLabel = document.querySelector('#theme_color_label');
let themeColor = document.querySelector('#theme_color');
themeColorLabel.innerText = `Current color: ${themeColor.value}`;
themeColor.onchange = () => {
    themeColorLabel.innerText = `Current color: ${themeColor.value}`;
}

function toggleProperty(e)
{
    let input = e.parentElement.nextElementSibling;
    let fieldset = input.firstElementChild;
    
    if (e.checked == true) {
        fieldset.disabled = false;
    } else {
        fieldset.disabled = true;
    }
    // console.log(fieldset);
    
}

function toggleName(e, name)
{
    e.disabled = true;
    if (!e.checked) {
        fetch(`/customize-theme/remove-customized-style-name/${name}`)
        .then((res) => (res.ok))
        .then((data) => {
            if (data === true) {
                toggleProperty(e);
            }
        });
    } else {
        fetch(`/customize-theme/add-customized-style-name/${name}`)
        .then((res) => (res.ok))
        .then((data) => {
            if (data === true) {
                toggleProperty(e);
            }
        });
    }
    e.disabled = false;
}
</script>
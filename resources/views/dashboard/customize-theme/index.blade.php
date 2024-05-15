<?php
$themeColor = settings('r', 'general.theme_color') ?? '#000000';

$customizableSelectors = getCustomizeableSelectors() ?? [];
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
                            <input class="w-4 h-4 rounded-full" type="checkbox" id="" onchange="toggleProperty(this)" {{ isSelectorCustomized("$name'$selector") == true ? 'checked' : '' }}>
                            <div>{{$selector}}</div>
                        </label>

                        <div class="flex justify-start items-center gap-16 flex-wrap">
                            <fieldset class="ml-4 mt-4 flex flex-col gap-4" {{ isSelectorCustomized("$name'$selector") == true ? '' : 'disabled' }}>
                                @foreach ($properties as $property)
                                @php
                                $val = getCustomizedPropertyValue("$name'$selector'$property");
                                $r = 0; $g = 0; $b = 0; $a = 0;
                                if (strlen($val) > 10) {
                                    $r = getRedFromPropertyValue($val);
                                    $g = getGreenFromPropertyValue($val);
                                    $b = getBlueFromPropertyValue($val);
                                    $a = getAlphaFromPropertyValue($val);
                                }
                                @endphp
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <input class="w-4 h-4 rounded-full" type="checkbox" name="{{"$name-$selector-$property"}}" id="" onchange="toggleProperty(this)" {{ isPropertyCustomized("$name'$selector'$property") == true ? 'checked' : '' }}>
                                        <div>{{$property}}</div>
                                    </div>

                                    <div class="px-8">
                                        <fieldset {{ isPropertyCustomized("$name'$selector'$property") == true ? '' : 'disabled' }}>
                                            <input type="hidden" name="selector" value="{{$selector}}">
                                            <div class="flex gap-4">
                                                <input type="hidden" name="name" value="{{$name}}">
                                            </div>
                                            <div class="flex flex-col gap-4">
                                                <div class="flex gap-8 justify-start items-start">
                                                    <div class="flex w-full gap-8 justify-start flex-wrap">

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$r}}">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>R</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$r}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$g}}">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>G</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$g}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$b}}">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>B</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$b}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="100" name="" id="" value="{{$a}}">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>A</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="100" id="" value="{{$a}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="flex items-center justify-center w-32 h-32 rounded border" style="{{$property}}:{{getCustomizedPropertyValue($name."'".$selector."'".$property)}}">Sample text</div> --}}
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                @endforeach
                            </fieldset>
                            
                            <div class="flex items-center justify-center w-32 h-32 rounded border" style="
                                <?php
                                foreach ($properties as $property) {
                                    $getPropertyValue = '';
                                    $propertyValue = '';
                                    if (isPropertyCustomized("$name'$selector'$property")) {
                                        $getPropertyValue = $name;
                                        $getPropertyValue .= '\''.$selector;
                                        $getPropertyValue .= '\''.$property;
                                        $propertyValue = getCustomizedPropertyValue($getPropertyValue) ?? null;
                                        if (is_null($propertyValue)) {
                                            continue;
                                        }
                                        echo $property.':'.$propertyValue.';';
                                    }
                                }
                                ?>
                                ">Sample text
                            </div>
                        </div>
                        {{-- <div class="flex items-center justify-center w-32 h-32 rounded border" style="{{$property}}:{{getCustomizedPropertyValue($name."'".$selector."'".$property)}}">Sample text</div> --}}
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
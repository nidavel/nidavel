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

            <form action="" class="flex flex-col gap-8 ml-4" onsubmit="submitStyleForm(this, '{{$name}}');return false">
                <fieldset {{ isStyleCustomized($name) == true ? '' : 'disabled' }}>
                @foreach ($selectors as $selector => $properties)
                    <div class="flex flex-col mt-4">
                        <label class="mt-4 flex gap-4 items-center">
                            <input class="w-4 h-4 rounded-full" type="checkbox" id="" onchange="toggleProperty(this, 'selector')" {{ isSelectorCustomized("$name'$selector") == true ? 'checked' : '' }}>
                            <div>{{$selector}}</div>
                        </label>

                        <div class="flex justify-start items-center gap-16 flex-wrap">
                            <fieldset class="ml-4 mt-4 flex flex-col gap-4" {{ isSelectorCustomized("$name'$selector") == true ? '' : 'disabled' }}>
                                @foreach ($properties as $property)
                                @php
                                $val = getCustomizedPropertyValue("$name'$selector'$property");
                                $r = 0; $g = 0; $b = 0; $a = 0;
                                if (strlen($val) >= 7) {
                                    $r = (int) getRedFromPropertyValue($val);
                                    $g = (int) getGreenFromPropertyValue($val);
                                    $b = (int) getBlueFromPropertyValue($val);
                                    $a = (int) getAlphaFromPropertyValue($val);
                                }
                                @endphp
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <input class="w-4 h-4 rounded-full" type="checkbox" name="" id="" value="{{$property}}" onchange="toggleProperty(this)" {{ isPropertyCustomized("$name'$selector'$property") == true ? 'checked' : '' }}>
                                        <div>{{$property}}</div>
                                    </div>

                                    <div class="px-8">
                                        <fieldset {{ isPropertyCustomized("$name'$selector'$property") == true ? '' : 'disabled' }}>
                                            <div class="flex flex-col gap-4">
                                                <div class="flex gap-8 justify-start items-start">
                                                    <div class="flex w-full gap-8 justify-start flex-wrap">

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$r}}" oninput="updateSlider(this, '{{toCamel($property)}}', 0)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>R</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$r}}" oninput="updateInputAndDisplay(this, '{{toCamel($property)}}', 0)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$g}}" oninput="updateSlider(this, '{{toCamel($property)}}', 1)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>G</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$g}}" oninput="updateInputAndDisplay(this, '{{toCamel($property)}}', 1)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$b}}" oninput="updateSlider(this, '{{toCamel($property)}}', 2)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>B</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$b}}" oninput="updateInputAndDisplay(this, '{{toCamel($property)}}', 2)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="100" name="" id="" value="{{$a*100}}" oninput="updateSlider(this, '{{toCamel($property)}}', 3)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>A</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="100" id="" value="{{$a*100}}" oninput="updateInputAndDisplay(this, '{{toCamel($property)}}', 3)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                @endforeach
                            </fieldset>
                            
                            <input class="{{$name}} flex items-center justify-center w-32 h-32 rounded border focus:ring-0 shadow" style="
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
                                        echo $property.':'.parseRGBA($propertyValue).';';
                                    }
                                }
                                ?>"
                            name="{{$selector}}" value="Sample text" readonly {{ isSelectorCustomized("$name'$selector") == true ? '' : 'disabled' }}>
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

function toggleProperty(e, elem='property')
{
    let input = e.parentElement.nextElementSibling;
    let fieldset = input.firstElementChild;
    let display;
    switch (elem) {
        case 'selector':
            display = e.parentElement.parentElement.lastElementChild.lastElementChild;
            break;
        case 'property':
            display = e.parentElement.parentElement.parentElement.parentElement.lastElementChild;
            break;
        default:
            display = e.parentElement.parentElement.lastElementChild;
            break;
    }
    
    if (e.checked == true) {
        fieldset.disabled = false;
        if (elem == 'selector') {
            display.disabled = false;
        }
    } else {
        fieldset.disabled = true;
        display.style.cssText = removeInlineStyle(display.style.cssText, e.value);
        if (elem == 'selector') {
            display.disabled = true;
        }
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

function updateSlider(e, property, index)
{
    let slider = e.parentElement.nextElementSibling.lastElementChild.firstElementChild;
    slider.value = e.value;
    let display = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling;
    let oldRGB = display.style[property];
    let newRGB;
    
    
    oldRGB = splitRGBA(oldRGB);

    switch (index) {
        case 0:
            newRGB = combineValuesToRGBA(e.value, oldRGB[1], oldRGB[2], oldRGB[3] ? oldRGB[3] : '100')
            break;
        case 1:
            newRGB = combineValuesToRGBA(oldRGB[0], e.value, oldRGB[2], oldRGB[3] ? oldRGB[3] : '100');
            break;
        case 2:
            newRGB = combineValuesToRGBA(oldRGB[0], oldRGB[1], e.value, oldRGB[3] ? oldRGB[3] : '100');
            break;
        case 3:
            newRGB = combineValuesToRGBA(oldRGB[0], oldRGB[1], oldRGB[2] , `${e.value}`);
            break;
        default:
            newRGB = oldRGB;
    }
    display.style[property] = newRGB;
}

function updateInputAndDisplay(e, property, index)
{
    let input = e.parentElement.parentElement.previousElementSibling.firstElementChild;
    let display = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling;
    let oldRGB = display.style[property];
    let newRGB;
    
    input.value = e.value;
    
    oldRGB = splitRGBA(oldRGB);

    switch (index) {
        case 0:
            newRGB = combineValuesToRGBA(e.value, oldRGB[1], oldRGB[2], oldRGB[3] ? oldRGB[3] : '100')
            break;
        case 1:
            newRGB = combineValuesToRGBA(oldRGB[0], e.value, oldRGB[2], oldRGB[3] ? oldRGB[3] : '100');
            break;
        case 2:
            newRGB = combineValuesToRGBA(oldRGB[0], oldRGB[1], e.value, oldRGB[3] ? oldRGB[3] : '100');
            break;
        case 3:
            newRGB = combineValuesToRGBA(oldRGB[0], oldRGB[1], oldRGB[2] , `${e.value}`);
            break;
        default:
            newRGB = oldRGB;
    }
    display.style[property] = newRGB;
}

function combineValuesToRGBA(red, green, blue, alpha=100)
{
    let rgba = `rgba(${red}, ${green}, ${blue}, ${alpha/100})`;
    return rgba;
}

function splitRGBA(rgba)
{
    let leftParentheses = rgba.indexOf('(');
    let rightParentheses = rgba.indexOf(')');
    let placeValue = 1;
    let newRGBA = [0,0,0,0];
    let newRGBAIndex = 0;

    for (let x = leftParentheses + 1; x < rightParentheses; x++) {
        if (rgba[x] == ',') {
            placeValue = 1;
            newRGBAIndex++;
            continue;
        }
        newRGBA[newRGBAIndex] = (newRGBA[newRGBAIndex] * placeValue) + rgba[x];
        placeValue << 10;
    }
    return newRGBA;
}

function parseRGBA(rgba)
{
    if (rgba.substring(0, 4) === 'rgba') {
        return rgba;
    }

    rgba = rgba.replace('rgb', 'rgba');
    rgba = rgba.replace('rgbaa', 'rgba');
    rgba = rgba.replace(')', ', 1)');

    return rgba;
}

function submitStyleForm(e, name)
{
    let form = e;
    let elements = e.elements;
    let styleNodes = [];
    let payload = ' ';
    [...elements].forEach((elem) => {
        if (!elem.disabled) {
            if (elem.classList.contains(name)) {
                styleNodes.push(elem);
            }
        }
    });

    styleNodes.map((styleNode) => {
        payload += " " + styleNode.name + "{" + styleNode.style.cssText + "}\n";
    });

    fetch(`/customize-theme/save-customized-style/${name}`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        method: 'post',
        body: JSON.stringify({
            data: payload
        })
    })
    .then((res) => {
        if (res.ok) {
            return res;
        }
    })
    .then((data) => {
        console.log(data);
    });
}

function splitInlineStyle(input)
{
    if (input) {
        return input.split(';');
    }
}

function removeInlineStyle(input, property)
{
    let finalStyle = '';
    let styles = splitInlineStyle(input);
    let newStyle = styles.filter((style) => {
        let styleProperty = style.split(':')[0];
        if (property !== styleProperty.trim()) {
            return true;
        }
        return false;
    });

    newStyle.map((style) => {
        finalStyle += style;
    });

    return finalStyle;
}

function addInlineStyle(input, value)
{
    return `${input} ${value};`;
}
</script>
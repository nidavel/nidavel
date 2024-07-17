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
                            <input class="w-4 h-4 rounded-full" type="checkbox" id="" onchange="toggleSelector(this)" {{ isSelectorCustomized("$name'$selector") == true ? 'checked' : '' }}>
                            <div>{{$selector}}</div>
                        </label>

                        <div class="flex justify-start items-center gap-16 flex-wrap">
                            <fieldset class="ml-4 mt-4 flex flex-col gap-4" {{ isSelectorCustomized("$name'$selector") == true ? '' : 'disabled=""' }}>
                                @php
                                $val = getCustomizedSelectorValue("$name'$selector");
                                $r = 0; $g = 0; $b = 0; $a = 1;
                                if (strlen($val) >= 7) {
                                    $r = (int) getRedFromPropertyValue($val);
                                    $g = (int) getGreenFromPropertyValue($val);
                                    $b = (int) getBlueFromPropertyValue($val);
                                    $a = (float) getAlphaFromPropertyValue($val);
                                }
                                @endphp
                                <div class="flex flex-col gap-4">
                                    <div class="px-8">
                                        <div>
                                            <div class="flex flex-col gap-4">
                                                <div class="flex gap-8 justify-start items-start">
                                                    <div class="flex w-full gap-8 justify-start flex-wrap">

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$r}}" oninput="updateSlider(this, 0)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>R</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$r}}" oninput="updateInputAndDisplay(this, 0)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$g}}" oninput="updateSlider(this, 1)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>G</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$g}}" oninput="updateInputAndDisplay(this, 1)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="255" name="" id="" value="{{$b}}" oninput="updateSlider(this, 2)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>B</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="255" id="" value="{{$b}}" oninput="updateInputAndDisplay(this, 2)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex flex-col gap-2 items-center">
                                                            <div>
                                                                <input class="rounded w-20 text-sm h-8" type="number" min="0" max="100" name="" id="" value="{{$a*100}}" oninput="updateSlider(this, 3)">
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <div>A</div>
                                                                <div>
                                                                    <input class="" type="range" name="red" min="0" max="100" id="" value="{{$a*100}}" oninput="updateInputAndDisplay(this, 3)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <input class="{{$name}} flex items-center justify-center text-sm w-40 h-8 rounded focus:ring-0 shadow" style="
                                <?php
                                if (isSelectorCustomized("$name'$selector")) {
                                    echo "background-color:$val;";
                                }
                                $propies = implode(',', $properties);
                                ?>"
                            name="{{$selector}}" value="{{$val}}" placeholder="{{$propies}}" readonly {{ isSelectorCustomized("$name'$selector") == true ? '' : 'disabled' }}>
                        </div>
                    </div>

                @endforeach
                </fieldset>
                <div>
                    <input class="customize-submit-btn" type="submit" value="Update">
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

function toggleSelector(e)
{
    let fieldset = e.parentElement.nextElementSibling.firstElementChild;
    let display, red, green, blue, alpha;
    display = e.parentElement.nextElementSibling.lastElementChild;
    // console.log(display);
    
    red     =  fieldset.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.children[0].lastElementChild.lastElementChild.firstElementChild.value;
    green     =  fieldset.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.children[1].lastElementChild.lastElementChild.firstElementChild.value;
    blue     =  fieldset.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.children[2].lastElementChild.lastElementChild.firstElementChild.value;
    alpha     =  fieldset.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.firstElementChild.children[3].lastElementChild.lastElementChild.firstElementChild.value;
    
    if (e.checked == true) {
        fieldset.disabled = false;
        let rgba = combineValuesToRGBA(red, green, blue, alpha);
        display.style.cssText = addInlineStyle(display.style.cssText, `${e.value}:${rgba}`);
        display.disabled = false;
    } else {
        fieldset.disabled = true;
        display.style.cssText = removeInlineStyle(display.style.cssText, e.value);
        display.disabled = true;
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
                e.parentElement.nextElementSibling.firstElementChild.disabled = true;
            }
        });
    } else {
        fetch(`/customize-theme/add-customized-style-name/${name}`)
        .then((res) => (res.ok))
        .then((data) => {
            if (data === true) {
                e.parentElement.nextElementSibling.firstElementChild.disabled = false;
            }
        });
    }
    e.disabled = false;
}

function updateSlider(e, index)
{
    let slider = e.parentElement.nextElementSibling.lastElementChild.firstElementChild;
    slider.value = e.value;
    let display = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling;
    let oldRGB = display.style.backgroundColor;
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
    display.style.backgroundColor = newRGB;
    display.value = newRGB;
}

function updateInputAndDisplay(e, index)
{
    let input = e.parentElement.parentElement.previousElementSibling.firstElementChild;
    let display = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling;
    let oldRGB = display.style.backgroundColor;
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
    display.style.backgroundColor = newRGB;
    display.value = newRGB;
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
    let btns = document.querySelectorAll('.customize-submit-btn');
    [...btns].map((btn) => {
        btn.disabled = true;
        btn.value = 'Updating...';
    });
    
    [...elements].forEach((elem) => {
        // console.log(elem.disabled);
        if (elem.disabled === false) {
            if (elem.classList.contains(name)) {
                styleNodes.push(elem);
            }
        }
    });

    // console.log(styleNodes);

    styleNodes.map((styleNode) => {
        payload += ` ${styleNode.name}{--color:${styleNode.value}; `;
        styleNode.placeholder.split(',').map((prop) => {
            payload += `${prop}:var(--color);`;
        });
        payload += `}\n`;
    });
    // console.log(payload);

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
        [...btns].map((btn) => {
            btn.disabled = false;
            btn.value = 'Done';
        });
        if (res.ok) {
            return res;
        } else {
            emitDashboardAlert('Error: Customized style', 'Customized style did not update successfully.', 'error');
        }
    })
    .then((data) => {
        // console.log(data);
        emitDashboardAlert('Customized style', 'Customized style updated successfully.', 'success');
    });
}

function removeInlineStyle(input, property)
{
    let finalStyle = '';
    let styles = input.split(';');
    let newStyle = styles.filter(
        (style) => property.trim() !== style.split(':')[0].trim()
    );
    // console.log(newStyle);

    newStyle.map((style) => {
        finalStyle += `${style};`;
    });

    return finalStyle;
}

function addInlineStyle(input, value)
{
    return `${input} ${value};`;
}
</script>

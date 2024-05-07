<?php
$themeColor = settings('r', 'general.theme_color') ?? '#000000';
?>

<div>
    <form action="" method="post"></form>
    <div class="flex flex-col gap-8 border rounded p-4">
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
                
                <input class="rounded text-sm px-4 py-2 cursor-pointer bg-black hover:bg-black/80 text-white transition duration-500" type="submit" value="Set theme color">
            </form>
        </div>
    </div>
</div>

<script>
let themeColorLabel = document.querySelector('#theme_color_label');
let themeColor = document.querySelector('#theme_color');
themeColorLabel.innerText = `Current color: ${themeColor.value}`;
themeColor.onchange = () => {
    themeColorLabel.innerText = `Current color: ${themeColor.value}`;
}
</script>
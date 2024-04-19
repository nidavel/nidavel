<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Installation</title>
</head>
<body class="installation-body-bg">
    <div class="flex flex-col gap-16 w-screen h-screen items-center justify-center">
        {{-- Logo --}}
        <div class="installation-logo">
            <svg viewBox="0 0 512 512">
                <polygon style="fill:#040C14;" points="256,141.421 326.711,212.132 397.422,141.421 256,0 114.579,141.421 185.289,212.132 "/>
                <polygon style="fill:#040C14;" points="256.001,370.579 185.289,299.868 114.578,370.579 256,512 397.422,370.578 326.711,299.868 "/>
                <polygon style="fill:#FF7F50;" points="56.355,257 21,292.355 56.355,327.711 127.066,257 56.355,186.29 21,221.645 "/>
                <polygon style="fill:#FF7F50;" points="456.646,257 492,221.645 456.646,186.289 385.935,257 456.646,327.711 492,292.355 "/>
            </svg>
        </div>
        <div class="installation-container">
            <div class="flex flex-col gap-16">
                {{-- form --}}
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-8 text-sm">
                        <h3 class="installation-welcome">Welcome</h3>
                        <p>
                            Welcome to the One-Click Nidavel installation process. <br>
                            Just fill out the form below, and you're on your way to using the best static blogging software available!
                        </p>
                    </div>
                    <div>
                        <form action="/install" method="post" class="flex flex-col gap-4">
                            @csrf
                            <div>
                                <label class="flex flex-col gap-2">
                                    <div>Application name</div>
                                    <div>
                                        <input class="menu-text-input text-gray-700" type="text" name="app_name" value="Nidavel">
                                    </div>
                                </label>
                            </div>

                            <button class="installation-submit" type="submit">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

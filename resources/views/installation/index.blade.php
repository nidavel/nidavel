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
            logo
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

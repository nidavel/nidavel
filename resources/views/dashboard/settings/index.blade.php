<?php
use App\Http\Controllers\SettingController;
$allSettingsForms = allSettingsForms();
?>

<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" data-slot="icon" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="flex gap-4 items-center"><h2 class="font-black text-black inline-block">Settings</h2>
                
            </span>
        </div>

        <div class="flex flex-col gap-8">
            <div>
                <p class="font-bold text-lg">Edit settings</p>
            </div>

            <div class="sub-list">
                <span class="text-blue-500"><a href="/dashboard?route=settings">General</a></span>
                @if (!empty($allSettingsForms))
                    @foreach ($allSettingsForms as $title => $form)
                    <span class="text-gray-300">|</span>
                    <span class="text-blue-500"><a href="/dashboard?route=settings&key={{$form['key']}}&resource={{base64_encode($form['resource'])}}">{{ $title }}</a></span>
                    @endforeach
                @endif
            </div>

            <div>
                <form action="/settings/set" method="post" class="flex flex-col gap-4">
                    <input type="hidden" name="key" value="{{$_GET['key'] ?? 'general'}}">
                @if (!empty($_GET['resource']))
                    @php
                        include_once base64_decode($_GET['resource']);
                    @endphp
                        
                @else
                    @php
                        include_once base_path('/resources/views/dashboard/settings/general.php');
                    @endphp
                @endif
                    <button class="inline-block w-20 text-center cursor-pointer px-4 py-2 rounded-lg bg-blue-500 text-white" type="submit">Done</button>
                </form>
            </div>
        </div>
    </div>
</div>

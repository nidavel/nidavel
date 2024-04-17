<?php
use App\Http\Controllers\PageController;
$menu = getMenuList();
$page = new PageController();
$pages = $page->list();
?>

<div>
    <div class="flex flex-col gap-8">
        {{-- Page Title --}}
        <div class="flex items-center gap-4">
            <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                    <path d="M5.625 3.75a2.625 2.625 0 100 5.25h12.75a2.625 2.625 0 000-5.25H5.625zM3.75 11.25a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5H3.75zM3 15.75a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75zM3.75 18.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5H3.75z" />
                </svg>
            </div>
            <span class="flex gap-4 items-center"><h2 class="font-black text-black inline-block">Menu</h2>
                
            </span>
        </div>

        <div class="flex flex-col gap-8">
            <div>
                <p class="font-bold text-lg">Customize your menu</p>
            </div>

            <div>
                <form action="/menu/create" method="post">
                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-700">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Display</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">URL</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Target</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-900">Remove</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100" id="menu_list_body">
                    @foreach ($menu as $title => $props)
                        <?php
                        $str = rand(1, 2000000);
                        ?>
                        <tr id="tr_{{$str}}" class="menu-tr">
                            <td class="px-6 py-4">
                                <input class="menu-text-input" type="text" name="title_{{$str}}" id="title_{{$str}}" list="titles_{{$str}}" value="{{$title}}">
                                <datalist id="titles_{{$str}}">
                                    @foreach ($pages as $page)
                                        <option value="{{$page['title']}}">
                                    @endforeach
                                </datalist>
                            </td>

                            <td class="px-6 py-4">
                                <input class="menu-text-input" type="text" name="url_{{$str}}" id="url_{{$str}}" value="{{$props['url']}}">
                            </td>

                            <td class="px-6 py-4">
                                <select class="menu-text-input" name="target_{{$str}}" id="">
                                    <option value="none" {{ $props['target'] == null ? 'selected' : ''}}>None</option>
                                    <option value="_blank" {{ $props['target'] == '_blank' ? 'selected' : ''}}>Blank</option>
                                </select>
                            </td>

                            <td class="px-6 py-4">
                                <div class="inline-block cursor-pointer" onclick="deleteRow('tr_{{$str}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-center items-center gap-8 mt-8">
                        <button class="flex justify-center items-center w-12 h-12 border border-gray-500 border-dashed rounded-lg" type="button" onclick="addRow()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>

                        <button class="flex justify-center items-center px-12 h-12 bg-blue-400 text-white rounded-lg" type="submit">Done</button>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>

<script>

let pages = {};
pages = <?php echo json_encode($pages); ?>;

const deleteRow = (id) => {
    let parent = document.querySelector(`#menu_list_body`);
    let child = document.querySelector(`#${id}`);
    parent.removeChild(child);
}

const addRow = () => {
    let parent = document.querySelector(`#menu_list_body`);
    parent.appendChild(createRow());
}

const createRow = () => {
    let str = Math.floor(1 + Math.random() * 2000000);

    let row = document.createElement('tr');    
    row.setAttribute('id', `tr_${str}`);
    row.setAttribute('class', `menu_tr`);

    let tdName = document.createElement('td');
    tdName.setAttribute('class', 'px-6 py-4');

    let tdNameInput = document.createElement('input');
    tdNameInput.setAttribute('type', 'text');
    tdNameInput.setAttribute('name', `title_${str}`);
    tdNameInput.setAttribute('class', 'menu-text-input');
    tdNameInput.setAttribute('id', `title_${str}`);
    tdNameInput.setAttribute('list', `titles_${str}`);

    let tdNameDatalist = document.createElement('datalist');
    tdNameDatalist.setAttribute('id', `titles_${str}`);

    pages.map((page) => {
        let tdNameDatalistOption = document.createElement('option');
        tdNameDatalistOption.setAttribute('value', `${page.title}`);
        tdNameDatalist.appendChild(tdNameDatalistOption);
    })

    tdName.appendChild(tdNameInput);
    tdName.appendChild(tdNameDatalist);

    let tdUrl = document.createElement('td');
    tdUrl.setAttribute('class', 'px-6 py-4');

    let tdUrlInput = document.createElement('input');
    tdUrlInput.setAttribute('type', 'text');
    tdUrlInput.setAttribute('name', `url_${str}`);
    tdUrlInput.setAttribute('class', 'menu-text-input');
    tdUrlInput.setAttribute('id', `url_${str}`);

    tdUrl.appendChild(tdUrlInput);

    let tdTarget = document.createElement('td');
    tdTarget.setAttribute('class', 'px-6 py-4');

    let tdTargetSelect = document.createElement('select');
    tdTargetSelect.setAttribute('name', `target_${str}`);
    tdTargetSelect.setAttribute('class', 'menu-text-input');

    let targetOptions = {
        none: "None",
        _blank: "Blank"
    };

    for (const [value, display] of Object.entries(targetOptions)) {
        let tdTargetOption = document.createElement('option');
        tdTargetOption.setAttribute('value', value);
        tdTargetOption.innerHTML = display;
        tdTargetSelect.appendChild(tdTargetOption);
    }

    tdTarget.appendChild(tdTargetSelect);

    let tdRemove = document.createElement('td');
    tdRemove.setAttribute('class', 'px-6 py-4');

    let tdRemoveDiv = document.createElement('div');
    tdRemoveDiv.setAttribute('class', 'inline-block cursor-pointer');
    tdRemoveDiv.setAttribute('onclick', `deleteRow('tr_${str}')`);
    tdRemoveDiv.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>`;
    
    tdRemove.appendChild(tdRemoveDiv);

    row.appendChild(tdName);
    row.appendChild(tdUrl);
    row.appendChild(tdTarget);
    row.appendChild(tdRemove);

    return row;
}

</script>


<script src="{{ asset('js/tinymce_6.6.0/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce-config.js') }}"></script>

<div class="flex flex-col gap-8">
    <div class="flex flex-wrap items-top gap-8 w-full justify-between">
        <div class="post-body">
            {{-- Page Title --}}
            <div class="flex items-center gap-4">
                <div class="flex justify-center items-center w-8 h-8 rounded bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-4 h-4">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </div>
                <span class="flex gap-4 items-center"><h2 class="font-black text-black inline-block">Create new post</h2></span>
            </div>
        
            <div>
                <form method="POST" action="{{ '/posts/store' }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-8">
                        <div>
                            <input name="title" minlength="1" class="w-full border-gray-300 shadow rounded-lg" type="text" placeholder="Add Title" />
                        </div>

                        <div>
                            <label>
                                <div class="">
                                    <textarea name="content" id="content_id" class="w-full border-gray-300 h-64 shadow" placeholder="What's on your mind?"></textarea>
                                </div>
                            </label>
                        </div>
                    </div>
            </div>
        </div>

        <div class="post-form-container">
            <div class="flex flex-col gap-8">
                {{-- Post --}}
                <div class="flex flex-col gap-4 bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <p class="font-bold">Post</p>
                        <label for="publish_id" class="post-publish-btn" href="#">Publish</label>
                    </div>

                    <hr class="" />

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <p>Status:</p>
                            <p class="font-bold">Unsaved</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <label for="save_draft_id" class="post-savedraft-btn" href="#">Save draft</label>
                        <a class="post-cancel-btn" href="/dashboard?route=dashboard/home">Cancel</a>
                    </div>
                </div>

                {{-- Featured image --}}
                <div class="flex flex-col gap-4 bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <p class="font-bold">Featured image</p>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <hr class="" />

                    <div class="flex flex-col gap-2">
                        <label for="featured_image_id" class="flex items-center justify-center text-center border border-2 border-dashed rounded w-full h-24">
                            <p id="featured_image_container_id" class="p-2 overflow-hidden w-full h-full">No image selected. Click to upload image from file.</p>
                        </label>
                        <div class="flex justify-between items-center">
                            <label class="post-select-img-btn">
                                Select from file
                                <input name="featured_image" id="featured_image_id" type="file" accept="image/*" value="Select image from file" class="hidden" />
                            </label>
                            {{-- <div>
                                <button class="post-select-img-btn">Select from gallery</button>
                            </div> --}}
                            <script>
                                let img = document.querySelector('#featured_image_id');
                                let imgContainer = document.querySelector('#featured_image_container_id');
                                img.onchange = () => {
                                    if (img.files.length > 0) {
                                        getImgData();
                                    }
                                }
                                function getImgData() {
                                    const files = img.files[0];
                                    if (files) {
                                        const fileReader = new FileReader();
                                        fileReader.readAsDataURL(files);
                                        fileReader.addEventListener("load", function () {
                                        imgContainer.style.display = "block";
                                        imgContainer.innerHTML = '<img src="' + this.result + '" style="width: 100%; height: 100%; object-position: center; object-fit: cover;" />';
                                        });
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="flex flex-col gap-4 bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <p class="font-bold">Description</p>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                            </svg>
                        </div>
                    </div>

                    <hr class="" />

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <textarea name="description" id="description_id" type="text" class="w-full border-gray-300 h-20 rounded-lg shadow" placeholder="A short description of the post" ></textarea>
                        </div>
                    </div>
                </div>

                {{-- Keywords --}}
                <div class="flex flex-col gap-4 bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <p class="font-bold">Keywords</p>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <hr class="" />

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <input name="keywords" id="keywords_id" type="text" class="w-full border-gray-300 rounded-lg shadow" placeholder="Example: Laravel,Blasta" />
                        </div>
                        <p class="text-sm">Separate each keyword with a comma</p>
                    </div>
                </div>

                

                {{-- Post type --}}
                <div class="flex flex-col gap-4 bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <p class="font-bold">Post type</p>
                    </div>

                    <hr class="" />
                    
                    <div>
                        <select class="w-full rounded-lg border-gray-300 shadow" name="post_type" id="post_type_id">
                            <option selected value="post">Post</option>
                            <option value="page">Page</option>
                        </select>
                    </div>

            </div>
            </div>
        </div>

        <div class="hidden">
            <input name="save_draft" id="save_draft_id" type="submit" value="Save draft" />
            <input name="publish" id="publish_id" type="submit" value="Publish" />
        </div>
        </form>
    </div>
</div>

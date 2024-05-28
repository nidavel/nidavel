<script type="text/javascript">
    function copyShortcode(shortcode, e)
    {
        navigator.clipboard.writeText(`[${shortcode}]`);
        e.firstElementChild.innerHTML = '<span style="display:inline-block; padding:5px; border-radius:5px; color:green; background-color:rgba(0,255,0,0.2);">Copied!</span>';
        setTimeout(() => {
            e.firstElementChild.innerHTML = shortcode;
        }, 2000);
    }

    var shortcodes;

    shortcodes = <?= json_encode(getShortcodes()) ?>;
    let node = '';
    if (shortcodes == null) {
        shortcodes = 'No shortcode is available';
    } else {
        shortcodes = JSON.stringify(shortcodes);
        let codes = JSON.parse(shortcodes);
        let container = '<div style="display:flex; flex-direction:row; flex-wrap:wrap; gap:1rem; width:100%;">';
        codes.map((code) => {
            code.description = code.description == null
                ? 'No description'
                : code.description.substring(0,64);
            code.author = code.author == null
                ? 'No author'
                : code.author.substring(0,16);
            let tempNode = '';
            tempNode += `<span
             class="flex flex-col gap-2 rounded-xl"
             style="width: 13.2rem;font-size: 0.875rem; background-color:rgba(0,0,0,0.08); cursor:pointer; padding:10px;"
             title="Click to copy ${code.shortcode}"
             onclick="copyShortcode('${code.shortcode}', this)">
                <span class="font-bold" style="font-size: 0.75rem; font-weight:bold;">${code.shortcode}</span>
                <span class="" style="font-size: 0.75rem;">${code.description}</span>
                <span class="text-xs" style="font-size: 0.60rem; font-style:italic;">By ${code.author}</span>
            </span>`;
            node += tempNode;
        });
        node += '</div>';
        shortcodes = container + node;
    }
</script>

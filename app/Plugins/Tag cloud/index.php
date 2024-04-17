<?php

registerWidget(
    'Tag cloud',
    plugin_path('/Tag cloud/widget/body.php'),
    [
        "text" => "title",
        "number" => "tags count"
    ]
);

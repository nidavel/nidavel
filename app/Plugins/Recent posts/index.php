<?php

registerWidget(
    'Recent posts',
    plugin_path('/Recent posts/widget/body.php'),
    [
        "text" => "title",
        "number" => "posts count"
    ]
);

// registerSettingsForm('Recent Posts', 'recent_posts', plugin_path('/Recent posts/form.php'));

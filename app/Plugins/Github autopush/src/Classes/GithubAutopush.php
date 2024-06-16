<?php

namespace Nidavel\GithubAutopush\Classes;

// require_once 'C:/dev/nidavel/app/Blasta/Functions/settings.php';

class GithubAutopush
{
    private static $instance    = null;
    private static $repository  = null;
    private static $pat         = null;
    private static $repoUrl     = null;
    private static $stdin       = null;
    private static $stdout      = null;
    private static $stderr      = null;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance   = new GitHubAutopush;
            static::$repository = settings('r', 'github_autopush.repository');
            static::$pat        = settings('r', 'github_autopush.pat');
            static::$repoUrl    = 'https://'.static::$pat.'@github.com/'.static::$repository;
            // static::$stdin      = fopen("php://stdin","r");
            // static::$stdout     = fopen("php://stdout","w");
            // static::$stderr     = fopen("php://stderr","w");
        }

        if (static::isConnected() === false) {
            static::$instance = null;
            addDashboardNotice('github_autopush', [
                'title' => 'GitHub autopush',
                'message' => "Internet disconnected. Connect to the internet and try again.",
                'type' => 'warning'
            ]);
        }
        else if (static::isRepoValid() === false) {
            static::$instance = null;
            addDashboardNotice('github_autopush', [
                'title' => 'GitHub autopush',
                'message' => "Repository given does not exist. Check your settings.",
                'type' => 'warning'
            ]);
        }
        
        return static::$instance;
    }

    public static function init()
    {
        $message = '';
        $messageType = 'info';
        $gitDir = public_path('my_exports/.git');

        if (file_exists($gitDir)) {
            return;
        }

        $gitDir = public_path('my_exports');

        $repoUrl = static::$repoUrl;
        $commands = [
            "git init",
            "git add .",
            'git commit -m "Initial commit"',
            "git branch -M main",
            "git remote add origin $repoUrl",
            "git push -u origin main"
        ];

        $x = 0;
        foreach ($commands as $command) {
            $returnValue = static::run("cd $gitDir && $command");
            $message .= "$command - ";
            if ($returnValue === 1) {
                $message .= " failed.<br>";
                break;
            }
            else if ($returnValue === 0) {
                $message .= " done.<br>";
            }
            $x++;
        }
        
        $messageType = $x === count($commands) ? 'success' : 'warning';

        addDashboardNotice('github_autopush', [
            'title' => 'GitHub autopush',
            'message' => $message,
            'type' => $messageType
        ]);
    }

    public static function push(string $commitMessage)
    {
        $repoUrl = static::$repoUrl;
        $message = '';
        $messageType = 'info';
        $gitDir = public_path('my_exports/.git');

        if (!file_exists($gitDir)) {
            return;
        }

        $gitDir = public_path('my_exports');
        
        $commands = [
            "git add .",
            "git commit -m \"$commitMessage\"",
            "git push"
        ];

        $x = 0;
        foreach ($commands as $command) {
            $returnValue = static::run("cd $gitDir && $command");
            $message .= "$command - ";
            if ($returnValue === 1) {
                $message .= " failed.<br>";
                break;
            }
            else if ($returnValue === 0) {
                $message .= " done.<br>";
            }
            $x++;
        }
        
        $messageType = $x === count($commands) ? 'success' : 'warning';

        addDashboardNotice('github_autopush', [
            'title' => 'GitHub autopush',
            'message' => $message,
            'type' => $messageType
        ]);
    }

    private static function run(string $command)
    {
        $stdin = fopen("php://stdin","r");
        $stdout = fopen("php://stdout","w");
        $stderr = fopen("php://stderr","w");
        $descriptorspec = array(
            0 => $stdin,
            1 => $stdout,
            2 => $stderr
         );
         
        $process = @proc_open($command, $descriptorspec, $pipes);

        if (is_resource($process)) {
            fclose($stdin);
            fclose($stdout);
            fclose($stderr);
        
            $returnValue = proc_close($process);
        }

        return $returnValue;
    }

    private static function isConnected()
    {
        $repo = static::$repository;
        $connected = @fsockopen("github.com", 80);
        if ($connected) {
            $is_conn = true; //action when connected
            fclose($connected);
        } else {
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }

    private static function isRepoValid()
    {
        $repo = static::$repository;
        $url = rtrim("https://github.com/$repo", '.git');
        $status = false;
  
        // Use get_headers() function
        $headers = get_headers($url);

        // Use condition to check the existence of URL
        if ($headers && strpos($headers[0], '200')) {
            $status = true;
        }

        return $status;
    }
}

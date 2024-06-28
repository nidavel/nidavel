<?php

namespace Nidavel\FtpAutoLoad\Classes;

class FTPA
{
    private static $instance = null;
    private static $host;
    private static $port;
    private static $publicDirectory;
    private static $username;
    private static $password;
    private static $connection;
    private static $passive;
    private static $timeout;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (!static::isConnected()) {
            static::$instance = null;
            static::close();
            static::dashboardNotice(
                'Internet conection not detected. Connect to the internet and try again.',
                'warning'
            );
            return static::$instance ;
        }

        if (static::$instance === null) {
            static::$host               = settings('r', 'ftpa.host');
            static::$port               = !empty(settings('r', 'ftpa.port'))
                ? settings('r', 'ftpa.port')
                : 21;
            static::$publicDirectory    = !empty(settings('r', 'ftpa.pub_dir'))
                ? settings('r', 'ftpa.pub_dir')
                : '/public_html';
            static::$username           = settings('r', 'ftpa.username');
            static::$password           = settings('r', 'ftpa.password');
            static::$timeout            = !empty(settings('r', 'ftpa.timeout'))
                ? settings('r', 'ftpa.timeout')
                : 90;
            static::$passive            = !empty(settings('r', 'ftpa.passive'))
                ? true
                : false;
            static::$connection         = static::connect();

            static::login();
            static::$instance = new FTPA;
        }

        return static::$instance;
    }

    public static function put(string $remoteFile, string $localFile, $showNotice = true)
    {
        $result = \ftp_put(static::$connection, $remoteFile, $localFile, FTP_BINARY);

        if ($result && $showNotice) {
            static::dashboardNotice("Uploaded '$localFile' to '$remoteFile' - successful", 'success');
        } else {
            static::dashboardNotice("Upload '$localFile' to '$remoteFile'' - failed", 'danger');
        }

        return $result;
    }

    public static function putDir($srcDir, $dstDir)
    {
        $message = '';
        $d = dir($srcDir);
        while($file = $d->read()) { // do this for each file in the directory
            if ($file != "." && $file != "..") { // to prevent an infinite loop
                if (is_dir($srcDir."/".$file)) { // do the following if it is a directory
                    if (!@ftp_chdir(static::$connection, $dstDir."/".$file)) {
                        static::mkdir("$dstDir/$file"); // create directories that do not yet exist
                        $message .= "Created '$dstDir/$file'<br>";
                    }
                    static::putDir($srcDir."/".$file, $dstDir."/".$file); // recursive part
                } else {
                    $upload = static::put("$dstDir/$file", "$srcDir/$file", false); // put the files
                    $message .= $upload == true
                        ? "Uploaded '$srcDir/$file' to '$dstDir/$file'<br>"
                        : "Failed to upload '$srcDir/$file' to '$dstDir/$file'<br>";
                }
            }
        }
        $d->close();
        static::dashboardNotice($message, 'info');
    }

    public static function nlist(string $dir)
    {
        $list = \ftp_nlist(static::$connection, $dir);
        $listCount = count($list);
        $x = 0;
        for ($x = 0, $i = 0; $x < 2 && $i < $listCount; $i++) {
            if ($list[$i] == '.' || $list[$i] == '..') {
                unset($list[$i]);
                $x++;
            }
        }

        return $list;
    }

    public static function delete(string $path, bool $showNotice = true)
    {
        $result = \ftp_delete(static::$connection, $path);

        if ($result && $showNotice) {
            static::dashboardNotice("Deleted '$path' - successful", 'success');
        } else {
            static::dashboardNotice("Delete '$path' - failed", 'danger');
        }

        return $result;
    }

    public static function mkdir(string $dir, bool $showNotice = true)
    {
        $result = \ftp_mkdir(static::$connection, $dir);

        if ($result && $showNotice) {
            static::dashboardNotice("Created directory '$dir' - Successful", 'success');
        } else {
            static::dashboardNotice("Create directory '$dir' - failed", 'danger');
        }

        return $result;
    }

    public static function rmdir(string $dir, bool $showNotice = true)
    {
        $result = \ftp_rmdir(static::$connection, $dir);

        if ($result && $showNotice) {
            static::dashboardNotice("Delete directory '$dir' - Successful", 'success');
        } else {
            static::dashboardNotice("Delete directory '$dir' - failed", 'danger');
        }

        return $result;
    }

    public static function uploadSite()
    {
        static::putDir(public_path('my_exports'), static::$publicDirectory);
    }

    private static function connect()
    {
        return \ftp_connect(static::$host, (int) static::$port, static::$timeout);
    }

    private static function login()
    {
        $loggedIn = \ftp_login(
            static::$connection, static::$username, static::$password
        );

        if ($loggedIn) {
            \ftp_pasv(static::$connection, static::$passive);
        } else {
            static::dashboardNotice(
                'FTP log in failed. Check supplied details or internet connection',
                'warning'
            );
        }

        return $loggedIn;
    }

    public static function close()
    {
        if (is_resource(static::$connection)) {
            \ftp_close(static::$connection);
        }
    }

    private static function isConnected()
    {
        $connected = @fsockopen("google.com", 80);
        
        if ($connected) {
            fclose($connected);
            return true;
        }

        return false;
    }

    private static function dashboardNotice(string $message, string $type)
    {
        addDashboardNotice('ftp_autoload', [
            'title'     => 'FTP Autoload',
            'message'   => $message,
            'type'      => $type
        ]);
    }
}

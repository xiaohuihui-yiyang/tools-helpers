<?php

namespace DevTools\Helpers;

use GuzzleHttp\Client;
use DevTools\Helpers\Exceptions\Exceptions;

class FileHelpers extends BaseHelpers
{
    /**
     * Create the directory by pathname
     * @param string $pathname The directory path.
     * @param int $mode
     * @return bool
     */
    public static function MakeDir($pathname, $mode = 0777)
    {
        if (is_dir($pathname)) {
            return true;
        }
        if (is_dir(dirname($pathname))) {
            return mkdir($pathname, $mode);
        }
        self::MakeDir(dirname($pathname));
        return mkdir($pathname, $mode);
    }


    public static function Download($url, $file)
    {
        if (!is_dir(dirname($file))) {
            if (!self::MakeDir(dirname($file))) {
                throw new Exceptions('无法创建目录，请检查文件写入权限。');
            }
        }
        $fp = fopen($file, 'w+');
        if ($fp === false) {
            throw new Exceptions('无法保存文件，请检查文件写入权限。');
        }

        $client = new Client([
            'verify' => false,
            'stream' => true,
        ]);
        $response = $client->get($url);
        $body = $response->getBody();
        while (!$body->eof()) {
            fwrite($fp, $body->read(1024));
        }
        fclose($fp);
        return $file;
    }

    /**
     * @param $url
     * @return array|string|string[]
     */
    public static function GetUrlFileExt($url)
    {
        $file_ext = pathinfo($url, PATHINFO_EXTENSION);
        if ($file_ext) {
            if (strlen($file_ext) > 4 && strpos($file_ext, "?")) {
                list('0' => $file_ext) = explode('?', $file_ext);
            }
        } else {
            $file_ext = 'jpg';
        }
        return $file_ext;
    }


    /**
     * 对比两个文件夹不同的文件 并返回差异
     * @param $new_dir
     * @param $old_dir
     * @return array
     */
    public static function DiffMd5($new_dir, $old_dir)
    {
        static $list = [];
        $file_arr = scandir($new_dir);
        foreach ($file_arr as $file) {
            if ($file != ".." && $file != ".") {
                if (is_dir($new_dir . "/" . $file)) {
                    self::DiffMd5($new_dir . "/" . $file, $old_dir . "/" . $file);
                } else {
                    if (file_exists($new_dir . "/" . $file)) {
                        if (md5_file($new_dir . "/" . $file) != md5_file($old_dir . "/" . $file)) {
                            $list[] = $new_dir . '/' . $file;
                        }
                        continue;
                    }
                    $list[] = $new_dir . '/' . $file;
                }
            }
        }
        return $list;
    }

    /** 删除文件夹中的内容
     * @param $path
     * @return bool
     */
    public static function RmDir($path)
    {
        if (!is_dir($path)) {
            return true;
        }
        foreach (scandir($path) as $file) {
            if ($file != '.' && $file != '..') {
                $rmPath = $path.'/'.$file;
                is_file($rmPath) ? unlink($rmPath) : self::RmDir($rmPath);
            }
        }
        return rmdir($path);
    }



    /** 拷贝目录下所有文件到指定文件夹下
     * @param $src
     * @param $dst
     * @param $ignore
     * @return void
     */
    public static function CopyDir($src, $dst, $ignore = [])
    {
        $handle = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($handle))) {
            if (($file != '.') && ($file != '..') && !in_array($src.'/'.$file, $ignore)) {
                if (is_dir($src.'/'.$file)) {
                    self::CopyDir($src.'/'.$file, $dst.'/'.$file);
                    continue;
                } else {
                    copy($src.'/'.$file, $dst.'/'.$file);
                }
            }
        }
        closedir($handle);
    }

    /** 删除文件夹中指定需要忽略的文件和文件夹
     * @param $dir
     * @param $ignoreFile
     * @return void
     */
    public static function removeIgnoreFile($dir, $ignoreFile = [])
    {
        $file_arr = scandir($dir);
        foreach ($file_arr as $file) {
            if ($file != ".." && $file != ".") {
                if (is_dir($dir."/".$file)) {
                    if (in_array($file, $ignoreFile['dirs'])) {
                        self::rmDir($dir."/".$file);
                    } else {
                        self::removeIgnoreFile($dir."/".$file, $ignoreFile);
                    }
                } elseif(in_array($file, $ignoreFile['files'])) {
                    unlink($dir."/".$file);
                }
            }
        }
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/9/2017
 * Time: 8:29 PM
 */

class File_Manager
{
    public $path = '';
    public $dir = '';

    public function __construct()
    {
        $this->path = str_replace('\\', '/', realpath(dirname(__FILE__) . '/..'));
    }

    public function index($name = '')
    {
        if(strlen($name) > 0)
        {
            if (file_exists($name))
            {
                $index = [];
                $sub_dir = [];
                if (is_dir($name) && $handle = opendir($name))
                {
                    while (false !== ($object = readdir($handle)))
                    {
                        if ($object != "." && $object != "..")
                        {
                            if (is_dir($name . '/'. $object))
                            {
                                $type = "directory";
                                $size = count(glob($name . '/' . $object . '/*'));
                                $index[] = array(
                                    "name" => $object,
                                    "path" => basename($name) . '/' . $object,
                                    "type" => $type,
                                    "size" => $size,
                                    "sub_dir" => $this->index($name . '/' . $object)
                                );
                            }
                            else
                            {
                                $type = "file";
                                $size = @filesize($name . '/' . $object);
                                $index[] = array(
                                    "name" => $object,
                                    "path" => basename($name) . '/' . $object,
                                    "type" => $type,
                                    "size" => $size,
                                    "sub_dir" => $sub_dir
                                );
                            }
                        }
                    }
                    closedir($handle);
                }
            }
            return $index;
        }
        else
        {
            if (file_exists($this->path))
            {
                $index = [];
                $sub_dir = [];
                if (is_dir($this->path) && $handle = opendir($this->path))
                {
                    while (false !== ($object = readdir($handle)))
                    {
                        if ($object != "." && $object != "..")
                        {
                            if (is_dir($this->path . '/'. $object))
                            {
                                $type = "folder";
                                $size = count(glob($this->path . '/' . $object . '/*'));
                            }
                            else
                            {
                                $type = "file";
                                $size = filesize($this->path . '/' . $object);
                            }
                            $index[] = array(
                                "name" => $object,
                                "path" => $object,
                                "type" => $type,
                                "size" => $size,
                                "sub_dir" => ''
                            );
                        }
                    }
                    closedir($handle);
                }
            }
            return $index;
        }
    }

    public function init($dir = '')
    {
        $current_dir = $this->path;

        if(strlen($dir) > 0)
        {
            $current_dir .= '/' . $dir;
        }

        return $this->index($current_dir);
    }

    public function makeLink($dir)
    {
        $link = '?dir=';
        $link .= $dir;

        return $link;
    }

    public function getString($path)
    {
        return basename($path);
    }
}
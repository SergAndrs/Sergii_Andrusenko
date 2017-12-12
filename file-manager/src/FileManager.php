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

    public function dirToArray($dir)
    {
       $result = [];

       $cdir = scandir($dir); 
       foreach ($cdir as $key => $value) 
       { 
          if (!in_array($value,array('.','..'))) 
          { 
             if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
             { 
                $type = 'folder';
                $size = count(glob($dir . DIRECTORY_SEPARATOR . $value . '/*'));
                $path = $dir . DIRECTORY_SEPARATOR . $value;
                $path = str_replace('./\\', '', $path);
                $path = str_replace('\\', '/', $path);
                $result[] = array(
                    'name' => $value,
                    'path' => $path,
                    'type' => $type,
                    'size' => $size,
                    'sub_dir' => $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value)
                );
             } 
             else 
             { 
                $type = 'file';
                $size = filesize($dir . DIRECTORY_SEPARATOR . $value);
                $path = $dir . DIRECTORY_SEPARATOR . $value;
                $path = str_replace('./\\', '', $path);
                $path = str_replace('\\', '/', $path);
                $result[] = array(
                    'name' => $value,
                    'path' => $path,
                    'type' => $type,
                    'size' => $size,
                    'sub_dir' => ''
                );
             } 
          } 
       }
       return $result; 
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
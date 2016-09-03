<?php

/**
 * File_Manager short summary.
 *
 * File_Manager description.
 *
 * @version 1.0
 * @author Kaos
 */

define('PATH', '');

class File_Manager
{
    private $res;
    
    public function file_control($control = null, $filename = null, $data = null)
    {
        switch($control)
        {
            case "Create":
            {
                $this->res = $this->create_file($filename, $data);
                break;
            }
            case "Read":
            {
                $this->res = $this->read_file($filename, $data);
                break;
            }
            case "Update":
            {
                $this->res = $this->update_file($filename, $data);
                break;
            }
            case "Delete":
            {
                $this->res = $this->delete_file($filename);
                break;
            }
            default:
            {
                $this->res = "File control {$control} not found";
            }
        }
        return $this->res;
    }
    
    private function create_file($filename = null, $data = null)
    {
        $handle = fopen(PATH.$filename, 'w');
        if($handle == false)
        {
            return 'Cannot open file:  '.PATH.$filename;
        }
        elseif($handle == true)
        {
            $fw = fputs($handle, $data);
            if($fw == true)
            {
                return "File {$filename} created and data written";
            }
            elseif($fw == false)
            {
                return "File {$filename} created but no data was writtenn to it";
            }
            fclose($handle);
        }
    }
    
    private function update_file($filename = null, $data = null)
    {
        $handle = fopen(PATH.$filename, 'a');
        if($handle == false)
        {
            return 'Cannot open file:  '.$filename;
        }
        elseif($handle == true)
        {
            $fw = fputs($handle, $data);
            if($fw == true)
            {
                return "File {$filename} found and data updated";
            }
            elseif($fw == false)
            {
                return "File {$filename} found but no data was updated to it";
            }
            fclose($handle);
        }
    }
    
    private function read_file($filename = null, $data = null)
    {
        $handle = fopen(PATH.$filename, 'r');
        if($handle == false)
        {
            return 'Cannot open file:  '.$filename.' for reading functionality';
        }
        elseif($handle == true)
        {
            $fr = fread($handle, filesize(PATH.$filename));
            if(!empty($fr))
            {
                return $fr;
            }
            elseif(empty($fr))
            {
                return "File {$filename} opened but no data was read";
            }
            fclose($handle);
        }
    }
    
    private function delete_file($filename = null)
    {
        if(unlink(PATH.$filename))
        {
            return "File deleted";
        }
    }
}
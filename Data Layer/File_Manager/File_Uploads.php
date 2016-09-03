<?php

/**
 * File_Uploads short summary.
 *
 * File_Uploads description.
 *
 * @version 1.0
 * @author Kaos
 */
class File_Uploads
{
    public function Upload($num, $path, $files)
    {
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $files["file"]["name"]);
      $extension = end($temp);
      if ($files["file"]["type"] == "image/gif" || $files["file"]["type"] == "image/jpeg" || $files["file"]["type"] == "image/jpg" || $files["file"]["type"] == "image/pjpeg" || $files["file"]["type"] == "image/x-png" || $files["file"]["type"] == "image/png" && $files["file"]["size"] < 1000000 && in_array($extension, $allowedExts))
       {
        if ($files["file"]["error"] > 0)
          {
            return "Return Code: " . $files["file"]["error"];
          }
        else 
          {
            $fileName = $temp[0].".".$temp[1];
            $temp[0] = rand(0, 3000); //Set to random number
            $fileName;
          if(file_exists($path.$files["file"]["name"]))
            {
                return $files["file"]["name"] . " already exists. ";
            }
          else
            {
                $temp = explode(".", $files["file"]["name"]);
                $newfilename = $path.basename($files["file"]["name"]);
              try
              {
                if(move_uploaded_file($files["file"]["tmp_name"], $newfilename))
                {
                    return "File uploaded";
                }
              }catch(Exception $ex)
              {
                  array_push($ex, "File Upload Error");
                  return $ex;
              }
            }
          }
        }
      else
        {
            return "Invalid file";
        }
    }
    
    private function check_file()
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
       $fileContents = file_get_contents($_FILES['some_name']['tmp_name']);
       $mimeType = $finfo->buffer($fileContents);
    }
}
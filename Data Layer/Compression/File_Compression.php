<?php

/**
 * File_Compression short summary.
 *
 * File_Compression description.
 *
 * @version 1.0
 * @author Kaos
 */
 
// Compress a file
//File_Compress("/web/myfile.dat", "/web/myfile.gz");
 
class File_Compression
{
    public function File_Compress($srcName, $dstName)
    {
        $this->compress($srcName, $dstName);
    }
    
    private function compress($srcName, $dstName)
    {
        $fp = fopen($srcName, "r");
        $data = fread ($fp, filesize($srcName));
        fclose($fp);

        $zp = gzopen($dstName, "w9");
        gzwrite($zp, $data);
        gzclose($zp);
    }
    
}


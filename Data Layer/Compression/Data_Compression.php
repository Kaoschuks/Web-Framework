<?php

/**
 * Data_Compression short summary.
 *
 * Data_Compression description.
 *
 * @version 1.0
 * @author Kaos
 */
class Data_Compression
{

    public function Text_Compress($string)
    {
        //echo "Compressed : ".$this->GzCompress($this->Gzflate_Encode($string));
        return $this->GzCompress($string);
    }
    
    public function Text_Decompress($string)
    {
        //echo "Uncompressped :";
        echo $this->GzUncompress($string);
    }
    
    public function Array_Compress($string)
    {
       return $this->GzCompress($this->Gzflate_Encode($this->Encode_string_array($string)));
    }
    
    public function Array_Decompress($string)
    {
        return $this->Decode_string_array($this->Gzflate_Decode($this->GzUncompress($string)));
    }
    
    // percent-encoding on plain text
    private function percent_encoding($string)
    {
        return var_dump(urlencode($string));
    }
    
    private function percent_decoding($string)
    {
        return var_dump($string);
    }
    
    private function Gzflate_Decode($string)
    {
        return gzinflate(base64_decode(strtr($string, '-_', '+/')), 9);
    }
    
    private function Gzflate_Encode($string)
    {
        return rtrim(strtr(base64_encode(gzdeflate($string, 9)), '+/', '-_'), '=');
    }
        
    private function GzCompress($string)
    {
        return gzcompress($string);
    }
    
    private function GzUncompress($string)
    {
        return gzuncompress($string);
    }
    
    private function Encode_string_array($stringArray) {
        $s = strtr(base64_encode(addslashes(gzcompress(serialize($stringArray),9))), '+/=', '-_,');
        return $s;
    }

    private function Decode_string_array($stringArray) {
        $s = unserialize(gzuncompress(stripslashes(base64_decode(strtr($stringArray, '-_,', '+/=')))));
        return $s;
    }
}

<?php
namespace NoizuLabs\Core\Tests;

class Fixture extends \NoizuLabs\PHPConform\PHPUnitExtension\Module
{
    const MD5_HASHLENGTH = 32;

    public function GenerateGuid($prefix, $length = null, $key = "unique")
    {
        if($length == null) $length = strlen($prefix) + self::MD5_HASHLENGTH;

        $hash = md5($key . "___" . microtime(false));
        $guid = $prefix . str_repeat($hash, ceil($length - (strlen($prefix))/self::MD5_HASHLENGTH));
        return substr( $guid , 0, $length);
    }

    public function GenerateContent($prefix, $minLength = 64, $maxLength = 256, $minWordLength = 1, $maxWordLength = 16, $key = "unique")
    {

        $targetLength = rand($minLength, $maxLength);
        $content = "$prefix ";
        $length = strlen($content);
        while($length <= $targetLength)
        {
            $wordLength = rand($minWordLength, $maxWordLength);
            $word = substr( str_repeat( md5($key . "__" . microtime(false)) , ceil( $wordLength / self::MD5_HASHLENGTH)), 0,$wordLength);
            $content .= $word . " ";
            $length += $wordLength;
        }
         return substr(trim($content),0,$maxLength);
    }



    //====================
    // Reflection
    //===================

}

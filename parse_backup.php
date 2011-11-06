/*

*/

<?php

$index = 0;

echo "Nokia smartphones' Backup.arc parser\n";
echo "2007 by Andrey Sergienko\n\n";
echo "http://www.erazer.org\n\n";

if ($argc != 2)
{
 echo "Usage: put this program in the directory where Backup.arc is and just run it\n\n";
 exit;
}

$backupfilename = $argv[1];

$fr = fopen($backupfilename,'rb');
$compressed = fread($fr, filesize($backupfilename));

echo "Parsing..\n\n";
while(!(FALSE === ($iParse = strpos ($compressed, chr(0x78)))) )
{
  $iSkip = 1;
  $compressed = substr($compressed, $iParse);
  if(FALSE != ($uncompressed = @gzuncompress($compressed)) )
  {
    $filename = "block-".$index;
    if (!$handle = fopen($filename, 'w')) {
      echo "Cannot open file ($filename)";
      exit;
    }
     if (fwrite($handle, $uncompressed) === FALSE) {
         echo "Cannot write to file ($filename)";
	exit;
     }

     fclose($handle);

    $index++;

    echo ".";
  }

   echo "!";

  $compressed  = substr($compressed, $iSkip);
}

echo "done\n\n";

?>

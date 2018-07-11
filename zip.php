<?php 	

// Get real path for our folder
if (isset($_POST['backup_app'])) {


$rootPath = realpath('../Zip');
echo $rootPath;
// Initialize archive object
$zip = new ZipArchive();
$zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();

$file ='file.zip';
  if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
            unlink($file);
        }


}
// $filename = "file.zip";

//  if (file_exists($filename)) {
//   header('Content-Type: application/zip');
//   header('Content-Disposition: attachment; filename="'.basename($filename).'"');
//   header('Content-Length: ' . filesize($filename));

//   flush();
//   readfile($filename);
//   // delete file
//   unlink($filename);
 
//  }
if(isset($_POST['backup_db'])){


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = 'rled';
$user = 'root';
$pass = '';
$host = 'localhost';
$dir = dirname(__FILE__) . '/dump.sql';

echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

exec("\"c:\\xampp\\\\mysql\\bin\\mysqldump.exe\" --user={$user} --password={$pass} -B --host={$host} {$database} --result-file={$dir} 2>&1", $output);

	var_dump($output);

}

?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 <form method="post">
 	<input type="submit" name="backup_db" value="Database">
 	<input type="submit" name="backup_app" value="Backup">
 </form>
 </body>
 </html>
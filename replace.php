<form action="replace.php" method="post">
 <p><input type="text" name="search" value="<?php echo $_POST['search']; ?>" /> Найти</p>
 <p><input type="text" name="replace" value="<?php echo $_POST['replace']; ?>" /> Заменить</p>
 <p><input type="submit" value="Старт"/></p>
</form></br>
<?php
function FindAndReplace($patch) {
  $handle = opendir($patch); while(($file = readdir($handle))) {
    if (is_file($patch."/".$file) && ((substr($file, strrpos($file, '.')) == ".htm") || (substr($file, strrpos($file, '.')) == ".html"))) {
      $full = $patch."/".$file; 
      $data = file_get_contents($full); $count = 0;
      $data = str_replace($_POST['search'], $_POST['replace'], $data, $count);
      file_put_contents($full, $data);
      if ($count > 0) echo $full." - ok</br>\r\n"; else echo $full." - missing</br>\r\n";
    }
    if (is_dir($patch."/".$file) && ($file != ".") && ($file != "..")) FindAndReplace($patch."/".$file); 
  }
  closedir($handle);
} 
if ($_POST['search'] != '') FindAndReplace(".");
?>
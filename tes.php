<?php
echo "<pre>";
print_r($_FILES);
echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title> 
</head>

<body>
    <form action="tes.php" method="post" enctype="multipart/form-data">
        Pilih file: <input type="file" name="berkas" />
        <input type="submit" name="upload" value="upload" />
    </form> 
</body> 
</html>
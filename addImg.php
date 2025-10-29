<?php 

$targetDir = "assets/img/"; // Cartella di destinazione per salvare le immagini
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

// Controlla se il file è un'immagine reale o un falso

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Il file è un'immagine - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Il file non è un'immagine.";
        $uploadOk = 0;
    }


// Controlla se il file esiste già
if (file_exists($targetFile)) {
    echo "Spiacente, il file esiste già.";
    $uploadOk = 0;
}

// Controlla la dimensione del file
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Spiacente, il file è troppo grande.";
    $uploadOk = 0;
}

// Consenti solo alcuni formati di file
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Spiacente, solo file JPG, JPEG, PNG & GIF sono consentiti.";
    $uploadOk = 0;
}else{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
}
var_dump($_FILES);
error_log(print_r($_FILES, true));

?>
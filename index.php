<!-- Pasinaudoję tuo, ką jau išmokome sukurkite PHP failų naršyklę. Jos reikalavimai:
galimybė matyti failus ir/ar direktorijas,
galimybė vaikščioti po katalogus bei matyti jų turinį,
galimybė sukurti naujas direktorijas,
galimybė ištrinti failus (direktorijų trinti nereikia),
** galimybė įkelti failus,
** aplikacija yra apsaugota autentikacijos mechanizmu (reikia prisijungti),
* galimybė parsisiųsti failus. 

Prie turimos failų naršyklės aplikacijos pridėti galimybę prisijungti (autentikacija). Nereikia nieko įmantraus, 
slaptažodžiai gali būti tiesiog “įhardcodinti”.
*Papildomi darbai sausainiukams įvaldyti
Parašykite aplikaciją, kuri skaičiuoja kiek kartų vartojas pasiekė sveitainę (taip kaip darėme su sesijomis),
bet nenaudojant sesijų, o naudojat vien sausainiukus.
-->
<?php
    if(isset($_POST['download'])){
        print('Path to download: ./FTP' . $_SERVER['QUERY_STRING']. "/" . $_POST['filename']);
        $file='./FTP' . $_SERVER["QUERY_STRING"] . "./" . $_POST['filename'];
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
        ob_clean();
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownloadEscaped));
        ob_end_flush();
        readfile($fileToDownloadEscaped);
        exit;
    }

    if(isset($_POST['delete'])){
        $file='./FTP' . $_SERVER["QUERY_STRING"] . "./" . $_POST['filename'];
        unlink($file);
    }

    if(isset($_FILES['image'])){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        // check extension (and only permit jpegs, jpgs and pngs)
        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
        $extensions = array("jpeg","jpg","png");
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_size > 2097152) {
            $errors[]='File size must not exceed 2 MB';
            }
            if(empty($errors)==true) {
            move_uploaded_file($file_tmp,"./FTP". $_SERVER['QUERY_STRING'] . "./" . $file_name);
            // echo "Success";
        }else{
            print_r($errors);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>File Browser</title>
</head>
<body>
    <div class="container">
        <nav>
            <div class="teal nav-wrapper">
                <a href="?" class="breadcrumb">FTP</a>
                <?php
                    $url = $_SERVER['QUERY_STRING'];
                    $crumbs = explode("/", $url);
                    $crumbsUri = "";
                    foreach ($crumbs as $value) { 
                        if($value){
                            print("<a href=\"?" . $crumbsUri . $value . "\" class=\"breadcrumb\">" . $value . "</a>");
                            $crumbsUri .= $value . "/";
                        }
                    }
                ?>
            </div>
        </nav>

        <table class="highlight">
            <tr>
                <thead>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Actions</th>
                </thead>
            </tr>

            <?php
                $path = "./FTP" . "/" . $url;
                $cdir = scandir($path);
                foreach ($cdir as $value) {
                    if (!in_array($value, array(".", ".."))) { 
                        print("<tr>");
                            if(is_dir($path . "/" . $value)) {
                                print("<td>DIR</td>");
                                print("<td><a href='?" . $url . "/". $value . "'>" . $value . "</a></td>");
                                print("<td></td>");
                            }
                            else {
                                print("<td>File</td>");
                                print("<td>". $value . "</td>");
                                print("<td>
                                        <form method='post' action=''>
                                            <input type='hidden' name='filename' value='". $value ."'/>
                                            <button id='download-file' class='waves-effect waves-light btn' name='download' type='submit'>download</button> 
                                            <button id='delete-file' class='waves-effect waves-light btn red lighten-1' name='delete' type='submit'>delete</button> 
                                        </form>
                                    </td>");
                            }
                        print("</tr>");
                    }
                }
            ?>
        </table>

        <form method="post" enctype="multipart/form-data" action="#">
            <div class="file-field input-field">
                <button id="send-file" class="btn waves-effect waves-light" type="submit" name="action">
                    <span>Submit</span>
                    <i class="material-icons left">send</i>
                </button>
                <div class="btn">
                    <i class="material-icons left">cloud_upload</i>
                    <span>Browse</span>
                    <input type="file" name="image"> 
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
        </form>
        <!-- <ul>
            <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
            <li>File size: <?php echo $_FILES['image']['size'];  ?>
            <li>File type: <?php echo $_FILES['image']['type'] ?>
        </ul> -->
    </div>
</body>

<script src="actions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
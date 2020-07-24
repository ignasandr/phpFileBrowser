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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./style.css">  -->
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
                            print("<td class=\"name\">". $value . "</td>");
                            print("<td>
                                    <a class='waves-effect waves-light btn' data='" .
                                    $value
                                    . "'>download</a> 
                                    <a class='waves-effect waves-light btn red lighten-1' data='" .
                                    $value
                                    . "'>delete</a> 
                                </td>");
                        }
                    print("</tr>");
                    }
                }
            ?>
        </table>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
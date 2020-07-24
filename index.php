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
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>File Browser</title>
</head>
<body>
    <div class="container">
        <table class="highlight">
            <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <?php
                $cdir = scandir('./');
                foreach ($cdir as $key => $value) {
                    if (!in_array($value, array(".", ".."))) { 
                    print("<tr>");
                        if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                            print("<td>DIR</td>");
                            print('<td class="name">' . $value . "</td>");
                            print("<td></td>");
                        }
                        else {
                            print("<td>File</td>");
                            print("<td>". $value . "</td>");
                            print("<td></td>");
                        }
                    print("</tr>");
                    }
                }
            ?>
        </p>
    </div>

</body>
</html>
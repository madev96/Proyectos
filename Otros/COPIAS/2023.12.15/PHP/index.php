<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ejemplo de PHP</title>
</head>
<body>
<p> Ejemplo de matriz </p>
    <?php 
        $matri = array (
            "Fila1" => array(" 1 ", " 2 ", " 3 ", " 4 "),
            "Fila2" => array(" 5 ", " 6 ", " 7 ", " 8 "),
            "Fila3" => array(" 9 ", " 10 ", " 11 ", " 12 ")
        );
    
    print($matri["Fila1"][0]);
    print($matri["Fila1"][1]);
    print($matri["Fila1"][2]);

    echo "<br>";

    print($matri["Fila2"][0]);
    print($matri["Fila2"][1]);
    print($matri["Fila2"][2]);

    echo "<br>";

    print($matri["Fila3"][0]);
    print($matri["Fila3"][1]);
    print($matri["Fila3"][2]);
    ?>

    <p> Ejemplo de arrays </p>
    
    <?php 
        $arriete = array("ab", "bs", "be", "be", "bz","bgt", "bt");
        print($arriete[2]);
    ?>

</body>
</html>

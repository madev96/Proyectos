<!DOCTYPE html>
<html>
<head>
    <title>Matriz en PHP</title>
</head>
<body>
    <table border="1">
        <?php
        // Inicializa una variable para el número
        $numero = 1;

        // Inicia el primer bucle para las filas
        for ($i = 0; $i < 15; $i++) {
            echo "<tr>";
            
            // Inicia el segundo bucle para las columnas
            for ($j = 0; $j < 15; $j++) {
                // Imprime el número en una celda de la tabla
                echo "<td>" . str_pad($numero, 2, '0', STR_PAD_LEFT) . "</td>";
                $numero++; // Incrementa el número
            }

            echo "</tr>"; // Cierra la fila de la tabla
        }
        ?>
    </table>
</body>
</html>

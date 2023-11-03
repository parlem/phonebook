<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <style>
        table, th, td {
            border: 1px solid white;
            border-collapse: collapse;
        }
        th, td {
            background-color: #96D4D4;
        }

    </style>
    <body>
        <form id="formulari" action="process.php" METHOD="POST">
            <table id="TaulaPhonebook">
                <?php
                $RowCount = 0;
                $xml = simplexml_load_file("phonebook-yealink.xml") or die("Could not open file!");
                foreach ($xml->children() as $phonebook) {
                    echo "<tr id='".$RowCount."-row'>";
                    foreach ($phonebook->children() as $contact) {
                        if ($contact->getName() == "Name") {
                            echo "<td><input type='text' name='item[" . $RowCount . "][name]' value='" . $contact . "'></td>";
                        }
                        if ($contact->getName() == "Telephone") {
                            echo "<td><input type='text' name='item[" . $RowCount . "][phone]' value='" . $contact . "'></td><td><button type='button' onclick='deleterow(".$RowCount.")'>Delete</button></td>";
                        }
                    }
                    echo "</tr>";
                    $RowCount = $RowCount + 1;
                }
                ?>
            </table>
            <br>
            <table>
                <tr>
                    <td><input type='text' id='Newname' value='-'></td>
                    <td><input type='text' id='Newphone' value='-'></td>
                    <td><button type='button' onclick='myFunction()'>Afegir</button></td>
                </tr>
            </table>
            <button type='submit' form='formulari' value='Submit'>Modificar</button>
        </form>
        <script>
            function myFunction() {
                var table = document.getElementById("TaulaPhonebook");
                var RowCount = table.tBodies[0].rows.length;
                console.log(RowCount);
                var name = document.getElementById("Newname").value;
                var phone = document.getElementById("Newphone").value;
                addRow(name, phone, RowCount);
            }
            function addRow(name, phone, RowCount) {
                console.log(RowCount);
                // Get the table element in which you want to add row
                let table = document.getElementById("TaulaPhonebook");

                // Create a row using the inserRow() method and
                // specify the index where you want to add the row
                let row = table.insertRow(-1); // We are adding at the end
                row.id = RowCount+"-row";
                // Create table cells
                let c1 = row.insertCell(0);
                let c2 = row.insertCell(1);
                let c3 = row.insertCell(2);
                
                // Add data to c1 and c2
                c1.innerHTML = "<input type='text' name='item["+RowCount+"][name]' value='"+name+"'>";
                c2.innerHTML = "<input type='text' name='item["+RowCount+"][phone]' value='"+phone+"'>";
                c3.innerHTML = "<button type='button' onclick='deleterow("+RowCount+")'>Delete</button>";
            }
function deleterow(RowCount) {
    var row = document.getElementById(RowCount+'-row');
    console.log(RowCount);
    row.parentNode.removeChild(row);
}            
        </script>
    </body>

</html>

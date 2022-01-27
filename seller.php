<!DOCTYPE html>
<html>
    <head>
        <title>Seller</title>
    </head>
    <body>
    <style>
        TABLE {
            width: 400px;
            border-collapse: collapse;
        }
        TD, TH {
            padding: 3px;
            border: 1px solid black;
        }
        TH {
            background: #b0e0e6;
        }
    </style>
    <?php
    include "creds.php";
    $seller_data = "SELECT * FROM seller";
    $res = $db->query($seller_data);
    echo "<table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>delete seller</th>
                <th>edit seller</th>
            </tr>";
    while ($row = $res->fetch()) {
        echo "<tr>";
            echo "<td>".$row['id'].'</td>';
            echo "<td>".$row['name'].'</td>';
            echo "<td>
                    <form method='post' action='delete/delete_seller.php'>
                        <input type='hidden' name='id' value='".$row['id']."'/>
                        <input type='submit' value='delete'/>
                    </form>
                </td>";
            echo "<td>
                    <a href='update/update_seller.php?id=".$row['id']."'>
                    <button>edit</button>
                    </a>
                </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <h3>Add seller</h3>
    <form method="post" action="add/add_seller.php">
        <p>name: <input type="text" name="name"/></p>
        <input type="submit">
    </form>
    </body>
</html>
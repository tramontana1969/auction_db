<!DOCTYPE html>
</<!doctype html>
<html lang="en">
    <head>
        <title>Customer</title>
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
    $customer_data = "SELECT * FROM customer";
    $res = $db->query($customer_data);
    echo "<table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>delete customer</th>
                <th>edit customer</th>
            </tr>";
    while ($row = $res->fetch()) {
        echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>
                    <form method='post' action='delete/delete_customer.php'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <input type='submit' value='delete'/>
                    </form>
                </td>";
            echo "<td>
                    <a href='update/update_customer.php?id=".$row['id']."'>
                        <button>edit</button>
                    </a>        
                </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <h3>Add customer</h3>
    <form method="post" action="add/add_customer.php">
        <p>name: <input type="text" name="name"/></p>
        <input type="submit">
    </form>
    </body>
</html>
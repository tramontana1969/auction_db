<!DOCTYPE html>
<html>
    <head>
        <title>Item</title>
    </head>
    <body>
    <style>
        TABLE {
            width: 600px;
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
    $item_data = "SELECT * FROM item";
    $res = $db->query($item_data);
    echo "<table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>lot</th>
            <th>seller_id</th>
            <th>customer_id</th>
            <th>delete item</th>
        </tr>";
    while ($row = $res->fetch()) {
        echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['lot']."</td>";
            echo "<td>".$row['seller_id']."</td>";
            echo "<td>".$row['customer_id']."</td>";
            echo "<td>
                    <form method='post' action='delete/delete_item.php'>
                        <input type='hidden' name='id' value='".$row['id']."'/>
                        <input type='submit' value='delete'/>
                    </form>
                </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <h3>Add item</h3>
    <form method="post" action="add/add_item.php">
        <p>name: <input type="text" name="name"/></p>
        <p>lot: <input type="number" name="lot"/></p>
        <p>seller_id:
            <select name="seller_id">
                <?php
                $sellers = $db->query("SELECT id, name FROM seller");
                while ($row = $sellers->fetch()) {
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
        </p>
        <p>customer_id:
            <select name="customer_id">
                <?php
                $customers = $db->query("SELECT id, name FROM customer");
                echo '<option selected value=""></option>';
                while ($row = $customers->fetch()) {
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
        </p>
        <input type="submit">
    </form>
    </body>
</html>
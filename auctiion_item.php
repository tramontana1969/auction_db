<!DOCTYPE html>
<html>
    <head>
     <title>auction_item</title>
    </head>
    <body>
    <style>
        TABLE {
            width: 800px;
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
    $auction_item_data = "SELECT * FROM auction_item";
    $res = $db->query($auction_item_data);
    echo "<table>
            <tr>
                <th>id</th>
                <th>auction_id</th>
                <th>item_id</th>
                <th>start_price</th>
                <th>actual_price</th>
                <th>description</th>
                <th>delete data</th>
            </tr>";
    while ($row = $res->fetch()) {
        echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['auction_id']."</td>";
            echo "<td>".$row['item_id']."</td>";
            echo "<td>".$row['start_price']."</td>";
            echo "<td>".$row['actual_price']."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>
                    <form method='post' action='delete/delete_auction_item.php'>
                        <input type='hidden' name='id' value='".$row['id']."'/>
                        <input type='submit' value='delete'/>
                    </form>
                </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <h3>Add data</h3>
    <form method="post" action="add/add_auction_item.php">
        <p>auction_id:
            <select name="auction_id">
                <?php
                $auctions = $db->query("SELECT id, date, place FROM auction");
                while ($row = $auctions->fetch()) {
                    echo "<option value='".$row['id']."'>"."{$row['place']}, {$row['date']}"."</option>";
                }
                ?>
            </select>
        </p>
        <p>item_id:
            <select name="item_id">
                <?php
                $items = $db->query("SELECT id, name FROM item");
                while ($row = $items->fetch()) {
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
        </p>
        <p>start_price: <input type="number" name="start_price"/></p>
        <p>actual_price: <input type="number" name="actual_price"/></p>
        <p>description: <input type="text" name="description"/></p>
        <input type="submit">
    </form>
    </body>
</html>
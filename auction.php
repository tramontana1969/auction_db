<!DOCTYPE html>
<html>
    <head>
        <title>Auction</title>
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
    $auction_data = "SELECT * FROM auction";
    $res = $db->query($auction_data);
    echo "<table>
            <tr>
                <th>id</th>
                <th>date</th>
                <th>time</th>
                <th>place</th>
                <th>description</th>
                <th>delete auction</th>
                <th>edit auction</th>
            </tr>";
    while ($row = $res->fetch()) {
        echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['date']."</td>";
            echo "<td>".$row['time']."</td>";
            echo "<td>".$row['place']."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>
                    <form method='post' action='delete/delete_auction.php'>
                        <input type='hidden' name='id' value='".$row['id']."'/>
                        <input type='submit' value='delete'/>
                    </form>
                </td>";
            echo "<td>
                    <a href='update/update_auction.php?id=".$row['id']."'>
                        <button>Update</button>
                    </a>
                </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <h3>Add auction</h3>
    <form method="post" action="add/add_auction.php">
        <p>date: <input type="date" name="date"/></p>
        <p>time: <input type="time" name="time"/></p>
        <p>place: <input type="text" name="place"/></p>
        <p>description: <input type="text" name="description"/></p>
        <input type="submit">
    </form>
    </body>
</html>
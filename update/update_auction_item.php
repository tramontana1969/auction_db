<!DOCTYPE html>
<html>
    <head>
        <title>Edit data</title>
    </head>
    <body>
    <h3>Edit data</h3>
    <?php
    include "../creds.php";
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM auction_item WHERE id = :id";
        $data = $db->prepare($sql);
        $data->execute(array(':id' => $id));
        foreach ($data as $row) {
            $auction_id = $row['auction_id'];
            $item_id = $row['item_id'];
            $start_price = $row['start_price'];
            $actual_price = $row['actual_price'];
            $description = $row['description'];
        }
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='$id'/>";
        echo "<p>auction_id: ";
        echo "<select name='auction_id'>";
        $current_auction = $db->query("SELECT id, date, place FROM auction WHERE id = {$id}");
        while ($row = $current_auction->fetch()) {
            echo "<option selected value='{$row['id']}'>{$row['place']}, {$row['date']}</option>";
        }
        $other_auctions = $db->query("SELECT id, date, place FROM auction WHERE id != {$id}");
        while ($row = $other_auctions->fetch()) {
            echo "<option value='{$row['id']}'>{$row['place']}, {$row['date']}</option>";
        }
        echo "</select></p>";
        echo "<p>item_id: ";
        echo "<select name='item_id'>";
        $current_item = $db->query("SELECT id, name FROM item WHERE id = {$id}");
        while ($row = $current_item->fetch()) {
            echo "<option selected value='{$row['id']}'>{$row['name']}</option>";
        }
        $other_items = $db->query("SELECT id, name FROM item WHERE id != {$id}");
        while ($row = $other_items->fetch()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        echo "</select></p>";
        echo "<p>start_price: <input type='number' name='start_price' value='$start_price'/></p>";
        echo "<p>actual_price: <input type='number' name='actual_price' value='$actual_price'/></p>";
        echo "<p>description: <input type='text' name='description' value='$description'/></p>";
        echo "<input type='submit' value='update'/>";
        echo "</form>";
    }
    elseif (isset($_POST['id']) && !empty($_POST['auction_id']) && !empty($_POST['item_id']) &&
        !empty($_POST['start_price']) && isset($_POST['actual_price']) && !empty($_POST['description'])) {
        $id = $_POST['id'];
        $auction_id = $_POST['auction_id'];
        $item_id = $_POST['item_id'];
        $start_price = $_POST['start_price'];
        $actual_price = $_POST['actual_price'];
        $description = $_POST['description'];
        if (empty($actual_price)) {
            $actual_price = null;
        }
        $sql = "UPDATE auction_item SET auction_id = :auction_id, item_id = :item_id, start_price = :start_price,
                actual_price = :actual_price, description = :description WHERE id = :id";
        $update = $db->prepare($sql);
        $update->execute(
                array(
                    ':auction_id' => $auction_id,
                    ':item_id' => $item_id,
                    ':start_price' => $start_price,
                    ':actual_price' => $actual_price,
                    ':description' => $description,
                    ':id' => $id
                )
        );
        header('Location: ../auction_item.php');
    }
    ?>
    </body>
</html>
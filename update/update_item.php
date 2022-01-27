<!DOCTYPE html>
<html>
    <head>
        <title>Edit item</title>
    </head>
    <body>
    <h3>Edit item</h3>
    <?php
    include "../creds.php";
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM item WHERE id = :id";
        $item = $db->prepare($sql);
        $item->execute(array(':id'=>$id));
        foreach ($item as $data) {
            $name = $data['name'];
            $lot = $data['lot'];
            $seller_id = $data['seller_id'];
            $customer_id = $data['customer_id'];
        }
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='$id'/>";
        echo "<p>name: <input type='text' name='name' value='$name'/></p>";
        echo "<p>lot: <input type='number' name='lot' value='$lot'/></p>";
        echo "<p>seller_id: ";
        echo "<select name='seller_id'>";
        $current_seller = $db->query("SELECT id, name FROM seller WHERE id = {$id}");
        while ($row = $current_seller->fetch()) {
            echo "<option selected value='{$row['id']}'>{$row['name']}</option>";
        }
        $other_sellers = $db->query("SELECT id, name FROM seller WHERE id != {$id}");
        while ($row = $other_sellers->fetch()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        echo "</select></p>";
        echo "<p>customer_id";
        echo "<select name='customer_id'>";
        if (empty($customer_id)) {
            echo '<option selected value=""></option>';
        }
        elseif (!empty($customer_id)) {
            $current_customer = $db->query("SELECT id, name FROM customer WHERE id = {$id}");
            while ($row = $current_customer->fetch()) {
                echo "<option selected value='{$row['id']}'>{$row['name']}</option>";
                echo '<option value=""></option>';
            }
        }
        $other_customers = $db->query("SELECT id, name FROM customer WHERE id != {$id}");
        while ($row = $other_customers->fetch()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        echo "</select></p>";
        echo "<input type='submit' value='Update'/>";
        echo "</form>";
    }
    elseif (isset($_POST['id']) && !empty($_POST['name']) && isset($_POST['lot']) &&
            !empty($_POST['seller_id']) && isset($_POST['customer_id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $lot = $_POST['lot'];
        $seller_id = $_POST['seller_id'];
        $customer_id = $_POST['customer_id'];
        if (empty($_POST['lot'])) {
            $lot = null;
        }
        if (empty($_POST['customer_id'])) {
            $customer_id = null;
        }
        $sql = "UPDATE item SET name = :name, lot = :lot, seller_id = :seller_id,
                customer_id = :customer_id WHERE id = :id";
        $update = $db->prepare($sql);
        $update->execute(
                array(
                    ':name' => $name,
                    ':lot' => $lot,
                    ':seller_id' => $seller_id,
                    ':customer_id' => $customer_id,
                    ':id' => $id
                )
        );
        header('Location: ../item.php');
    }
    ?>
    </body>
</html>
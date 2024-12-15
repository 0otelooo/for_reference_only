<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php'; // Your database connection file

$user_id = $_SESSION['user_id'];

// Handle form submission to remove an item from the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item_id'])) {
    $item_id = intval($_POST['remove_item_id']);
    $deleteQuery = "DELETE FROM cart WHERE user_id = ? AND item_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
    echo "<div class='alert alert-success'>Item removed from cart successfully!</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch cart items for the user
                $query = "SELECT cart.item_id, items.name, items.description, items.price, cart.quantity 
                          FROM cart 
                          JOIN items ON cart.item_id = items.id 
                          WHERE cart.user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $grandTotal = 0;
                while ($row = $result->fetch_assoc()) {
                    $total = $row['price'] * $row['quantity'];
                    $grandTotal += $total;

                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$total}</td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='remove_item_id' value='{$row['item_id']}'>
                                <button type='submit' class='btn btn-danger'>Remove</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
                <tr>
                    <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                    <td colspan="2"><strong><?php echo $grandTotal; ?></strong></td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</body>
</html>
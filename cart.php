<?php
session_start();

// Check if the user is logged in (for demo purposes, we use a session variable)
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Fetch cart items from the session (cart should be an array in $_SESSION)
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Shein Cart</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .cart-container {
      width: 90%;
      margin: 50px auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .cart-items {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      padding: 15px;
      border-bottom: 1px solid #ddd;
      align-items: center;
    }

    .cart-item img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
    }

    .cart-item-details {
      flex-grow: 1;
      margin-left: 15px;
    }

    .cart-item-details h3 {
      font-size: 18px;
      margin-bottom: 5px;
    }

    .cart-item-details p {
      color: #888;
      font-size: 14px;
    }

    .cart-item-details .price {
      font-size: 16px;
      color: #000;
      font-weight: bold;
      margin-top: 5px;
    }

    .cart-item-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .cart-item-actions input {
      width: 40px;
      text-align: center;
      padding: 5px;
      font-size: 16px;
    }

    .cart-item-actions button {
      padding: 8px 16px;
      background-color: #000;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    .cart-item-actions button:hover {
      background-color: #333;
    }

    .cart-summary {
      text-align: right;
      margin-top: 20px;
      font-size: 18px;
    }

    .cart-summary p {
      font-size: 20px;
      font-weight: bold;
    }

    .cart-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .cart-actions button {
      padding: 12px 25px;
      background-color: #3e3e3e;
      color: white;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    .cart-actions button:hover {
      background-color: #53251c;
    }

    .continue-shopping {
      background-color: #ccc;
    }

  </style>
</head>
<body>

  <div class="cart-container">
    <h1>Your Cart</h1>

    <div class="cart-items">
      <?php if (count($cartItems) > 0): ?>
        <!-- Loop through cart items and display them -->
        <?php foreach ($cartItems as $item): ?>
          <div class="cart-item">
            <img src="<?php echo $item['image']; ?>" alt="Product Image">
            <div class="cart-item-details">
              <h3><?php echo $item['name']; ?></h3>
              <p>Color: <?php echo $item['color']; ?> | Size: <?php echo $item['size']; ?></p>
              <p class="price">₱<?php echo number_format($item['price'], 2); ?></p>
            </div>
            <div class="cart-item-actions">
              <input type="number" value="<?php echo $item['quantity']; ?>" min="1" max="10">
              <button>Remove</button>
            </div>
          </div>
          <?php 
            // Add item total to cart total
            $totalAmount += $item['price'] * $item['quantity'];
          ?>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Your cart is empty!</p>
      <?php endif; ?>
    </div>

    <!-- Cart Summary -->
    <div class="cart-summary">
      <p>Subtotal: <strong>₱<?php echo number_format($totalAmount, 2); ?></strong></p>
      <p>Shipping: <strong>₱100.00</strong></p>
      <p><strong>Total: ₱<?php echo number_format($totalAmount + 100, 2); ?></strong></p>
    </div>

    <!-- Cart Actions -->
    <div class="cart-actions">
      <button class="continue-shopping">Continue Shopping</button>
      <a href="checkout.php">
        <button>Proceed to Checkout</button>
      </a>
    </div>
  </div>

</body>
</html>

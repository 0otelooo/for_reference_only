<?php
session_start();

// Check if the user is logged in (this example uses PHP session for login state)
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Fetch cart items from the session or database (for demonstration, we'll use session)
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cart">
        <h2>Your Cart</h2>
        <ul id="cart-items">
            <?php
            if (empty($cartItems)) {
                echo "<li>Your cart is empty.</li>";
            } else {
                foreach ($cartItems as $item) {
                    echo "<li>Item: " . htmlspecialchars($item['name']) . ", Price: $" . htmlspecialchars($item['price']) . "</li>";
                }
            }
            ?>
        </ul>

        <button id="checkout-btn" onclick="proceedToCheckout()">Proceed to Checkout</button>
    </div>

    <script>
        // Check if the user is logged in by checking the session
        function isUserLoggedIn() {
            return localStorage.getItem("userLoggedIn") === "true";  // Or use session/cookie for production
        }

        // Function to handle checkout
        function proceedToCheckout() {
            if (!isUserLoggedIn()) {
                alert("You must be logged in to proceed to checkout!");
                window.location.href = "login.php"; // Redirect to login page
            } else {
                alert("Proceeding to checkout...");
                // You can add further logic here, like finalizing the purchase
            }
        }

        // Optionally: If you want to persist cart in localStorage before login
        function getCartItems() {
            return JSON.parse(localStorage.getItem("cart")) || [];
        }

        // Display cart items (for non-logged-in users or if cart is not saved in PHP session)
        document.addEventListener('DOMContentLoaded', function () {
            const cartItems = getCartItems();
            const cartItemsList = document.getElementById('cart-items');
            cartItemsList.innerHTML = ''; // Clear any previous items

            if (cartItems.length === 0) {
                cartItemsList.innerHTML = '<li>Your cart is empty.</li>';
            } else {
                cartItems.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = `Item: ${item.name}, Price: $${item.price}`;
                    cartItemsList.appendChild(li);
                });
            }

            // Disable checkout if not logged in
            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.disabled = !isUserLoggedIn();
        });
    </script>

</body>
</html>

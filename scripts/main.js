document.addEventListener('DOMContentLoaded', () => {
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const cartItemId = e.target.dataset.id;
            try {
                const response = await fetch('includes/cart.inc.php', {
                    method : 'POST',
                    headers: {
                        'Content-Type' : 'application/x-www-form-urlencoded',
                    },
                    body: `action=remove_from_cart&cart_item_id=${cartItemId}`
                });
                const data = await response.json();
                alert(data.message);
                location.reload();
            } catch (error) {
                console.error('Error Removing item:', error);
                alert('Failed to remove item. Please try again.');
            }
        });
    });
    const removeWishlistButtons = document.querySelectorAll('.remove-from-wishlist');
    removeWishlistButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const productId = e.target.dataset.productId;
            try {
                const response = await fetch('includes/wishlist.inc.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=toggle_wishlist&product_id=${productId}`
                });
                const data = await response.json();
                alert(data.message);
                location.reload();
            } catch (error) {
                console.error('Error removing from wishlist:', error);
                alert('Failed to remove from wishlist. Please try again.');
            }
        });
    });
});
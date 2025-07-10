document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons     = document.querySelectorAll('.add-to-cart');
    const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const productId  = e.target.dataset.productId;
            const form       = e.target.closest('.variation-form');
            let variationId  = '';
            if (form) {
                const select = form.querySelector('.variation-select');
                variationId  = select ? select.value : '';
                if (!variationId) {
                    alert('Please select a variation.');
                    return;
                }
            }
            try {
                const response = await fetch('includes/cart.inc.php', {
                    method : 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body   : `action=add_to_cart&product_id=${productId}&quantity=1&variation_id=${variationId}`
                });
                const data = await response.json();
                alert(data.message);
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert('Failed to add to cart. Please try again.');
            }
        });
    });

    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const productId = e.target.dataset.productId;
            try {
                const response = await fetch('includes/wishlist.inc.php', {
                    method : 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=toggle_wishlist&product_id=${productId}`
                });
                const data = await response.json();
                alert(data.message);
                e.target.textContent = data.in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist';
            } catch (error) {
                console.error('Error toggling wishlist:', error);
                alert('Failed to toggle wishlist. Please try again.');
            }
        });
    });
});
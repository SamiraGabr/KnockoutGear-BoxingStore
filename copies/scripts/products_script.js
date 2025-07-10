document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            const productID = e.target.dataset.id;
            try {
                const response = await fetch('includes/cart.inc.php', {
                    method : 'POST',
                    headers: {
                        'Content-Type' : 'application/x-www-form-urlencoded'
                    },
                    body   :'action=add_to_cart&product_id=${productID}&quantity=1'
                });
                const data = await response.json();
                alert(data.message);
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert('Failed to add to cart. Please try again.');
            }
        });
    });
});
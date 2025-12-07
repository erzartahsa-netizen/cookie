// cart.js — non-invasive UI helpers for client-side cart (safe fallback)
document.addEventListener('DOMContentLoaded', function(){
    var cartItemsContainer = document.getElementById('cart-items');
    var cartTotalElem = document.getElementById('cart-total');
    if(!cartItemsContainer || !cartTotalElem) return; // nothing to do on server-driven pages

    // Keep this script minimal: do not override server-side form behavior.
    // Provide a safe handler for a checkout button if present.
    var checkoutBtn = document.getElementById('checkout-btn');
    if(checkoutBtn){
        checkoutBtn.addEventListener('click', function(e){
            var href = checkoutBtn.getAttribute('href');
            if(href){
                // anchor — default behavior will handle navigation
                return;
            }
            // If the element has a data-cart-count attribute, use it to guard navigation
            var count = parseInt(checkoutBtn.getAttribute('data-cart-count') || '0', 10);
            if(count === 0){
                e.preventDefault();
                alert('Cart is empty, please add items before checkout.');
            } else {
                window.location.href = 'checkout.php';
            }
        });
    }
});


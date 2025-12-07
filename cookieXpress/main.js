// main.js — lightweight, safe helpers
document.addEventListener('DOMContentLoaded', function(){
    // Update cart badge if server rendered count in an element with id "cart-count"
    var cartCountElem = document.getElementById('cart-count');
    if(cartCountElem){
        var count = cartCountElem.getAttribute('data-count');
        if(count !== null){
            cartCountElem.innerText = count;
        }
    }

    // Global delegated handler for elements that require confirmation before navigation
    document.body.addEventListener('click', function(e){
        var btn = e.target.closest('[data-confirm]');
        if(!btn) return;
        var message = btn.getAttribute('data-confirm') || 'Are you sure?';
        if(!confirm(message)){
            e.preventDefault();
        }
    });

    // No automatic redirects or automatic form submission — keep behavior server-driven
});

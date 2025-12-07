// Safe checkout helper: only run when expected elements exist. Prefer server-side form submission.
document.addEventListener('DOMContentLoaded', function(){
    const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
    const userData = JSON.parse(localStorage.getItem("userData")) || null;
    const cartContainer = document.getElementById("cart-items");
    if(!cartContainer) return; // nothing to do on server-rendered checkout

    let subtotal = 0;
    cartItems.forEach(item => {
        const div = document.createElement("div");
        div.textContent = `${item.name} x${item.quantity} - Rp. ${item.price * item.quantity}`;
        cartContainer.appendChild(div);
        subtotal += item.price * item.quantity;
    });

    const shippingInputs = document.querySelectorAll('input[name="shipping"]');
    let deliveryFee = 0;

    function formatRupiah(number) {
        return "Rp. " + number.toLocaleString("id-ID");
    }

    function calculateTotal() {
        const checked = document.querySelector('input[name="shipping"]:checked');
        const selectedShipping = checked ? checked.value : 'pickup';
        deliveryFee = selectedShipping === "delivery" ? 10000 : 0;

        const subtotalEl = document.getElementById("subtotal");
        const taxEl = document.getElementById("tax");
        const deliveryEl = document.getElementById("delivery-fee");
        const totalEl = document.getElementById("total-payment");

        if(subtotalEl) subtotalEl.innerText = formatRupiah(subtotal);
        if(taxEl) taxEl.innerText = formatRupiah(subtotal * 0.05);
        if(deliveryEl) deliveryEl.innerText = formatRupiah(deliveryFee);
        if(totalEl) totalEl.innerText = formatRupiah(subtotal + subtotal * 0.05 + deliveryFee);
    }

    shippingInputs.forEach(input => {
        input.addEventListener("change", calculateTotal);
    });

    const addressInput = document.getElementById("address");
    if(addressInput && userData && userData.address){
        addressInput.value = userData.address;
    }

    if(addressInput){
        addressInput.addEventListener("input", () => {
            if(userData){
                userData.address = addressInput.value;
                localStorage.setItem("userData", JSON.stringify(userData));
            }
        });
    }

    calculateTotal();

    const placeOrderBtn = document.getElementById("place-order-btn");
    if(placeOrderBtn){
        placeOrderBtn.addEventListener("click", (e) => {
            // Validate fields but do not perform client-side redirect; let server handle final submission
            const cardEl = document.getElementById("card-number");
            const cvvEl = document.getElementById("cvv");
            const expiryEl = document.getElementById("expiry");

            const cardNumber = cardEl ? cardEl.value.trim() : '';
            const cvv = cvvEl ? cvvEl.value.trim() : '';
            const expiry = expiryEl ? expiryEl.value.trim() : '';

            if(!addressInput || !addressInput.value.trim() || !cardNumber || !cvv || !expiry){
                e.preventDefault();
                alert("Please fill all required fields before placing the order.");
                return;
            }

            // Allow the form to submit normally to server (no client-side redirect here)
        });
    }
});


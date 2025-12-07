// Generate random order code: #CXP + 6 digit angka
function generateOrderCode(){
    const randomNum = Math.floor(100000 + Math.random() * 900000); // 100000 - 999999
    return `#CXP${randomNum}`;
}

// Set order code if element exists
document.addEventListener('DOMContentLoaded', function(){
    const orderCodeEl = document.getElementById("order-code");
    if(orderCodeEl) orderCodeEl.innerText = generateOrderCode();

    const homeBtn = document.getElementById("home-btn");
    if(homeBtn) homeBtn.addEventListener("click", ()=> window.location.href = "home.php");

    const shopBtn = document.getElementById("shop-btn");
    if(shopBtn) shopBtn.addEventListener("click", ()=> window.location.href = "menu.php");
});

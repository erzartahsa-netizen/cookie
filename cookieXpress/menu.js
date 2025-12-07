(function(){
    // Poll interval (ms)
    const POLL_INTERVAL = 15000; // 15s

    function fetchStock() {
        // Collect product IDs visible on the page
        const cards = document.querySelectorAll('[data-product-id]');
        if(!cards.length) return;
        const ids = Array.from(cards).map(c => c.getAttribute('data-product-id')).join(',');

        fetch(`get_stock.php?ids=${ids}`)
            .then(r => r.json())
            .then(data => {
                // data is {id: stock, ...}
                cards.forEach(card => {
                    const id = card.getAttribute('data-product-id');
                    const stock = data[id];
                    if(typeof stock === 'undefined') return;

                    const badge = card.querySelector('.stock-badge');
                    const qtyInput = card.querySelector('.qty-input');
                    const addBtn = card.querySelector('.btn-add');
                    
                    if(badge){
                        if(stock > 0){
                            badge.textContent = 'In Stock';
                            badge.classList.remove('out-stock');
                            badge.classList.add('in-stock');
                        } else {
                            badge.textContent = 'Out';
                            badge.classList.remove('in-stock');
                            badge.classList.add('out-stock');
                        }
                    }

                    if(qtyInput){
                        qtyInput.max = stock;
                        if(parseInt(qtyInput.value, 10) > stock){
                            qtyInput.value = stock > 0 ? stock : 1;
                        }
                    }

                    if(addBtn){
                        if(stock > 0){
                            addBtn.disabled = false;
                            addBtn.classList.remove('btn-disabled');
                        } else {
                            addBtn.disabled = true;
                            addBtn.classList.add('btn-disabled');
                        }
                    }

                    // If the card previously had a disabled fallback button, swap it back if in stock
                    const disabledBtn = card.querySelector('.btn-disabled:not(.btn-add)');
                    if(disabledBtn){
                        if(stock > 0){
                            disabledBtn.style.display = 'none';
                        } else {
                            disabledBtn.style.display = '';
                        }
                    }
                });
            })
            .catch(err => {
                // silently ignore
                console.error('Stock poll error', err);
            });
    }

    // Initial fetch and periodic polling
    document.addEventListener('DOMContentLoaded', ()=>{
        fetchStock();
        setInterval(fetchStock, POLL_INTERVAL);
    });
})();

async function addToCart(productUuid)
{
    const formData = new FormData();
    formData.append('product', productUuid);
    
    try {
        const response = await fetch('/ajax/addToCart.php', {
            method: 'POST',
            body: formData,
        });
        
        if (200 !== response.status) {
            throw new Error("Response not ok");
        }
        
    } catch (error) {
        alert("Er is een fout opgetreden " + error.message);
    }
}

async function increaseCartItemCount(productUuid)
{
    await this.addToCart(productUuid);
    const amountElement = document.querySelector(`.cart-item__amount[product-uuid='${productUuid}']`);

    let currentCount = parseInt(amountElement.textContent);
    amountElement.textContent = (++currentCount).toString();
}

async function removeFromCart(productUuid)
{
    const formData = new FormData();
    formData.append('product', productUuid);

    try {
        const response = await fetch('/ajax/removeFromCart.php', {
            method: 'POST',
            body: formData,
        });

        if (200 !== response.status) {
            throw new Error(await response.json());
        }

    } catch (error) {
        alert("Er is een fout opgetreden " + error.message);
    }
}

async function decreaseCartItemCount(productUuid, self)
{
    await this.removeFromCart(productUuid);
    
    const amountElement = document.querySelector(`.cart-item__amount[product-uuid='${productUuid}']`);
    let currentCount = parseInt(amountElement.textContent);

    --currentCount;

    if (currentCount === 0) {
        self.parentNode.parentNode.parentNode.parentNode.remove(); // remove item + wrapper
    }

    amountElement.textContent = currentCount.toString()
}
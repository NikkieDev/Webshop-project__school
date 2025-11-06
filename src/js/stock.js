async function setStock(productUuid) {
    const data = new FormData();
    const caller = document.querySelector(`[data-product="${productUuid}"]`);
    const value = caller.value;
    
    data.append('product', productUuid);
    data.append('newStock', value);

    await fetch('/ajax/admin/updateStock.php', {
        method: 'POST',
        body: data
    });
}
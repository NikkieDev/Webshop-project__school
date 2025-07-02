async function makePostRequest(ajaxCallName, formData) {
    try {
        const response = await fetch(`/ajax/${ajaxCallName}.php`, {
            method: 'POST',
            body: formData
        });

        if (200 !== response.status) {
            throw new Error('Er is een fout opgetreden');
        }
    } catch (error) {
        alert(error);
    }
}

async function cancelOrder(orderId)
{
    const formData = new FormData();
    formData.append('order', orderId);

    await makePostRequest('cancelOrder', formData);
    location.reload();
}

async function reOrder(orderId)
{
    const formData = new FormData()
    formData.append('order', orderId);

    await makePostRequest('reOrder', formData);
    location.reload();
}
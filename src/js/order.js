const availableActions = {
    redo: 'reOrder',
    cancel: 'cancelOrder',
};

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

async function makeOrderRequest(action, orderId)
{
    const formData = new FormData();
    formData.append('order', orderId);

    await makePostRequest(action, orderId);
}

async function cancelOrder(orderId)
{
    await makeOrderRequest(availableActions.cancel, orderId);
    location.reload();
}

async function reOrder(orderId)
{
    await makeOrderRequest(availableActions.redo, orderId);
    location.reload();
}
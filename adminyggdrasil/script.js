function submitChanges() {
    const pricePerSlice = document.getElementById('pricePerSlice').value;

    fetch('setPrice.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'PricePerSlice': pricePerSlice,
        }),
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Show popup with success message
		location.reload();
    })
    .catch(error => {
        console.error('Error submitting changes:', error);
    });
}

function updatePrice(){
	const pricePerSlice = document.getElementById("pricePerSlice").value;
	localStorage.setItem("pricePerSlide", pricePerSlide);
}
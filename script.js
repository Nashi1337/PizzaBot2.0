const pricePerSlice = 1.30;

document.addEventListener("DOMContentLoaded", function() {
    const priceContainer = document.getElementById("priceContainer");
    if (pricePerSlice !== null) {
        priceContainer.textContent = `Price per Slice: ${parseFloat(pricePerSlice).toFixed(2)}€`;
    }
	
	const editButtons = document.querySelectorAll('.edit-btn');
	const nameInput = document.getElementById('name').value;
	const meatInput = document.getElementById('meatSlices').value;
	const vegetarianInput = document.getElementById('vegetarianSlices').value;
	const veganInput = document.getElementById('veganSlices').value;
	const priorityInput = document.getElementById('priority').value;
	
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the row's data
            const rowId = this.dataset.id;
            
            fetch('delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(rowId),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Remove the corresponding row from the DOM
                const row = button.closest('tr');
                if (row) {
                    row.remove();
                }
            })
            .catch(error => {
                console.error('Error deleting row:', error);
            });
        });
    });
});

function submitOrder() {
    const name = document.getElementById('name').value;
    const meatSlices = document.getElementById('meatSlices').value;
	const vegetarianSlices = document.getElementById('vegetarianSlices').value;
	const veganSlices = document.getElementById('veganSlices').value;
    const priority = document.getElementById('priority').value;
	const totalSlices = calculateTotalSlices();
	const totalCost = calculateTotalCost();
	
    fetch('script.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'Name': name,
            'MeatSlices': meatSlices,
			'VegetarianSlices': vegetarianSlices,
			'VeganSlices': veganSlices,
            'Priority': priority,
			'TotalSlices' : totalSlices,
			'TotalCost' : totalCost,
        }),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
		location.reload();
    })
    .catch(error => {
        console.error('Error submitting order:', error);
    });
}

function updatePriorityValue(value) {
    var priorityText = document.getElementById('priorityText');
    
    switch (parseInt(value)) {
        case 0:
            priorityText.textContent = 'High category bias';
            break;
        case 1:
        case 2:
            priorityText.textContent = 'Medium category bias';
            break;
        case 3:
        case 4:
            priorityText.textContent = 'Low category bias';
            break;
        case 5:
			priorityText.textContent = 'Truly unbiased';
			break;
        case 6:
            priorityText.textContent = 'Low slice number bias';
            break;
        case 7:
        case 8:
            priorityText.textContent = 'Medium slice number bias';
            break;
        case 9:
        case 10:
            priorityText.textContent = 'High slice number bias';
            break;
        default:
            priorityText.textContent = 'Unknown'; // Handle unexpected values
    }
}

function calculateTotalSlices() {
    const meatSlices = parseInt(document.getElementById('meatSlices').value);
    const vegetarianSlices = parseInt(document.getElementById('vegetarianSlices').value) || 0;
    const veganSlices = parseInt(document.getElementById('veganSlices').value) || 0;

	const meatPizzas 		= parseInt(document.getElementById('meatPizzas').innerText);
	const vegetarianPizzas 	= parseInt(document.getElementById('vegetarianPizzas').innerText);
	const veganPizzas 		= parseInt(document.getElementById('veganPizzas').innerText);

	const updatedMeatSlices = meatPizzas*15 - meatSlices;
	const updatedVegetarianSlices = vegetarianPizzas*15 - vegetarianSlices;
	const updatedVeganSlices = veganPizzas*15 - veganSlices;
	console.log("meatSlices: " + meatSlices + " updatedMeatSlices: " + updatedMeatSlices);
    const totalSlices = '${updatedMeatSlices}/${updatedVegetarianSlices}/${updatedVeganSlices}';
    //document.getElementById('totalSlices').value = totalSlices;

    return totalSlices;
}

function calculateTotalCost(){
	const meatSlices = parseInt(document.getElementById('meatSlices').value) || 0;
    const vegetarianSlices = parseInt(document.getElementById('vegetarianSlices').value) || 0;
    const veganSlices = parseInt(document.getElementById('veganSlices').value) || 0;
	
	const totalCost = (meatSlices + vegetarianSlices + veganSlices) * pricePerSlice;
	
	return totalCost;
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('customer_id').addEventListener('change', function() {
        var customerId = this.value;
        var customerName = this.options[this.selectedIndex].text;
        var modalBody = document.getElementById('customerDetailsContent');

        // Example content, replace with actual details as needed
        modalBody.innerHTML = '<p>Details for customer: ' + customerName + '</p>';

        // Optionally trigger the modal to open if needed
        var myModal = new bootstrap.Modal(document.getElementById('customerModal'));
        myModal.show();
    });
});
// payment type card

document.getElementById('payment_type').addEventListener('change', function() {
    if (this.value === 'card') {
        var cardModal = new bootstrap.Modal(document.getElementById('cardModal'), {
            keyboard: false
        });
        cardModal.show();
    }
});
// customer manager information
document.getElementById('have_manager').addEventListener('change', function() {
    if (this.checked) {
        var managerModal = new bootstrap.Modal(document.getElementById('managerModal'));
        managerModal.show();
    }
});

document.getElementById('saveManagerInfo').addEventListener('click', function() {
    // Collect manager information
    const managerName = document.getElementById('manager_name').value;
    const managerMobile = document.getElementById('manager_mobile').value;
    const managerWhatsApp = document.getElementById('manager_whatsapp').value;
    const managerEmail = document.getElementById('manager_email').value;
    const managerPosition = document.getElementById('manager_position').value;

    // Append manager information to the form as hidden inputs
    const form = document.getElementById('customerForm');

    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'manager_name';
    input.value = managerName;
    form.appendChild(input);

    input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'manager_mobile';
    input.value = managerMobile;
    form.appendChild(input);

    input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'manager_whatsapp';
    input.value = managerWhatsApp;
    form.appendChild(input);

    input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'manager_email';
    input.value = managerEmail;
    form.appendChild(input);

    input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'manager_position';
    input.value = managerPosition;
    form.appendChild(input);

    // Close the modal
    var managerModal = bootstrap.Modal.getInstance(document.getElementById('managerModal'));
    managerModal.hide();
});
// fetching customer related to the manager
document.getElementById('customer_id').addEventListener('change', function() {
    const customerId = this.value;

    // Make an AJAX request to fetch managers associated with the selected customer
    fetch(`/get-customer-managers/${customerId}`)
        .then(response => response.json())
        .then(data => {
            const managerSelect = document.getElementById('customer_manager_id');
            managerSelect.innerHTML = ''; // Clear previous options

            // Populate the manager dropdown with the new data
            data.forEach(manager => {
                const option = document.createElement('option');
                option.value = manager.id;
                option.text = manager.manager_name;
                managerSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching customer managers:', error));
});


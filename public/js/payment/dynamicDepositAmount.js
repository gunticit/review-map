document.addEventListener("DOMContentLoaded", function () {
    const otherRadio = document.getElementById('depositAmountOther');
    const customAmountInput = document.getElementById('depositAmountCustom');
    const totalAmountElement = document.getElementById('totalAmount');

    function updateTotalAmount() {
        const selectedRadio = document.querySelector('input[name="depositAmount"]:checked');
        let totalAmount = parseInt(selectedRadio.value);

        if (selectedRadio.value === 'other') {
            const customAmount = parseInt(customAmountInput.value) || 0;

            totalAmount = customAmount;
        }

        totalAmountElement.textContent = totalAmount.toLocaleString('vi-VN') + ' VND';
    }
    
    if(otherRadio){
        otherRadio.addEventListener('change', function () {
            if (this.checked) {
                customAmountInput.style.display = 'block';
            }
        });

        customAmountInput.addEventListener('input', updateTotalAmount);

        const radioButtons = document.querySelectorAll('input[name="depositAmount"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function () {
                if (!otherRadio.checked) {
                    customAmountInput.style.display = 'none';
                    customAmountInput.value = '';
                }
                updateTotalAmount();
            });
        });

        updateTotalAmount(); // Initial call to set the total amount based on default selection

    }
});
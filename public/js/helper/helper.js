function formatCurrency(number, currency = 'VND', locale = 'vi-VN') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency,
    }).format(number);
}

function parseCurrency(formattedNumber) {
    const number = formattedNumber
        .replace(/[^\d.-]/g, '')
        .replace(/,/g, ''); 

    return parseFloat(number);
}

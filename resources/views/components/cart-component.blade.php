<span class="btn-cart">
    <span class="material-symbols-outlined">
        shopping_cart
    </span>
    <span class="count">{{ $totalItem }}</span>
</span>
<div id="cart" class="info-cart">`
    <div class="bg-cart">
        @if (!empty($listProduct))
            <ul>
                @foreach ($listProduct as $product)
                    <li class="cart-item">
                        <img src="{{ asset('./assets/img/Rectangle-22794.jpg') }}" alt="image">
                        <div class="info">
                            <p class="name"> {{ $product['name'] }}</p>
                            <p class="price">{{ formatCurrency($product['price']) }}</p>
                            <div>
                                <div style="position: relative;">
                                    <button val-price="{{ $product['price'] }}" style="position: absolute; left: 0" class="btn btn-minus-item"
                                        onclick="minusProductCart(this)"><span
                                            class="material-symbols-outlined">remove</span></button>
                                    <input class="cart-quantity" type="number" name="quantity" min="1" max="100"
                                        value="{{ $product['quantity'] }}" class="quantity" readonly>
                                    <button val-price="{{ $product['price'] }}" style="position: absolute; right: 0; top: 0" class="btn btn-plus-item"
                                        onclick="plusProductCart(this)">
                                        <span class="material-symbols-outlined">
                                            add
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="quantity" style="width:80px">
                            x {{ $product['quantity'] }}
                        </div>
                        <div>
                            <button class="btn-remove-item" onclick="removeItem(this)">
                                <span class="material-symbols-outlined">
                                    backspace
                                </span>
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="total-cart">
                <div class="total">
                    <span class="fw-700">Tổng cộng</span>
                    <span id="cart-total-formatted" val-html="{{ $totalPrice }}">{{ formatCurrency($totalPrice) }}</span>
                </div>
                <div class="btn-checkout">
                    <button class="btn btn-primary">Thanh toán</button>
                </div>
            </div>
        @else
            <div class="text-center">
                <img src="{!! asset('assets/img/empty_cart.jpeg') !!}" alt="" style="max-width: 350px">
                <p>Chưa có sản phẩm trong giỏ hàng</p>
            </div>
        @endif
    </div>
</div>

<style>
    .cart-quantity{
        width: 100%;
        border: 1px solid #ccc;
        text-align: center;
        height: 40px;
        border-radius: 5px;
    }
    .btn-cart {
        position: fixed;
        top: 50%;
        transform: translateY(-50%);
        right: 10px;
        background: #0059a6;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        cursor: pointer;
        z-index: 3;
    }

    .cart-item .name {
        font-weight: bold
    }

    .btn-cart>span {
        position: relative;
        top: 5px;
    }

    .btn-cart>span {
        position: relative;
        top: 5px;
    }

    .btn-cart>span.count {
        position: absolute;
        top: 8px;
        right: 8px;
        height: 20px;
        width: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 50%;
        color: #1364ef;
        font-weight: bold;
        font-size: 12px;
    }

    .info-cart {
        width: 480px;
        height: 500px;
        position: fixed;
        top: 50%;
        transform: translateY(-50%);
        right: -200%;
        visibility: hidden;
        background: #fff;
        box-shadow: -5px -2.5px 10px #cdd0e2;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        padding: 10px;
        transition: all 0.4s ease;
        z-index: 3;
    }

    .bg-cart {
        position: relative;
        height: 100%;
        width: 100%;
    }

    .info-cart.show-cart {
        right: 0%;
        visibility: visible;
    }

    .info-cart ul {
        list-style: none;
        overflow: auto;
        height: 100%;
        width: 100%;
        padding-left: 0;
        position: relative;
    }

    .info-cart ul>li {
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
    }

    .info-cart ul>li:last-child {
        margin-bottom: 70px
    }

    .info-cart ul>li img {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        object-fit: cover;
    }

    .info-cart ul>li .info {
        flex: 1;
    }

    .info-cart ul>li .info p {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .cart-item {
        display: flex;
        gap: 10px;
    }

    .cart-item>img {
        width: 33%;
    }

    .cart-item>.info {
        flex: 1;
    }

    .cart-item .quantity {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
    }

    .info-cart li .btn-remove-item {
        display: flex;
        border: none;
        transition: all 0.4s ease;
    }

    .info-cart li .btn-remove-item>span {
        font-size: 18px;
        color: #737373;
    }

    .info-cart li .btn-remove-item:hover {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        background: #f74848;
    }

    .info-cart li .btn-remove-item:hover span {
        color: #fff;
    }
    .btn-minus-item, .btn-plus-item{
        position: absolute;
        padding: 0;
        height: 40px;
        border-radius: 8px;
        width: 40px;
    }
    .btn-minus-item{
        left: 0;
    }
    .btn-plus-item{
        right: 0;
    }
    .total-cart {
        position: absolute;
        background: #fff;
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding-top: 10px;
        bottom: 0;
        left: 0;
        border-top: 1px solid #c2c2c2;
    }

    #cart-total-formatted {
        margin: 0;
        font-weight: bold;
        color: #e61313;
    }
</style>
<script>
    function addToCart(id, button, quantity = 1) {
        button.disabled = true;
        button.textContent = 'Đang thêm...';
        $.ajax({
            url: "{{ route('ajax.cart.add') }}",
            type: "POST",
            data: {
                '_token': '{{ csrf_token() }}',
                'product_id': id,
                'quantity': quantity,
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    showAlert('success', data.message);
                    $('#cart *').remove();
                    const listProduct = data?.data?.list_product;
                    console.log('zxc', listProduct);
                    listProduct.forEach((product) => {
                        const productHTML = `
                        <div class="cart-item">
                            <img src="https://doitac.rivi.com.vn/./assets/img/Rectangle-22794.jpg" alt="image">
                            <div class="info">
                                <p class="name">${product.name}</p>
                                <p class="price">${product.price} VND</p>
                            </div>
                            <div class="quantity">
                                x ${product.pivot.quantity}
                            </div>
                            <div>
                                <button class="btn-remove-item" onclick="removeItem(this)">
                                    <span class="material-symbols-outlined">
                                        backspace
                                    </span>
                                </button>
                            </div>
                        </div>`;
                        $('#cart.info-cart').append(productHTML);
                    });
                } else {
                    showAlert('error', data.message);
                }
            },
            complete: function() {
                button.disabled = false;
                button.textContent = 'Thêm vào giỏ';
            }
        });
    }

    function removeItem(element) {

    }
    $(document).ready(function() {
        $('.btn-cart').on('click', function(e) {
            e.stopPropagation();
            $(this).fadeOut();
            $('#cart').addClass('show-cart');
            $(this).delay(1000).fadeIn();
        });
        $('.info-cart').on('click', function(e) {
            e.stopPropagation();
        });
        $('body').on('click', function() {
            $('.info-cart').removeClass('show-cart');
        });
    })
    function minusProductCart(element) {
        let minusBtn = $(element);
        let quantityInput = minusBtn.closest('.cart-item').find('.cart-quantity');
        let quantity = parseInt(quantityInput.val());   
        if (quantity > 1) {
            quantityInput.val(quantity - 1);
        }
        minusBtn.closest('.cart-item').find('.quantity').html('x ' + quantityInput.val());
        let price = minusBtn.attr('val-price');
        let total = $('#cart-total-formatted').attr('val-html'); // đang tính total
    }
    function plusProductCart(element) {
        let plusBtn = $(element);
        let quantityInput = plusBtn.closest('.cart-item').find('.cart-quantity');
        let quantity = parseInt(quantityInput.val());
        quantityInput.val(quantity + 1);
        plusBtn.closest('.cart-item').find('.quantity').html('x ' + quantityInput.val());
    }
</script>

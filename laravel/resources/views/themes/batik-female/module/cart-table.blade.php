<div class="table-responsive bottommargin">
    <table class="table cart">
        <thead>
            <tr>
                <th class="cart-product-remove"> </th>
                <th class="cart-product-thumbnail"> </th>
                <th class="cart-product-name">Product</th>
                <th class="cart-product-price">Unit Price</th>
                <th class="cart-product-quantity">Quantity</th>
                <th class="cart-product-subtotal">Total</th>
            </tr>
        </thead>
        <tbody id="cartbody">

            <?php $totalcart  = 0; ?>
            @foreach($carts as $cart)
            <tr class="cart_item" id="{{ $cart->rowId }}">
                <td class="cart-product-remove">
                    <a href="javascript:void(0)" class="remove" title="Remove this item" onclick="removerow('{{ $cart->rowId }}')"><i class="icon-trash2"></i></a>
                </td>
                <td class="cart-product-thumbnail">
                    <a href="{{ url('products/'.$cart->options['url']) }}"><img width="64" height="64" src="{{ asset($cart->options['image']) }}" alt="{{ $cart->name }}"></a>
                </td>
                <td class="cart-product-name">
                    <a href="{{ url('products/'.$cart->options['url']) }}">{{ $cart->name }}</a>
                </td>
                <td class="cart-product-price">
                    <span class="amount"><?= number_format($cart->price,0,',','.') ?></span>
                </td>
                <td class="cart-product-quantity">
                    <div class="quantity clearfix">
                        <input type="button" value="-" class="minus" onclick="getquantity('{{ $cart->rowId }}','minus')">
                        <input type="text" name="quantity" class="qty" value="{{ $cart->qty }}"/>
                        <input type="button" value="+" class="plus" onclick="getquantity('{{ $cart->rowId }}','plus')">
                    </div>
                </td>
                <td class="cart-product-subtotal">
                    <span class="amount"><?= number_format($cart->qty*$cart->price,0,',','.') ?></span>
                </td>
            </tr>
            <?php $totalcart = $totalcart + ($cart->price*$cart->qty); ?>
            @endforeach

        </tbody>
    </table>
</div>

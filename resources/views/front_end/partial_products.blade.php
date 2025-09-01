@foreach($products as $product)
    @include('front_end.product_card', ['product' => $product])
@endforeach

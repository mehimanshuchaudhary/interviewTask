<x-mail::message>
    # New Product Added

    A new product has been added to the system.

    **Name:** {{ $product->name }}
    **Price:** ${{ number_format($product->price, 2) }}
    **Stock:** {{ $product->stock }}

    **Description:**
    {{ $product->description }}

    <x-mail::button :url="route('products.index')">
        View Products
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>

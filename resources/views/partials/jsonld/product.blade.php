@php
$productData = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => strip_tags($product->description ?? ''),
    'url' => route('product.show', $product->slug),
    'brand' => ['@type' => 'Brand', 'name' => 'BestProf'],
    'category' => $product->category->name ?? '',
];
if ($product->image) {
    $productData['image'] = asset('storage/' . $product->image);
}
if ($product->price) {
    $productData['offers'] = [
        '@type' => 'Offer',
        'price' => (string) $product->price,
        'priceCurrency' => 'KZT',
        'availability' => 'https://schema.org/' . match($product->availability) {
            'in_stock' => 'InStock',
            'on_order' => 'PreOrder',
            default => 'OutOfStock',
        },
        'url' => route('product.show', $product->slug),
    ];
}
@endphp
<script type="application/ld+json">{!! json_encode($productData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>

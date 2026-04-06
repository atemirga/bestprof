@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
@php
$items = [];
foreach ($breadcrumbs as $i => $crumb) {
    $items[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['name'],
        'item' => $crumb['url'],
    ];
}
$bcData = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $items,
];
@endphp
<script type="application/ld+json">{!! json_encode($bcData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endif

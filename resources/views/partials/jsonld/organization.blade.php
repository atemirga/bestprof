@php
$orgData = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $settings['company_name'] ?? 'BestProf',
    'url' => url('/'),
    'logo' => asset('img/favicon.svg'),
    'description' => $settings['meta_description'] ?? '',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Алматы',
        'addressCountry' => 'KZ',
        'streetAddress' => $settings['address'] ?? '',
    ],
    'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => $settings['phone'] ?? '',
        'email' => $settings['email'] ?? '',
        'contactType' => 'customer service',
    ],
];
if (!empty($settings['instagram']) && $settings['instagram'] !== '#') {
    $orgData['sameAs'] = [$settings['instagram']];
}
@endphp
<script type="application/ld+json">{!! json_encode($orgData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>

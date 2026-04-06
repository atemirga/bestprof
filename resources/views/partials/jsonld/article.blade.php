@php
$articleData = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->title,
    'description' => $post->excerpt ?? mb_substr(strip_tags($post->content), 0, 160),
    'url' => route('post.show', $post->slug),
    'datePublished' => $post->published_at?->toIso8601String(),
    'dateModified' => $post->updated_at->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => 'BestProf'],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'BestProf',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('img/favicon.svg')],
    ],
];
if ($post->image) {
    $articleData['image'] = asset('storage/' . $post->image);
}
@endphp
<script type="application/ld+json">{!! json_encode($articleData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>

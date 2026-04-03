<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $settings['meta_description'] ?? '' }}">
  <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
  <title>{{ $settings['site_name'] ?? 'BestProf' }} — {{ $settings['site_tagline'] ?? '' }}</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
  <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sections.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  @stack('styles')
</head>
<body>

<header class="header" id="header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo">
      <div class="logo-mark"></div>
      <div class="logo-text">Best<span>Prof</span></div>
    </a>
    <ul class="nav-menu">
      <li><a href="{{ route('home') }}#about">О компании</a></li>
      <li><a href="{{ route('catalog') }}">Каталог</a></li>
      <li><a href="{{ route('projects') }}">Наши работы</a></li>
      <li><a href="{{ route('news') }}">Новости</a></li>
      <li><a href="{{ route('home') }}#contact">Контакты</a></li>
    </ul>
    <a href="{{ route('home') }}#contact" class="header-cta">
      Оставить заявку
      <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3 8h10m-4-4l4 4-4 4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
    <button class="mobile-toggle" id="mobileToggle"><span></span><span></span><span></span></button>
  </div>
</header>

@yield('content')

<footer class="footer">
  <div class="container">
    <div class="footer-main">
      <div>
        <a href="{{ route('home') }}" class="logo" style="margin-bottom:0;">
          <div class="logo-mark"></div>
          <div class="logo-text" style="color:#fff;">Best<span>Prof</span></div>
        </a>
        @if(isset($blocks['footer']))
          <p class="footer-brand-text">{{ $blocks['footer']->content }}</p>
        @endif
      </div>
      <div>
        <h5>Продукция</h5>
        <ul class="footer-links">
          @if(isset($blocks['footer']) && isset($blocks['footer']->data['product_links']))
            @foreach($blocks['footer']->data['product_links'] as $link)
              <li><a href="#">{{ $link }}</a></li>
            @endforeach
          @endif
        </ul>
      </div>
      <div>
        <h5>Компания</h5>
        <ul class="footer-links">
          @if(isset($blocks['footer']) && isset($blocks['footer']->data['company_links']))
            @foreach($blocks['footer']->data['company_links'] as $link)
              <li><a href="#">{{ $link }}</a></li>
            @endforeach
          @endif
        </ul>
      </div>
      <div>
        <h5>Контакты</h5>
        <div class="footer-contact-item">
          <div class="footer-contact-label">Телефон</div>
          <div class="footer-contact-val"><a href="tel:{{ preg_replace('/[^\d+]/', '', $settings['phone'] ?? '') }}">{{ $settings['phone'] ?? '' }}</a></div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-label">Email</div>
          <div class="footer-contact-val"><a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a></div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-label">Адрес</div>
          <div class="footer-contact-val">{{ $settings['address'] ?? '' }}</div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-label">Режим работы</div>
          <div class="footer-contact-val">{{ $settings['hours'] ?? '' }}</div>
        </div>
        <div class="footer-contact-item" style="margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.05);">
          <div class="footer-contact-label">Реквизиты</div>
          <div class="footer-contact-val" style="font-size:0.78rem;line-height:1.8;">
            {{ $settings['company_name'] ?? '' }}<br>
            БИН: {{ $settings['bin'] ?? '' }}<br>
            {{ $settings['bank'] ?? '' }}<br>
            КБе: {{ $settings['kbe'] ?? '' }} · БИК: {{ $settings['bik'] ?? '' }}<br>
            ИИК: {{ $settings['iik'] ?? '' }}
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">&copy; {{ date('Y') }} {{ $settings['company_name'] ?? 'BestProf' }}. Все права защищены.</span>
      <div class="footer-socials">
        <a href="{{ $settings['instagram'] ?? '#' }}" class="footer-social"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
        <a href="{{ $settings['twitter'] ?? '#' }}" class="footer-social"><svg viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 01-1.93.07 4.28 4.28 0 004 2.98 8.521 8.521 0 01-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg></a>
      </div>
    </div>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Sticky header
  const header = document.getElementById('header');
  if (header) {
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => { header.classList.toggle('scrolled', window.scrollY > 10); ticking = false; });
        ticking = true;
      }
    });
  }
  // Mobile menu
  const toggle = document.getElementById('mobileToggle');
  if (toggle) {
    toggle.addEventListener('click', () => {
      document.body.classList.toggle('menu-open');
      document.querySelector('.nav-menu')?.classList.toggle('mobile-active');
      toggle.classList.toggle('active');
    });
  }
  // Scroll reveal
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('shown'); observer.unobserve(e.target); } });
  }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  // Smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      e.preventDefault();
      const t = document.querySelector(a.getAttribute('href'));
      if (t) { const off = header ? header.offsetHeight + 10 : 80; window.scrollTo({ top: t.getBoundingClientRect().top + window.scrollY - off, behavior: 'smooth' }); }
      document.body.classList.remove('menu-open');
    });
  });
});
</script>
@stack('scripts')
</body>
</html>

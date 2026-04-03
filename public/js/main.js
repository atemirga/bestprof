/**
 * BestProf Corporate Website
 * Main JavaScript Module — Dynamic rendering from DataStore
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  App.init();
});

const App = {

  data: null,

  init() {
    this.data = DataStore.load();
    this.Render.init(this.data);
    this.Header.init();
    this.ScrollReveal.init();
    this.SmoothScroll.init();
    this.CatalogTabs.init(this.data);
    this.MobileMenu.init();
    this.ContactForm.init(this.data);
  },

  /**
   * Render all dynamic content from data store
   */
  Render: {
    init(data) {
      this.renderMeta(data);
      this.renderNavDropdown(data);
      this.renderHero(data);
      this.renderAbout(data);
      this.renderFeatures(data);
      this.renderCatalog(data);
      this.renderProducts(data);
      this.renderServices(data);
      this.renderPartners(data);
      this.renderContact(data);
      this.renderFooter(data);
    },

    renderMeta(data) {
      const s = data.siteSettings;
      document.title = s.siteName + ' — ' + s.siteTagline;
      const metaDesc = document.querySelector('meta[name="description"]');
      if (metaDesc) metaDesc.setAttribute('content', s.metaDescription);
      const metaKw = document.querySelector('meta[name="keywords"]');
      if (metaKw) metaKw.setAttribute('content', s.metaKeywords);
    },

    renderNavDropdown(data) {
      const dd = document.getElementById('navDropdown');
      if (!dd) return;
      const flat = DataStore.flattenCategories(data.categories);
      dd.innerHTML = flat.map(c =>
        `<a href="#catalog" data-cat-filter="${c.id}" style="padding-left:${c.depth * 1}rem">${c.name}</a>`
      ).join('');
    },

    renderHero(data) {
      const h = data.heroSection;
      const el = (id, val) => { const e = document.getElementById(id); if (e) e.innerHTML = val; };
      el('heroTagText', h.tag);
      el('heroTitle', h.title);
      el('heroDesc', h.description);
      el('heroBtnPrimary', h.btnPrimary);
      el('heroBtnSecondary', h.btnSecondary);

      const metricsEl = document.getElementById('heroMetrics');
      if (metricsEl) {
        metricsEl.innerHTML = h.metrics.map(m => `
          <div class="hero-metric">
            <div class="hero-metric-val">${m.value}</div>
            <div class="hero-metric-label">${m.label}</div>
          </div>
        `).join('');
      }
    },

    renderAbout(data) {
      const a = data.aboutSection;
      const el = (id, val) => { const e = document.getElementById(id); if (e) e.innerHTML = val; };
      el('aboutLabel', a.label);
      el('aboutTitle', a.title);
      el('aboutDesc', a.description);
      el('aboutDesc2', a.description2);

      const statsEl = document.getElementById('aboutStats');
      if (statsEl) {
        statsEl.innerHTML = a.stats.map(s => `
          <div class="about-stat">
            <div class="about-stat-val">${s.value}</div>
            <div class="about-stat-label">${s.label}</div>
          </div>
        `).join('');
      }
    },

    renderFeatures(data) {
      const row = document.getElementById('featuresRow');
      if (!row) return;
      const icons = [
        '<svg viewBox="0 0 20 20" fill="none"><path d="M10 2l2.5 5 5.5.8-4 3.9.9 5.3-4.9-2.6-4.9 2.6.9-5.3-4-3.9 5.5-.8L10 2z" fill="white"/></svg>',
        '<svg viewBox="0 0 20 20" fill="none"><path d="M4 4h12v12H4V4z" stroke="white" stroke-width="1.5"/><path d="M4 10h12M10 4v12" stroke="white" stroke-width="1"/></svg>',
        '<svg viewBox="0 0 20 20" fill="none"><path d="M3 10l5 5L17 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 20 20" fill="none"><path d="M10 2v8l4 4" stroke="white" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="10" r="8" stroke="white" stroke-width="1.5"/></svg>'
      ];
      row.innerHTML = data.featuresStrip.map((f, i) => `
        <div class="feature-cell">
          <div class="feature-cell-icon">${icons[i % icons.length]}</div>
          <h4>${f.title}</h4>
          <p>${f.description}</p>
        </div>
      `).join('');
    },

    renderCatalog(data) {
      const el = (id, val) => { const e = document.getElementById(id); if (e) e.innerHTML = val; };
      el('catalogLabel', data.catalogSection.label);
      el('catalogTitle', data.catalogSection.title);
      el('catalogDesc', data.catalogSection.description);

      // Build tree-based tabs
      const tabsEl = document.getElementById('catalogTabs');
      if (!tabsEl) return;

      let tabsHtml = '<span class="cat-tab active" data-filter="">Все системы</span>';

      for (const cat of data.categories) {
        tabsHtml += `<span class="cat-tab" data-filter="${cat.id}">${cat.name}</span>`;
        if (cat.children) {
          for (const sub of cat.children) {
            tabsHtml += `<span class="cat-tab cat-tab-sub" data-filter="${sub.id}">${sub.name}</span>`;
          }
        }
      }
      tabsEl.innerHTML = tabsHtml;
    },

    renderProducts(data) {
      const grid = document.getElementById('productsGrid');
      if (!grid) return;

      const defaultSvg = '<svg viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" stroke="currentColor" fill="none" stroke-width="1.5"/><line x1="24" y1="4" x2="24" y2="44" stroke="currentColor" stroke-width="1" opacity="0.5"/></svg>';

      const sorted = [...data.products].sort((a, b) => (a.sortOrder || 0) - (b.sortOrder || 0));

      grid.innerHTML = sorted.map(p => {
        const imgStyle = p.cardBg ? `style="background: ${p.cardBg};"` : '';
        const badgeStyle = p.badgeColor ? `style="background: ${p.badgeColor};"` : '';
        const typeColor = p.badgeColor && p.badgeColor !== '#00074B' ? `style="color: ${p.badgeColor};"` : '';
        const priceHtml = p.price > 0
          ? `<div class="product-card-price">${p.price.toLocaleString()} тг</div>`
          : (p.priceDisplay ? `<div class="product-card-price">${p.priceDisplay}</div>` : '');
        const availClass = p.availability === 'out_of_stock' ? ' out-of-stock' : '';

        return `
          <div class="product-card reveal${availClass}" data-category="${p.subcategoryId}" data-parent-category="${p.categoryId}">
            <div class="product-card-img" ${imgStyle}>
              <div class="product-card-badge" ${badgeStyle}>${p.badge}</div>
              ${p.imageUrl ? `<img src="${p.imageUrl}" alt="${p.name}">` : defaultSvg}
            </div>
            <div class="product-card-body">
              <div class="product-card-type" ${typeColor}>${p.type}</div>
              <div class="product-card-name">${p.name}</div>
              <div class="product-card-desc">${p.description}</div>
              ${priceHtml}
              <div class="product-card-specs">
                ${p.specs.map(s => `<span class="spec-chip">${s}</span>`).join('')}
              </div>
            </div>
            <div class="product-card-footer">
              <span class="product-card-link">Подробнее <svg viewBox="0 0 14 14"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg></span>
              <span class="product-card-hardware">${p.hardware}</span>
            </div>
          </div>
        `;
      }).join('');
    },

    renderServices(data) {
      const el = (id, val) => { const e = document.getElementById(id); if (e) e.innerHTML = val; };
      el('servicesLabel', data.servicesSection.label);
      el('servicesTitle', data.servicesSection.title);
      el('servicesDesc', data.servicesSection.description);

      const grid = document.getElementById('servicesGrid');
      if (!grid) return;
      const icons = [
        '<svg viewBox="0 0 22 22" fill="none"><path d="M3 19V7l8-5 8 5v12H3zm6-8v8m4-8v8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M11 2v3m0 12v3m-9-9h3m12 0h3m-2.5-6.5l-2 2m-9 9l-2 2m13 0l-2-2m-9-9l-2-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M4 17V5a2 2 0 012-2h10a2 2 0 012 2v12M2 17h18M7 9h8M7 13h5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M5 3h12a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zm4 6l2 2 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M14 2l5 5-12 12H2v-5L14 2z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M17 8l-5 5-3-3-4 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 8h3v3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
      ];
      grid.innerHTML = data.services.map((s, i) => `
        <div class="service-card reveal">
          <div class="service-icon">${icons[i % icons.length]}</div>
          <h3>${s.title}</h3>
          <p>${s.description}</p>
        </div>
      `).join('');
    },

    renderPartners(data) {
      const el = (id, val) => { const e = document.getElementById(id); if (e) e.innerHTML = val; };
      el('partnersLabel', data.partnersSection.label);
      el('partnersTitle', data.partnersSection.title);
      el('partnersDesc', data.partnersSection.description);

      const grid = document.getElementById('partnersGrid');
      if (grid) {
        grid.innerHTML = data.partners.map(p => `<span class="partner-item">${p}</span>`).join('');
      }
    },

    renderContact(data) {
      const c = data.contactSection;
      const info = data.contactInfo;
      const el = (id, val) => { const e = document.getElementById(id); if (e) e.innerHTML = val; };

      el('contactLabel', c.label);
      el('contactTitle', c.title);
      el('contactDesc', c.description);
      el('contactFormTitle', c.formTitle);

      const btn = document.getElementById('formSubmitBtn');
      if (btn) btn.textContent = c.formButton;

      const row = document.getElementById('contactInfoRow');
      if (row) {
        row.innerHTML = `
          <div class="cta-info-item">
            <h5>Телефон</h5>
            <a href="${info.phoneLink}">${info.phone}</a>
          </div>
          <div class="cta-info-item">
            <h5>Email</h5>
            <a href="${info.emailLink}">${info.email}</a>
          </div>
          <div class="cta-info-item">
            <h5>Адрес</h5>
            <p>${info.address}</p>
          </div>
        `;
      }
    },

    renderFooter(data) {
      const info = data.contactInfo;
      const comp = data.companyDetails;
      const social = data.socialLinks;

      const footerMain = document.getElementById('footerMain');
      if (footerMain) {
        footerMain.innerHTML = `
          <div>
            <a href="#" class="logo" style="margin-bottom: 0;">
              <div class="logo-mark"></div>
              <div class="logo-text" style="color: #fff;">Best<span>Prof</span></div>
            </a>
            <p class="footer-brand-text">${data.footerText}</p>
          </div>
          <div>
            <h5>Продукция</h5>
            <ul class="footer-links">
              ${data.footerProducts.map(p => `<li><a href="#">${p}</a></li>`).join('')}
            </ul>
          </div>
          <div>
            <h5>Компания</h5>
            <ul class="footer-links">
              ${data.footerCompanyLinks.map(l => `<li><a href="#">${l}</a></li>`).join('')}
            </ul>
          </div>
          <div>
            <h5>Контакты</h5>
            <div class="footer-contact-item">
              <div class="footer-contact-label">Телефон</div>
              <div class="footer-contact-val"><a href="${info.phoneLink}">${info.phone}</a></div>
            </div>
            <div class="footer-contact-item">
              <div class="footer-contact-label">Email</div>
              <div class="footer-contact-val"><a href="${info.emailLink}">${info.email}</a></div>
            </div>
            <div class="footer-contact-item">
              <div class="footer-contact-label">Адрес</div>
              <div class="footer-contact-val">${info.address}</div>
            </div>
            <div class="footer-contact-item">
              <div class="footer-contact-label">Режим работы</div>
              <div class="footer-contact-val">${info.hours}</div>
            </div>
            <div class="footer-contact-item" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">
              <div class="footer-contact-label">Реквизиты</div>
              <div class="footer-contact-val" style="font-size: 0.78rem; line-height: 1.8;">
                ${comp.name}<br>
                БИН: ${comp.bin}<br>
                ${comp.bank}<br>
                КБе: ${comp.kbe} · БИК: ${comp.bik}<br>
                ИИК: ${comp.iik}
              </div>
            </div>
          </div>
        `;
      }

      const footerBottom = document.getElementById('footerBottom');
      if (footerBottom) {
        footerBottom.innerHTML = `
          <span class="footer-copy">&copy; ${new Date().getFullYear()} ${comp.name}. БИН: ${comp.bin}. Все права защищены.</span>
          <div class="footer-socials">
            <a href="${social.instagram}" class="footer-social"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
            <a href="${social.twitter}" class="footer-social"><svg viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 01-1.93.07 4.28 4.28 0 004 2.98 8.521 8.521 0 01-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg></a>
            <a href="${social.github}" class="footer-social"><svg viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.6.111.82-.26.82-.577 0-.286-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.627-5.373-12-12-12z"/></svg></a>
          </div>
        `;
      }
    }
  },

  /**
   * Sticky header with shadow on scroll
   */
  Header: {
    init() {
      const header = document.getElementById('header');
      if (!header) return;
      let ticking = false;
      window.addEventListener('scroll', () => {
        if (!ticking) {
          requestAnimationFrame(() => {
            header.classList.toggle('scrolled', window.scrollY > 10);
            ticking = false;
          });
          ticking = true;
        }
      });
    }
  },

  /**
   * Intersection Observer based scroll reveal
   */
  ScrollReveal: {
    init() {
      const elements = document.querySelectorAll('.reveal');
      if (!elements.length) return;
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('shown');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
      elements.forEach(el => observer.observe(el));
    }
  },

  /**
   * Smooth scroll for anchor links
   */
  SmoothScroll: {
    init() {
      const header = document.getElementById('header');
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
          e.preventDefault();
          const targetId = anchor.getAttribute('href');
          const target = document.querySelector(targetId);
          if (target) {
            const offset = header ? header.offsetHeight + 10 : 80;
            const position = target.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: position, behavior: 'smooth' });
          }
          document.body.classList.remove('menu-open');
        });
      });
    }
  },

  /**
   * Catalog category tabs with tree support
   */
  CatalogTabs: {
    init(data) {
      const tabs = document.querySelectorAll('.cat-tab');
      const grid = document.getElementById('productsGrid');
      if (!tabs.length || !grid) return;

      // Build a map: category id -> set of all descendant subcategory ids
      const childMap = {};
      const buildChildMap = (cats) => {
        for (const cat of cats) {
          const ids = new Set();
          const collect = (c) => {
            ids.add(c.id);
            if (c.children) c.children.forEach(collect);
          };
          collect(cat);
          childMap[cat.id] = ids;
          if (cat.children) buildChildMap(cat.children);
        }
      };
      buildChildMap(data.categories);

      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('active'));
          tab.classList.add('active');

          const filter = tab.dataset.filter;
          const cards = grid.querySelectorAll('.product-card');

          cards.forEach(card => {
            if (!filter) {
              card.style.display = '';
              return;
            }
            const cardCat = card.dataset.category;
            const parentCat = card.dataset.parentCategory;

            // Show if card matches filter directly, or its parent/subcategory is in the filter's children
            const filterIds = childMap[filter];
            if (filterIds && (filterIds.has(cardCat) || filterIds.has(parentCat))) {
              card.style.display = '';
            } else if (cardCat === filter || parentCat === filter) {
              card.style.display = '';
            } else {
              card.style.display = 'none';
            }
          });
        });
      });
    }
  },

  /**
   * Mobile hamburger menu
   */
  MobileMenu: {
    init() {
      const toggle = document.getElementById('mobileToggle');
      const nav = document.querySelector('.nav-menu');
      if (!toggle || !nav) return;
      toggle.addEventListener('click', () => {
        document.body.classList.toggle('menu-open');
        nav.classList.toggle('mobile-active');
        toggle.classList.toggle('active');
      });
    }
  },

  /**
   * Contact form handling
   */
  ContactForm: {
    init(data) {
      const form = document.querySelector('.cta-form-card');
      if (!form) return;

      const submitBtn = form.querySelector('.form-submit');
      if (!submitBtn) return;

      const successText = 'Отправлено \u2713';

      submitBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const inputs = form.querySelectorAll('.form-input');
        let isValid = true;

        inputs.forEach(input => {
          input.classList.remove('error');
          if (input.hasAttribute('required') && !input.value.trim()) {
            input.classList.add('error');
            isValid = false;
          }
        });

        if (isValid) {
          submitBtn.textContent = successText;
          submitBtn.disabled = true;
          submitBtn.style.background = '#10B981';
          setTimeout(() => {
            submitBtn.textContent = data.contactSection.formButton;
            submitBtn.disabled = false;
            submitBtn.style.background = '';
            inputs.forEach(input => { input.value = ''; });
          }, 3000);
        }
      });

      // Phone mask
      const phoneInput = form.querySelector('input[type="tel"]');
      if (phoneInput) {
        phoneInput.addEventListener('input', (e) => {
          let val = e.target.value.replace(/\D/g, '');
          if (val.startsWith('7') || val.startsWith('8')) val = val.substring(1);
          if (val.length > 0) {
            let formatted = '+7';
            if (val.length > 0) formatted += ' (' + val.substring(0, 3);
            if (val.length >= 3) formatted += ') ' + val.substring(3, 6);
            if (val.length >= 6) formatted += '-' + val.substring(6, 8);
            if (val.length >= 8) formatted += '-' + val.substring(8, 10);
            e.target.value = formatted;
          }
        });
      }
    }
  }
};

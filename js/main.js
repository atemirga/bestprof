/**
 * BestProf Corporate Website
 * Main JavaScript Module
 * ========================
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  App.init();
});

const App = {

  init() {
    this.Header.init();
    this.ScrollReveal.init();
    this.SmoothScroll.init();
    this.CatalogTabs.init();
    this.MobileMenu.init();
    this.ContactForm.init();
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
      }, {
        threshold: 0.08,
        rootMargin: '0px 0px -40px 0px'
      });

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

          // Close mobile menu if open
          document.body.classList.remove('menu-open');
        });
      });
    }
  },

  /**
   * Catalog category tabs (filter UI)
   */
  CatalogTabs: {
    init() {
      const tabs = document.querySelectorAll('.cat-tab');
      if (!tabs.length) return;

      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('active'));
          tab.classList.add('active');
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
    init() {
      const form = document.querySelector('.cta-form-card');
      if (!form) return;

      const submitBtn = form.querySelector('.form-submit');
      if (!submitBtn) return;

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
          submitBtn.textContent = 'Отправлено ✓';
          submitBtn.disabled = true;
          submitBtn.style.background = '#10B981';

          setTimeout(() => {
            submitBtn.textContent = 'Отправить заявку';
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
          if (val.startsWith('7') || val.startsWith('8')) {
            val = val.substring(1);
          }
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

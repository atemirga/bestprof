/**
 * BestProf Admin Panel
 * Full site management through localStorage-backed DataStore
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  Admin.init();
});

const Admin = {

  data: null,
  currentSection: 'dashboard',

  init() {
    this.data = DataStore.load();
    this.Auth.init(this);
  },

  boot() {
    document.getElementById('loginOverlay').style.display = 'none';
    document.getElementById('adminLayout').style.display = 'flex';
    this.Nav.init(this);
    this.Modal.init();
    this.Toast.init();
    this.renderSection('dashboard');
  },

  save() {
    DataStore.save(this.data);
    this.Toast.show('Сохранено', 'success');
  },

  // ══════════ AUTH ══════════
  Auth: {
    init(admin) {
      const saved = sessionStorage.getItem('bp_admin_auth');
      if (saved === 'true') { admin.boot(); return; }

      document.getElementById('loginForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const pw = document.getElementById('loginPassword').value;
        if (pw === admin.data.siteSettings.adminPassword) {
          sessionStorage.setItem('bp_admin_auth', 'true');
          admin.boot();
        } else {
          document.getElementById('loginError').style.display = 'block';
        }
      });
    }
  },

  // ══════════ NAVIGATION ══════════
  Nav: {
    init(admin) {
      const navItems = document.querySelectorAll('.nav-item');
      const headerTitle = document.getElementById('headerTitle');
      const toggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');

      navItems.forEach(item => {
        item.addEventListener('click', (e) => {
          e.preventDefault();
          const section = item.dataset.section;
          navItems.forEach(n => n.classList.remove('active'));
          item.classList.add('active');
          headerTitle.textContent = item.querySelector('.nav-label').textContent;
          admin.renderSection(section);
          sidebar.classList.remove('open');
        });
      });

      toggle.addEventListener('click', () => sidebar.classList.toggle('open'));

      document.getElementById('logoutBtn').addEventListener('click', () => {
        sessionStorage.removeItem('bp_admin_auth');
        location.reload();
      });
    }
  },

  // ══════════ MODAL ══════════
  Modal: {
    init() {
      const overlay = document.getElementById('modal');
      document.getElementById('modalClose').addEventListener('click', () => this.close());
      overlay.addEventListener('click', (e) => { if (e.target === overlay) this.close(); });
    },
    open(html) {
      document.getElementById('modalBody').innerHTML = html;
      document.getElementById('modal').style.display = 'flex';
    },
    close() {
      document.getElementById('modal').style.display = 'none';
      document.getElementById('modalBody').innerHTML = '';
    }
  },

  // ══════════ CONFIRM ══════════
  confirm(msg) {
    return new Promise((resolve) => {
      const d = document.getElementById('confirmDialog');
      document.getElementById('confirmMessage').textContent = msg;
      d.style.display = 'flex';
      const yes = document.getElementById('confirmYes');
      const no = document.getElementById('confirmNo');
      const cleanup = () => { d.style.display = 'none'; yes.replaceWith(yes.cloneNode(true)); no.replaceWith(no.cloneNode(true)); };
      document.getElementById('confirmYes').addEventListener('click', () => { cleanup(); resolve(true); });
      document.getElementById('confirmNo').addEventListener('click', () => { cleanup(); resolve(false); });
    });
  },

  // ══════════ TOAST ══════════
  Toast: {
    el: null,
    init() {
      const t = document.createElement('div');
      t.className = 'toast';
      document.body.appendChild(t);
      this.el = t;
    },
    show(msg, type = 'success') {
      this.el.textContent = msg;
      this.el.className = 'toast ' + type + ' show';
      setTimeout(() => this.el.classList.remove('show'), 2500);
    }
  },

  // ══════════ RENDER SECTION ══════════
  renderSection(section) {
    this.currentSection = section;
    document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));

    const sectionMap = {
      dashboard: 'Dashboard',
      categories: 'Categories',
      products: 'Products',
      siteSettings: 'SiteSettings',
      heroSection: 'HeroSection',
      aboutSection: 'AboutSection',
      features: 'Features',
      catalogSettings: 'CatalogSettings',
      services: 'Services',
      partners: 'Partners',
      contactSection: 'ContactSection',
      contactInfo: 'ContactInfo',
      companyDetails: 'CompanyDetails',
      footer: 'Footer'
    };

    const id = 'section' + sectionMap[section];
    const el = document.getElementById(id);
    if (el) el.classList.add('active');

    const renderFn = 'render' + sectionMap[section];
    if (this.Sections[renderFn]) this.Sections[renderFn](this);
  },

  // ══════════ FORM HELPERS ══════════
  H: {
    field(label, name, value, type = 'text', hint = '') {
      return `<div class="admin-form-group">
        <label>${label}</label>
        <input type="${type}" name="${name}" value="${this.esc(value || '')}" />
        ${hint ? `<div class="form-hint">${hint}</div>` : ''}
      </div>`;
    },
    textarea(label, name, value, hint = '') {
      return `<div class="admin-form-group">
        <label>${label}</label>
        <textarea name="${name}" rows="3">${this.esc(value || '')}</textarea>
        ${hint ? `<div class="form-hint">${hint}</div>` : ''}
      </div>`;
    },
    select(label, name, value, options) {
      const opts = options.map(o => {
        const val = typeof o === 'object' ? o.value : o;
        const text = typeof o === 'object' ? o.text : o;
        return `<option value="${val}" ${val === value ? 'selected' : ''}>${text}</option>`;
      }).join('');
      return `<div class="admin-form-group"><label>${label}</label><select name="${name}">${opts}</select></div>`;
    },
    esc(s) {
      if (typeof s !== 'string') return s;
      return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    },
    formData(form) {
      const data = {};
      form.querySelectorAll('input, textarea, select').forEach(el => {
        if (el.name) data[el.name] = el.value;
      });
      return data;
    }
  },

  // ══════════ SECTIONS ══════════
  Sections: {

    // ── DASHBOARD ──
    renderDashboard(admin) {
      const d = admin.data;
      const cats = DataStore.flattenCategories(d.categories);
      const stats = document.getElementById('dashboardStats');
      stats.innerHTML = `
        <div class="stat-card"><div class="stat-val">${d.products.length}</div><div class="stat-label">Продуктов</div></div>
        <div class="stat-card"><div class="stat-val">${cats.length}</div><div class="stat-label">Категорий</div></div>
        <div class="stat-card"><div class="stat-val">${d.services.length}</div><div class="stat-label">Услуг</div></div>
        <div class="stat-card"><div class="stat-val">${d.partners.length}</div><div class="stat-label">Партнёров</div></div>
      `;
      const info = document.getElementById('dashboardInfo');
      info.innerHTML = `
        <div class="admin-card">
          <h4>Быстрые действия</h4>
          <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <button class="btn-primary btn-sm" onclick="Admin.renderSection('products')">Управление продукцией</button>
            <button class="btn-primary btn-sm" onclick="Admin.renderSection('categories')">Управление категориями</button>
            <button class="btn-secondary btn-sm" onclick="Admin.renderSection('siteSettings')">Настройки сайта</button>
            <button class="btn-danger btn-sm" onclick="Admin.resetData()">Сбросить к начальным</button>
          </div>
        </div>
      `;
    },

    // ── CATEGORIES ──
    renderCategories(admin) {
      const container = document.getElementById('categoriesTree');
      const flat = DataStore.flattenCategories(admin.data.categories);

      let html = '';
      flat.forEach(cat => {
        html += `
          <div class="cat-tree-item depth-${cat.depth}">
            ${cat.depth > 0 ? '<span class="cat-tree-indent"></span>' : ''}
            <span class="cat-tree-name">${cat.name}</span>
            <span class="cat-tree-slug">${cat.slug || cat.id}</span>
            <div class="cat-tree-actions">
              <button class="btn-icon" onclick="Admin.editCategory('${cat.id}')" title="Редактировать">&#9998;</button>
              <button class="btn-icon" onclick="Admin.addSubcategory('${cat.id}')" title="Добавить подкатегорию">+</button>
              <button class="btn-icon danger" onclick="Admin.deleteCategory('${cat.id}')" title="Удалить">&#10005;</button>
            </div>
          </div>
        `;
      });
      container.innerHTML = html || '<p style="padding:1.5rem;color:var(--a-gray-500);">Нет категорий</p>';

      document.getElementById('addCategoryBtn').onclick = () => admin.addRootCategory();
    },

    // ── PRODUCTS ──
    renderProducts(admin) {
      const container = document.getElementById('productsList');
      const filtersBar = document.getElementById('productsFilters');
      const flat = DataStore.flattenCategories(admin.data.categories);

      // Filters
      let filterOpts = '<option value="">Все категории</option>';
      flat.forEach(c => {
        filterOpts += `<option value="${c.id}">${'—'.repeat(c.depth)} ${c.name}</option>`;
      });
      filtersBar.innerHTML = `
        <select id="productCategoryFilter" onchange="Admin.Sections.renderProducts(Admin)">
          ${filterOpts}
        </select>
        <input type="text" id="productSearchFilter" placeholder="Поиск по названию..." oninput="Admin.Sections.renderProducts(Admin)" />
      `;

      const filterCat = document.getElementById('productCategoryFilter')?.value || '';
      const filterSearch = (document.getElementById('productSearchFilter')?.value || '').toLowerCase();

      let products = [...admin.data.products].sort((a, b) => (a.sortOrder || 0) - (b.sortOrder || 0));

      if (filterCat) {
        products = products.filter(p => p.categoryId === filterCat || p.subcategoryId === filterCat);
      }
      if (filterSearch) {
        products = products.filter(p => p.name.toLowerCase().includes(filterSearch));
      }

      const availLabels = { in_stock: 'В наличии', out_of_stock: 'Нет в наличии', on_order: 'Под заказ' };
      const availClass = { in_stock: 'in-stock', out_of_stock: 'out-of-stock', on_order: 'on-order' };

      container.innerHTML = products.map(p => {
        const cat = DataStore.findCategory(admin.data.categories, p.categoryId);
        const sub = DataStore.findCategory(admin.data.categories, p.subcategoryId);
        return `
          <div class="list-item">
            <div class="list-item-content">
              <div class="list-item-title">${p.name}</div>
              <div class="list-item-sub">
                ${cat ? cat.name : ''} ${sub ? '/ ' + sub.name : ''} &middot;
                <span class="admin-badge ${availClass[p.availability] || ''}">${availLabels[p.availability] || p.availability}</span>
                ${p.price > 0 ? ' &middot; ' + p.price.toLocaleString() + ' тг' : ''}
                ${p.sku ? ' &middot; ' + p.sku : ''}
              </div>
            </div>
            <div class="list-item-actions">
              <button class="btn-icon" onclick="Admin.editProduct(${p.id})" title="Редактировать">&#9998;</button>
              <button class="btn-icon danger" onclick="Admin.deleteProduct(${p.id})" title="Удалить">&#10005;</button>
            </div>
          </div>
        `;
      }).join('') || '<p style="padding:1rem;color:var(--a-gray-500);">Нет продуктов</p>';

      document.getElementById('addProductBtn').onclick = () => admin.editProduct(null);
    },

    // ── SITE SETTINGS ──
    renderSiteSettings(admin) {
      const s = admin.data.siteSettings;
      const H = admin.H;
      document.getElementById('siteSettingsForm').innerHTML = `
        ${H.field('Название сайта', 'siteName', s.siteName)}
        ${H.field('Подзаголовок', 'siteTagline', s.siteTagline)}
        ${H.textarea('Meta Description', 'metaDescription', s.metaDescription)}
        ${H.field('Meta Keywords', 'metaKeywords', s.metaKeywords)}
        ${H.field('Текст логотипа', 'logoText', s.logoText)}
        ${H.field('Пароль админки', 'adminPassword', s.adminPassword, 'text', 'Пароль для входа в панель')}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveSiteSettings()">Сохранить</button>
        </div>
      `;
    },

    // ── HERO ──
    renderHeroSection(admin) {
      const h = admin.data.heroSection;
      const H = admin.H;
      let metricsHtml = h.metrics.map((m, i) => `
        <div class="admin-card" style="margin-top:0.5rem;">
          <div class="admin-form-row">
            ${H.field('Значение #' + (i + 1), 'metric_val_' + i, m.value)}
            ${H.field('Подпись #' + (i + 1), 'metric_label_' + i, m.label)}
          </div>
        </div>
      `).join('');

      document.getElementById('heroSectionForm').innerHTML = `
        ${H.field('Тег (надпись сверху)', 'tag', h.tag)}
        ${H.textarea('Заголовок (HTML)', 'title', h.title, 'Можно использовать &lt;br&gt; и &lt;em&gt;')}
        ${H.textarea('Описание', 'description', h.description)}
        ${H.field('Кнопка основная', 'btnPrimary', h.btnPrimary)}
        ${H.field('Кнопка вторичная', 'btnSecondary', h.btnSecondary)}
        <h4 style="margin:1rem 0 0.5rem;">Метрики</h4>
        ${metricsHtml}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveHeroSection()">Сохранить</button>
        </div>
      `;
    },

    // ── ABOUT ──
    renderAboutSection(admin) {
      const a = admin.data.aboutSection;
      const H = admin.H;
      let statsHtml = a.stats.map((s, i) => `
        <div class="admin-form-row" style="margin-top:0.5rem;">
          ${H.field('Значение #' + (i + 1), 'stat_val_' + i, s.value)}
          ${H.field('Подпись #' + (i + 1), 'stat_label_' + i, s.label)}
        </div>
      `).join('');

      document.getElementById('aboutSectionForm').innerHTML = `
        ${H.field('Лейбл', 'label', a.label)}
        ${H.textarea('Заголовок (HTML)', 'title', a.title)}
        ${H.textarea('Описание 1', 'description', a.description)}
        ${H.textarea('Описание 2', 'description2', a.description2)}
        <h4 style="margin:1rem 0 0.5rem;">Статистика</h4>
        ${statsHtml}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveAboutSection()">Сохранить</button>
        </div>
      `;
    },

    // ── FEATURES ──
    renderFeatures(admin) {
      const container = document.getElementById('featuresList');
      container.innerHTML = admin.data.featuresStrip.map((f, i) => `
        <div class="list-item">
          <div class="list-item-content">
            <div class="list-item-title">${f.title}</div>
            <div class="list-item-sub">${f.description}</div>
          </div>
          <div class="list-item-actions">
            <button class="btn-icon" onclick="Admin.editFeature(${i})">&#9998;</button>
            <button class="btn-icon danger" onclick="Admin.deleteFeature(${i})">&#10005;</button>
          </div>
        </div>
      `).join('') || '<p style="padding:1rem;color:var(--a-gray-500);">Нет преимуществ</p>';

      document.getElementById('addFeatureBtn').onclick = () => admin.editFeature(-1);
    },

    // ── CATALOG SETTINGS ──
    renderCatalogSettings(admin) {
      const c = admin.data.catalogSection;
      const H = admin.H;
      document.getElementById('catalogSettingsForm').innerHTML = `
        ${H.field('Лейбл', 'label', c.label)}
        ${H.field('Заголовок', 'title', c.title)}
        ${H.textarea('Описание', 'description', c.description)}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveCatalogSettings()">Сохранить</button>
        </div>
      `;
    },

    // ── SERVICES ──
    renderServices(admin) {
      const container = document.getElementById('servicesList');
      container.innerHTML = admin.data.services.map((s, i) => `
        <div class="list-item">
          <div class="list-item-content">
            <div class="list-item-title">${s.title}</div>
            <div class="list-item-sub">${s.description}</div>
          </div>
          <div class="list-item-actions">
            <button class="btn-icon" onclick="Admin.editService(${i})">&#9998;</button>
            <button class="btn-icon danger" onclick="Admin.deleteService(${i})">&#10005;</button>
          </div>
        </div>
      `).join('') || '<p style="padding:1rem;color:var(--a-gray-500);">Нет услуг</p>';

      document.getElementById('addServiceBtn').onclick = () => admin.editService(-1);
    },

    // ── PARTNERS ──
    renderPartners(admin) {
      const container = document.getElementById('partnersList');
      container.innerHTML = admin.data.partners.map((p, i) => `
        <div class="list-item">
          <div class="list-item-content">
            <div class="list-item-title">${p}</div>
          </div>
          <div class="list-item-actions">
            <button class="btn-icon" onclick="Admin.editPartner(${i})">&#9998;</button>
            <button class="btn-icon danger" onclick="Admin.deletePartner(${i})">&#10005;</button>
          </div>
        </div>
      `).join('') || '<p style="padding:1rem;color:var(--a-gray-500);">Нет партнёров</p>';

      document.getElementById('addPartnerBtn').onclick = () => admin.editPartner(-1);
    },

    // ── CONTACT SECTION ──
    renderContactSection(admin) {
      const c = admin.data.contactSection;
      const H = admin.H;
      document.getElementById('contactSectionForm').innerHTML = `
        ${H.field('Лейбл', 'label', c.label)}
        ${H.field('Заголовок', 'title', c.title)}
        ${H.textarea('Описание', 'description', c.description)}
        ${H.field('Заголовок формы', 'formTitle', c.formTitle)}
        ${H.field('Текст кнопки', 'formButton', c.formButton)}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveContactSection()">Сохранить</button>
        </div>
      `;
    },

    // ── CONTACT INFO ──
    renderContactInfo(admin) {
      const c = admin.data.contactInfo;
      const H = admin.H;
      document.getElementById('contactInfoForm').innerHTML = `
        ${H.field('Телефон', 'phone', c.phone)}
        ${H.field('Ссылка телефона', 'phoneLink', c.phoneLink)}
        ${H.field('Email', 'email', c.email)}
        ${H.field('Ссылка Email', 'emailLink', c.emailLink)}
        ${H.field('Адрес', 'address', c.address)}
        ${H.field('Режим работы', 'hours', c.hours)}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveContactInfo()">Сохранить</button>
        </div>
      `;
    },

    // ── COMPANY DETAILS ──
    renderCompanyDetails(admin) {
      const c = admin.data.companyDetails;
      const H = admin.H;
      document.getElementById('companyDetailsForm').innerHTML = `
        ${H.field('Название компании', 'name', c.name)}
        ${H.field('БИН', 'bin', c.bin)}
        ${H.field('Банк', 'bank', c.bank)}
        ${H.field('КБе', 'kbe', c.kbe)}
        ${H.field('БИК', 'bik', c.bik)}
        ${H.field('ИИК', 'iik', c.iik)}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveCompanyDetails()">Сохранить</button>
        </div>
      `;
    },

    // ── FOOTER ──
    renderFooter(admin) {
      const d = admin.data;
      const H = admin.H;
      document.getElementById('footerForm').innerHTML = `
        ${H.textarea('Текст о компании', 'footerText', d.footerText)}
        ${H.textarea('Ссылки продукции (по одной на строку)', 'footerProducts', d.footerProducts.join('\n'), 'Каждый пункт с новой строки')}
        ${H.textarea('Ссылки компании (по одной на строку)', 'footerCompanyLinks', d.footerCompanyLinks.join('\n'), 'Каждый пункт с новой строки')}
        <h4 style="margin:1rem 0 0.5rem;">Социальные сети</h4>
        ${H.field('Instagram', 'instagram', d.socialLinks.instagram)}
        ${H.field('Twitter', 'twitter', d.socialLinks.twitter)}
        ${H.field('GitHub', 'github', d.socialLinks.github)}
        <div class="admin-form-actions">
          <button class="btn-primary" onclick="Admin.saveFooter()">Сохранить</button>
        </div>
      `;
    }
  },

  // ══════════ SAVE METHODS ══════════

  saveSiteSettings() {
    const form = document.getElementById('siteSettingsForm');
    const d = this.H.formData(form);
    Object.assign(this.data.siteSettings, d);
    this.save();
  },

  saveHeroSection() {
    const form = document.getElementById('heroSectionForm');
    const d = this.H.formData(form);
    this.data.heroSection.tag = d.tag;
    this.data.heroSection.title = d.title;
    this.data.heroSection.description = d.description;
    this.data.heroSection.btnPrimary = d.btnPrimary;
    this.data.heroSection.btnSecondary = d.btnSecondary;
    this.data.heroSection.metrics = this.data.heroSection.metrics.map((m, i) => ({
      value: d['metric_val_' + i] || m.value,
      label: d['metric_label_' + i] || m.label
    }));
    this.save();
  },

  saveAboutSection() {
    const form = document.getElementById('aboutSectionForm');
    const d = this.H.formData(form);
    this.data.aboutSection.label = d.label;
    this.data.aboutSection.title = d.title;
    this.data.aboutSection.description = d.description;
    this.data.aboutSection.description2 = d.description2;
    this.data.aboutSection.stats = this.data.aboutSection.stats.map((s, i) => ({
      value: d['stat_val_' + i] || s.value,
      label: d['stat_label_' + i] || s.label
    }));
    this.save();
  },

  saveCatalogSettings() {
    const form = document.getElementById('catalogSettingsForm');
    const d = this.H.formData(form);
    Object.assign(this.data.catalogSection, d);
    this.save();
  },

  saveContactSection() {
    const form = document.getElementById('contactSectionForm');
    const d = this.H.formData(form);
    Object.assign(this.data.contactSection, d);
    this.save();
  },

  saveContactInfo() {
    const form = document.getElementById('contactInfoForm');
    const d = this.H.formData(form);
    Object.assign(this.data.contactInfo, d);
    this.save();
  },

  saveCompanyDetails() {
    const form = document.getElementById('companyDetailsForm');
    const d = this.H.formData(form);
    Object.assign(this.data.companyDetails, d);
    this.save();
  },

  saveFooter() {
    const form = document.getElementById('footerForm');
    const d = this.H.formData(form);
    this.data.footerText = d.footerText;
    this.data.footerProducts = d.footerProducts.split('\n').map(s => s.trim()).filter(Boolean);
    this.data.footerCompanyLinks = d.footerCompanyLinks.split('\n').map(s => s.trim()).filter(Boolean);
    this.data.socialLinks = { instagram: d.instagram, twitter: d.twitter, github: d.github };
    this.save();
  },

  // ══════════ CATEGORY CRUD ══════════

  addRootCategory() {
    const H = this.H;
    this.Modal.open(`
      <h3>Новая категория</h3>
      ${H.field('Название', 'name', '')}
      ${H.field('Slug (ID)', 'slug', '', 'text', 'Уникальный идентификатор, латиница')}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveCatBtn">Сохранить</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);
    document.getElementById('saveCatBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.name || !d.slug) { this.Toast.show('Заполните все поля', 'error'); return; }
      this.data.categories.push({ id: d.slug, name: d.name, slug: d.slug, children: [] });
      this.save();
      this.Modal.close();
      this.Sections.renderCategories(this);
    });
  },

  addSubcategory(parentId) {
    const H = this.H;
    this.Modal.open(`
      <h3>Новая подкатегория</h3>
      ${H.field('Название', 'name', '')}
      ${H.field('Slug (ID)', 'slug', '', 'text', 'Уникальный идентификатор, латиница')}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveCatBtn">Сохранить</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);
    document.getElementById('saveCatBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.name || !d.slug) { this.Toast.show('Заполните все поля', 'error'); return; }
      const parent = DataStore.findCategory(this.data.categories, parentId);
      if (parent) {
        if (!parent.children) parent.children = [];
        parent.children.push({ id: d.slug, name: d.name, slug: d.slug, children: [] });
        this.save();
        this.Modal.close();
        this.Sections.renderCategories(this);
      }
    });
  },

  editCategory(id) {
    const cat = DataStore.findCategory(this.data.categories, id);
    if (!cat) return;
    const H = this.H;
    this.Modal.open(`
      <h3>Редактировать категорию</h3>
      ${H.field('Название', 'name', cat.name)}
      ${H.field('Slug (ID)', 'slug', cat.slug || cat.id)}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveCatBtn">Сохранить</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);
    document.getElementById('saveCatBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.name) { this.Toast.show('Заполните название', 'error'); return; }
      cat.name = d.name;
      cat.slug = d.slug || cat.id;
      this.save();
      this.Modal.close();
      this.Sections.renderCategories(this);
    });
  },

  async deleteCategory(id) {
    const ok = await this.confirm('Удалить эту категорию и все подкатегории?');
    if (!ok) return;
    const removeFrom = (arr, target) => {
      for (let i = arr.length - 1; i >= 0; i--) {
        if (arr[i].id === target) { arr.splice(i, 1); return true; }
        if (arr[i].children && removeFrom(arr[i].children, target)) return true;
      }
      return false;
    };
    removeFrom(this.data.categories, id);
    this.save();
    this.Sections.renderCategories(this);
  },

  // ══════════ PRODUCT CRUD ══════════

  editProduct(id) {
    const isNew = id === null;
    const p = isNew ? {
      id: DataStore.getNextProductId(this.data.products),
      name: '', categoryId: '', subcategoryId: '', type: '', badge: '',
      badgeColor: '#00074B', description: '', price: 0, priceDisplay: 'По запросу',
      availability: 'in_stock', specs: [], hardware: '', sku: '',
      imageUrl: '', cardBg: '', featured: false, sortOrder: this.data.products.length + 1
    } : this.data.products.find(x => x.id === id);

    if (!p) return;

    const H = this.H;
    const flat = DataStore.flattenCategories(this.data.categories);

    // Build category options
    const catOpts = [{ value: '', text: '-- Выберите --' }];
    flat.forEach(c => catOpts.push({ value: c.id, text: '\u2014'.repeat(c.depth) + ' ' + c.name }));

    this.Modal.open(`
      <h3>${isNew ? 'Новый продукт' : 'Редактировать: ' + H.esc(p.name)}</h3>
      ${H.field('Название', 'name', p.name)}
      <div class="admin-form-row">
        ${H.select('Категория', 'categoryId', p.categoryId, catOpts)}
        ${H.select('Подкатегория', 'subcategoryId', p.subcategoryId, catOpts)}
      </div>
      ${H.field('Тип (подпись карточки)', 'type', p.type, 'text', 'Напр: Алюминиевый профиль · Warm')}
      <div class="admin-form-row">
        ${H.field('Бейдж', 'badge', p.badge)}
        ${H.field('Цвет бейджа', 'badgeColor', p.badgeColor, 'color')}
      </div>
      ${H.textarea('Описание', 'description', p.description)}
      <div class="admin-form-row">
        ${H.field('Цена (тг)', 'price', p.price, 'number')}
        ${H.field('Отображение цены', 'priceDisplay', p.priceDisplay, 'text', 'Если цена 0')}
      </div>
      ${H.select('Наличие', 'availability', p.availability, [
        { value: 'in_stock', text: 'В наличии' },
        { value: 'out_of_stock', text: 'Нет в наличии' },
        { value: 'on_order', text: 'Под заказ' }
      ])}
      ${H.field('Теги (через запятую)', 'specs', (p.specs || []).join(', '), 'text', 'Напр: 55 мм, Warm, Термобарьер')}
      <div class="admin-form-row">
        ${H.field('Фурнитура', 'hardware', p.hardware)}
        ${H.field('Артикул (SKU)', 'sku', p.sku)}
      </div>
      ${H.field('URL изображения', 'imageUrl', p.imageUrl, 'text', 'Необязательно')}
      ${H.field('Фон карточки (CSS)', 'cardBg', p.cardBg, 'text', 'Напр: linear-gradient(135deg, #EEF2FF, #E0E7FF)')}
      ${H.field('Порядок сортировки', 'sortOrder', p.sortOrder, 'number')}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveProductBtn">${isNew ? 'Создать' : 'Сохранить'}</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);

    document.getElementById('saveProductBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.name) { this.Toast.show('Укажите название', 'error'); return; }

      p.name = d.name;
      p.categoryId = d.categoryId;
      p.subcategoryId = d.subcategoryId;
      p.type = d.type;
      p.badge = d.badge;
      p.badgeColor = d.badgeColor;
      p.description = d.description;
      p.price = parseFloat(d.price) || 0;
      p.priceDisplay = d.priceDisplay;
      p.availability = d.availability;
      p.specs = d.specs.split(',').map(s => s.trim()).filter(Boolean);
      p.hardware = d.hardware;
      p.sku = d.sku;
      p.imageUrl = d.imageUrl;
      p.cardBg = d.cardBg;
      p.sortOrder = parseInt(d.sortOrder) || 0;

      if (isNew) this.data.products.push(p);
      this.save();
      this.Modal.close();
      this.Sections.renderProducts(this);
    });
  },

  async deleteProduct(id) {
    const ok = await this.confirm('Удалить этот продукт?');
    if (!ok) return;
    this.data.products = this.data.products.filter(p => p.id !== id);
    this.save();
    this.Sections.renderProducts(this);
  },

  // ══════════ FEATURE CRUD ══════════

  editFeature(index) {
    const isNew = index === -1;
    const f = isNew ? { title: '', description: '' } : this.data.featuresStrip[index];
    const H = this.H;
    this.Modal.open(`
      <h3>${isNew ? 'Новое преимущество' : 'Редактировать преимущество'}</h3>
      ${H.field('Заголовок', 'title', f.title)}
      ${H.textarea('Описание', 'description', f.description)}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveBtn">Сохранить</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);
    document.getElementById('saveBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.title) { this.Toast.show('Укажите заголовок', 'error'); return; }
      if (isNew) { this.data.featuresStrip.push(d); } else { Object.assign(f, d); }
      this.save(); this.Modal.close(); this.Sections.renderFeatures(this);
    });
  },

  async deleteFeature(index) {
    const ok = await this.confirm('Удалить это преимущество?');
    if (!ok) return;
    this.data.featuresStrip.splice(index, 1);
    this.save(); this.Sections.renderFeatures(this);
  },

  // ══════════ SERVICE CRUD ══════════

  editService(index) {
    const isNew = index === -1;
    const s = isNew ? { title: '', description: '' } : this.data.services[index];
    const H = this.H;
    this.Modal.open(`
      <h3>${isNew ? 'Новая услуга' : 'Редактировать услугу'}</h3>
      ${H.field('Заголовок', 'title', s.title)}
      ${H.textarea('Описание', 'description', s.description)}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveBtn">Сохранить</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);
    document.getElementById('saveBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.title) { this.Toast.show('Укажите заголовок', 'error'); return; }
      if (isNew) { this.data.services.push(d); } else { Object.assign(s, d); }
      this.save(); this.Modal.close(); this.Sections.renderServices(this);
    });
  },

  async deleteService(index) {
    const ok = await this.confirm('Удалить эту услугу?');
    if (!ok) return;
    this.data.services.splice(index, 1);
    this.save(); this.Sections.renderServices(this);
  },

  // ══════════ PARTNER CRUD ══════════

  editPartner(index) {
    const isNew = index === -1;
    const name = isNew ? '' : this.data.partners[index];
    const H = this.H;
    this.Modal.open(`
      <h3>${isNew ? 'Новый партнёр' : 'Редактировать партнёра'}</h3>
      ${H.field('Название', 'name', name)}
      <div class="admin-form-actions">
        <button class="btn-primary" id="saveBtn">Сохранить</button>
        <button class="btn-secondary" onclick="Admin.Modal.close()">Отмена</button>
      </div>
    `);
    document.getElementById('saveBtn').addEventListener('click', () => {
      const d = this.H.formData(document.getElementById('modalBody'));
      if (!d.name) { this.Toast.show('Укажите название', 'error'); return; }
      if (isNew) { this.data.partners.push(d.name); } else { this.data.partners[index] = d.name; }
      this.save(); this.Modal.close(); this.Sections.renderPartners(this);
    });
  },

  async deletePartner(index) {
    const ok = await this.confirm('Удалить этого партнёра?');
    if (!ok) return;
    this.data.partners.splice(index, 1);
    this.save(); this.Sections.renderPartners(this);
  },

  // ══════════ RESET DATA ══════════

  async resetData() {
    const ok = await this.confirm('Сбросить все данные к начальным? Все изменения будут потеряны!');
    if (!ok) return;
    this.data = DataStore.reset();
    this.Toast.show('Данные сброшены', 'success');
    this.renderSection(this.currentSection);
  }
};

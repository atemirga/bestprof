/**
 * BestProf Data Store
 * Centralized data management with localStorage persistence
 */

'use strict';

const DataStore = {

  STORAGE_KEY: 'bestprof_data',

  _defaults: null,

  getDefaults() {
    if (this._defaults) return this._defaults;

    this._defaults = {

      // ══════════ CATEGORIES (tree structure) ══════════
      categories: [
        {
          id: 'alu',
          name: 'Алюминий',
          slug: 'alu',
          children: [
            { id: 'gold', name: 'Gold', slug: 'gold', children: [] },
            { id: 'alprof', name: 'AlProf', slug: 'alprof', children: [] }
          ]
        },
        {
          id: 'pvh',
          name: 'ПВХ',
          slug: 'pvh',
          children: [
            { id: 'pvh-systems', name: 'ПВХ-системы', slug: 'pvh-systems', children: [] },
            {
              id: 'pvh-furn',
              name: 'Фурнитура',
              slug: 'pvh-furn',
              children: []
            }
          ]
        }
      ],

      // ══════════ PRODUCTS ══════════
      products: [
        {
          id: 1,
          name: 'Gold 45 Cold',
          categoryId: 'alu',
          subcategoryId: 'gold',
          type: 'Алюминиевый профиль · Cold',
          badge: 'Gold',
          badgeColor: '#00074B',
          description: 'Холодная алюминиевая профильная система 45 мм для остекления балконов, витрин и неотапливаемых помещений',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['45 мм', 'Cold', 'ALU'],
          hardware: 'Gold',
          sku: 'GOLD-45-COLD',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 1
        },
        {
          id: 2,
          name: 'Gold 55 Warm',
          categoryId: 'alu',
          subcategoryId: 'gold',
          type: 'Алюминиевый профиль · Warm',
          badge: 'Gold',
          badgeColor: '#00074B',
          description: 'Тёплая алюминиевая система 55 мм с термобарьером для оконных и дверных конструкций жилых зданий',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['55 мм', 'Warm', 'Термобарьер'],
          hardware: 'Gold',
          sku: 'GOLD-55-WARM',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 2
        },
        {
          id: 3,
          name: 'Gold 74 Warm',
          categoryId: 'alu',
          subcategoryId: 'gold',
          type: 'Алюминиевый профиль · Warm',
          badge: 'Gold',
          badgeColor: '#00074B',
          description: 'Премиальная тёплая алюминиевая система 74 мм с усиленным термобарьером для максимальной теплоизоляции',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['74 мм', 'Warm', 'Премиум'],
          hardware: 'Gold',
          sku: 'GOLD-74-WARM',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 3
        },
        {
          id: 4,
          name: 'Стоечно-ригельные системы',
          categoryId: 'alu',
          subcategoryId: 'gold',
          type: 'Алюминиевый профиль · Фасад',
          badge: 'Gold',
          badgeColor: '#00074B',
          description: 'Фасадные стоечно-ригельные конструкции Gold для витражного остекления зданий и крупных коммерческих объектов',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['Фасад', 'Витраж', 'ALU'],
          hardware: 'Gold',
          sku: 'GOLD-FACADE',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 4
        },
        {
          id: 5,
          name: 'AlProf 62 (теплый)',
          categoryId: 'alu',
          subcategoryId: 'alprof',
          type: 'Алюминиевый профиль · Warm',
          badge: 'AlProf',
          badgeColor: '#00074B',
          description: 'Тёплая алюминиевая оконно-дверная система 62 мм с термобарьером для жилого и коммерческого строительства',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['62 мм', 'Тёплый', 'ALU'],
          hardware: 'AlProf',
          sku: 'ALPROF-62',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 5
        },
        {
          id: 6,
          name: 'AlProf 72 (теплый)',
          categoryId: 'alu',
          subcategoryId: 'alprof',
          type: 'Алюминиевый профиль · Warm',
          badge: 'AlProf',
          badgeColor: '#00074B',
          description: 'Усиленная тёплая алюминиевая система 72 мм с повышенной теплоизоляцией для суровых климатических условий',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['72 мм', 'Тёплый', 'Усиленный'],
          hardware: 'AlProf',
          sku: 'ALPROF-72',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 6
        },
        {
          id: 7,
          name: 'AlProf HS Portal (теплый) 176 мм',
          categoryId: 'alu',
          subcategoryId: 'alprof',
          type: 'Алюминиевый профиль · HS Portal',
          badge: 'AlProf',
          badgeColor: '#00074B',
          description: 'Подъёмно-сдвижная портальная система 176 мм с термобарьером для панорамного остекления больших проёмов',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['176 мм', 'HS Portal', 'Тёплый'],
          hardware: 'AlProf',
          sku: 'ALPROF-HS-176',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 7
        },
        {
          id: 8,
          name: 'AlProf Гармошка (тёплый) 62 мм',
          categoryId: 'alu',
          subcategoryId: 'alprof',
          type: 'Алюминиевый профиль · Гармошка',
          badge: 'AlProf',
          badgeColor: '#00074B',
          description: 'Складная тёплая алюминиевая система 62 мм для террас, веранд и панорамных выходов на улицу',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['62 мм', 'Гармошка', 'Тёплый'],
          hardware: 'AlProf',
          sku: 'ALPROF-ACCORDION-62',
          imageUrl: '',
          cardBg: '',
          featured: false,
          sortOrder: 8
        },
        {
          id: 9,
          name: 'Sapa 60 (3-камерный)',
          categoryId: 'pvh',
          subcategoryId: 'pvh-systems',
          type: 'ПВХ-система · 3 камеры',
          badge: 'ПВХ',
          badgeColor: '#2563EB',
          description: 'Экономичная пластиковая оконная система 60 мм с 3-камерным профилем для стандартного жилого строительства',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['60 мм', '3 камеры', 'ПВХ'],
          hardware: 'Grunder',
          sku: 'PVH-SAPA-60',
          imageUrl: '',
          cardBg: 'linear-gradient(135deg, #EEF2FF, #E0E7FF)',
          featured: false,
          sortOrder: 9
        },
        {
          id: 10,
          name: 'Funke (4-5 камерные)',
          categoryId: 'pvh',
          subcategoryId: 'pvh-systems',
          type: 'ПВХ-система · 4-5 камер',
          badge: 'ПВХ',
          badgeColor: '#2563EB',
          description: 'Многокамерная пластиковая система Funke с 4-5 камерами для повышенной тепло- и шумоизоляции',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['4-5 камер', 'Теплоизоляция', 'ПВХ'],
          hardware: 'Grunder',
          sku: 'PVH-FUNKE',
          imageUrl: '',
          cardBg: 'linear-gradient(135deg, #EEF2FF, #E0E7FF)',
          featured: false,
          sortOrder: 10
        },
        {
          id: 11,
          name: 'Seiger WDF (4-5 камерные)',
          categoryId: 'pvh',
          subcategoryId: 'pvh-systems',
          type: 'ПВХ-система · 4-5 камер',
          badge: 'ПВХ',
          badgeColor: '#2563EB',
          description: 'Профильная система Seiger WDF с 4-5 камерным сечением для высококачественного остекления жилых объектов',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['4-5 камер', 'WDF', 'ПВХ'],
          hardware: 'Grunder',
          sku: 'PVH-SEIGER-WDF',
          imageUrl: '',
          cardBg: 'linear-gradient(135deg, #EEF2FF, #E0E7FF)',
          featured: false,
          sortOrder: 11
        },
        {
          id: 12,
          name: 'Fores',
          categoryId: 'pvh',
          subcategoryId: 'pvh-furn',
          type: 'ПВХ-фурнитура',
          badge: 'Фурнитура',
          badgeColor: '#16A34A',
          description: 'Надёжная фурнитура Fores для пластиковых оконных и дверных конструкций. Поворотно-откидные механизмы и запирающие системы',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['Поворотно-откидная', 'ПВХ', 'Fores'],
          hardware: 'Фурнитура',
          sku: 'FURN-FORES',
          imageUrl: '',
          cardBg: 'linear-gradient(135deg, #F0FDF4, #DCFCE7)',
          featured: false,
          sortOrder: 12
        },
        {
          id: 13,
          name: 'WinkHaus',
          categoryId: 'pvh',
          subcategoryId: 'pvh-furn',
          type: 'ПВХ-фурнитура',
          badge: 'Фурнитура',
          badgeColor: '#16A34A',
          description: 'Премиальная немецкая фурнитура WinkHaus для ПВХ-систем. Многоточечное запирание, высокая взломостойкость и долговечность',
          price: 0,
          priceDisplay: 'По запросу',
          availability: 'in_stock',
          specs: ['Многоточечная', 'Германия', 'WinkHaus'],
          hardware: 'Фурнитура',
          sku: 'FURN-WINKHAUS',
          imageUrl: '',
          cardBg: 'linear-gradient(135deg, #F0FDF4, #DCFCE7)',
          featured: false,
          sortOrder: 13
        }
      ],

      // ══════════ SITE CONTENT ══════════
      siteSettings: {
        siteName: 'BestProf',
        siteTagline: 'Алюминиевые и пластиковые профильные системы | Казахстан',
        metaDescription: 'ТОО BestProf — казахстанский производитель премиальных алюминиевых и пластиковых профильных систем. Собственный завод в Алматы.',
        metaKeywords: 'алюминиевые профили, ПВХ профили, окна, двери, фасады, перегородки, Казахстан, Алматы, BestProf',
        logoText: 'BestProf',
        adminPassword: 'admin123'
      },

      heroSection: {
        tag: 'Производитель алюминиевых и пластиковых профильных систем',
        title: 'Профильные системы<br><em>премиум\u2011класса</em>',
        description: 'Производим алюминиевые и ПВХ-профили на собственном заводе в Алматы. Итальянская фурнитура, европейское качество.',
        btnPrimary: 'Получить консультацию',
        btnSecondary: 'Каталог продукции',
        metrics: [
          { value: '13', label: 'Систем в каталоге' },
          { value: '30 лет', label: 'Срок службы изделий' },
          { value: 'Giesse', label: 'Итальянская фурнитура' },
          { value: 'ISO', label: 'Сертификат качества' }
        ]
      },

      aboutSection: {
        label: 'О компании',
        title: 'Надёжный партнёр в сфере<br>профильных конструкций',
        description: 'Best Prof — казахстанский производитель премиальных алюминиевых и пластиковых профильных систем. Собственный завод, полный цикл производства и комплексные решения для строительных и интерьерных проектов любой сложности: от частных домов до коммерческих объектов.',
        description2: 'Наша миссия — производить продукцию европейского уровня на собственном заводе в Казахстане по оптимальным ценам, с полной технической поддержкой на каждом этапе: от проектирования до монтажа.',
        stats: [
          { value: '500 кг', label: 'Макс. вес створки' },
          { value: '68 мм', label: 'Макс. стеклопакет' },
          { value: '51 мм', label: 'Термобарьер (Viking 90)' },
          { value: '5.5 м', label: 'Макс. высота перегородок' }
        ]
      },

      featuresStrip: [
        { title: 'Итальянская фурнитура', description: 'Giesse, Monticelli, Dr. Hahn, FritsJurgens' },
        { title: 'Полный каталог', description: 'Алюминиевые (Gold, AlProf) и ПВХ профильные системы' },
        { title: 'Сертификация', description: 'Полный пакет протоколов испытаний' },
        { title: '30+ лет службы', description: 'Гарантированный срок эксплуатации' }
      ],

      catalogSection: {
        label: 'Каталог продукции',
        title: 'Алюминиевые и пластиковые профильные системы',
        description: 'Алюминиевые профили Gold и AlProf, ПВХ-системы и фурнитура. Источник: ARJAN.KZ'
      },

      services: [
        { title: 'Проектирование', description: 'Разработка проектной документации с учётом архитектурных особенностей объекта и климатических условий региона. Подбор оптимальных профильных систем.' },
        { title: 'Расчёт стоимости', description: 'Точный расчёт стоимости проекта с учётом спецификации профилей, фурнитуры, стеклопакетов и комплектующих. Прозрачное ценообразование.' },
        { title: 'Техническая документация', description: 'Автоматические чертежи, раскрой профиля, размеры стеклопакетов, технический паспорт, схемы сборки и монтажа аксессуаров на все изделия.' },
        { title: 'Поставка профиля', description: 'Оперативная поставка полного комплекта профилей, фурнитуры и комплектующих со склада в Алматы. Доставка по всему Казахстану.' },
        { title: 'Техническая поддержка', description: 'Консультации по сборке и монтажу алюминиевых и ПВХ-систем. Пошаговые инструкции и помощь специалиста на каждом этапе работы с профилем.' },
        { title: 'Гарантийное обслуживание', description: 'Гарантия на все поставляемые профильные системы. Оперативная замена комплектующих и техническое обслуживание в гарантийный период.' }
      ],

      servicesSection: {
        label: 'Наши услуги',
        title: 'Комплексное сопровождение проектов',
        description: 'От первичной консультации до финальной сдачи объекта — полный спектр услуг для реализации ваших проектов'
      },

      partners: ['BestProf', 'Giesse', 'Monticelli', 'Dr. Hahn', 'FritsJurgens', 'Laminam'],

      partnersSection: {
        label: 'Партнёры и производители',
        title: 'Мировые бренды фурнитуры',
        description: 'Мы работаем исключительно с проверенными европейскими производителями фурнитуры и комплектующих'
      },

      contactSection: {
        label: 'Свяжитесь с нами',
        title: 'Получите персональное коммерческое предложение',
        description: 'Оставьте заявку и наш специалист свяжется с вами для подбора оптимального решения, расчёта стоимости и формирования коммерческого предложения.',
        formTitle: 'Заявка на консультацию',
        formButton: 'Отправить заявку'
      },

      contactInfo: {
        phone: '+7 701 055 99 00',
        phoneLink: 'tel:+77010559900',
        email: 'info@bestprof.kz',
        emailLink: 'mailto:info@bestprof.kz',
        address: 'г. Алматы, ул. Новгородская, 172Б',
        hours: 'Пн–Пт: 09:00 – 18:00'
      },

      companyDetails: {
        name: 'ТОО «BestProf»',
        bin: '930840000844',
        bank: 'АО «Kaspi Bank»',
        kbe: '17',
        bik: 'CASPKZKA',
        iik: 'KZ15722S000023548941'
      },

      footerProducts: [
        'Подъёмно-сдвижные системы',
        'Раздвижные системы',
        'Складные системы',
        'Оконно-дверные системы',
        'ПВХ-системы',
        'Пивотные двери',
        'Перегородки',
        'Фасадные витражи',
        'Перголы и гильотины'
      ],

      footerCompanyLinks: [
        'О компании',
        'Услуги',
        'Партнёры',
        'Сертификаты',
        'Реализованные проекты'
      ],

      footerText: 'Казахстанский производитель премиальных алюминиевых и пластиковых профильных систем. Собственный завод, полный цикл производства. Комплексные решения для оконных, дверных, фасадных и интерьерных конструкций.',

      socialLinks: {
        instagram: '#',
        twitter: '#',
        github: '#'
      }
    };

    return this._defaults;
  },

  load() {
    try {
      const stored = localStorage.getItem(this.STORAGE_KEY);
      if (stored) {
        const parsed = JSON.parse(stored);
        return this._merge(this.getDefaults(), parsed);
      }
    } catch (e) {
      console.warn('DataStore: Failed to load from localStorage', e);
    }
    return JSON.parse(JSON.stringify(this.getDefaults()));
  },

  save(data) {
    try {
      localStorage.setItem(this.STORAGE_KEY, JSON.stringify(data));
      return true;
    } catch (e) {
      console.error('DataStore: Failed to save', e);
      return false;
    }
  },

  reset() {
    localStorage.removeItem(this.STORAGE_KEY);
    this._defaults = null;
    return this.load();
  },

  _merge(defaults, stored) {
    const result = JSON.parse(JSON.stringify(defaults));
    for (const key of Object.keys(stored)) {
      if (key in result) {
        if (Array.isArray(stored[key])) {
          result[key] = stored[key];
        } else if (typeof stored[key] === 'object' && stored[key] !== null && !Array.isArray(stored[key])) {
          result[key] = Object.assign({}, result[key], stored[key]);
        } else {
          result[key] = stored[key];
        }
      } else {
        result[key] = stored[key];
      }
    }
    return result;
  },

  // ══════════ CATEGORY HELPERS ══════════

  findCategory(categories, id) {
    for (const cat of categories) {
      if (cat.id === id) return cat;
      if (cat.children) {
        const found = this.findCategory(cat.children, id);
        if (found) return found;
      }
    }
    return null;
  },

  flattenCategories(categories, depth = 0) {
    const result = [];
    for (const cat of categories) {
      result.push({ ...cat, depth, children: undefined });
      if (cat.children && cat.children.length) {
        result.push(...this.flattenCategories(cat.children, depth + 1));
      }
    }
    return result;
  },

  getCategoryPath(categories, id) {
    const path = [];
    const find = (cats, target) => {
      for (const cat of cats) {
        if (cat.id === target) {
          path.push(cat);
          return true;
        }
        if (cat.children && cat.children.length) {
          path.push(cat);
          if (find(cat.children, target)) return true;
          path.pop();
        }
      }
      return false;
    };
    find(categories, id);
    return path;
  },

  getNextProductId(products) {
    return products.length ? Math.max(...products.map(p => p.id)) + 1 : 1;
  }
};

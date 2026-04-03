<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // ── Site ─────────────────────────────────────
            ['group' => 'site', 'key' => 'site_name',        'value' => 'BestProf',                                                                  'type' => 'text',     'label' => 'Название сайта'],
            ['group' => 'site', 'key' => 'site_tagline',     'value' => 'Алюминиевые и пластиковые профильные системы | Казахстан',                    'type' => 'text',     'label' => 'Подзаголовок'],
            ['group' => 'site', 'key' => 'meta_description', 'value' => 'ТОО BestProf — казахстанский производитель и поставщик алюминиевых и ПВХ профильных систем для окон, дверей и фасадов', 'type' => 'textarea', 'label' => 'META описание'],
            ['group' => 'site', 'key' => 'meta_keywords',    'value' => 'алюминиевые профили, ПВХ профили, окна, двери, фасады, Казахстан, BestProf',  'type' => 'text',     'label' => 'META ключевые слова'],

            // ── Contact ──────────────────────────────────
            ['group' => 'contact', 'key' => 'phone',   'value' => '+7 701 055 99 00',                  'type' => 'text', 'label' => 'Телефон'],
            ['group' => 'contact', 'key' => 'email',   'value' => 'info@bestprof.kz',                  'type' => 'text', 'label' => 'Email'],
            ['group' => 'contact', 'key' => 'address', 'value' => 'г. Алматы, ул. Новгородская, 172Б', 'type' => 'text', 'label' => 'Адрес'],
            ['group' => 'contact', 'key' => 'hours',   'value' => 'Пн–Пт: 09:00 – 18:00',             'type' => 'text', 'label' => 'Часы работы'],

            // ── Company ──────────────────────────────────
            ['group' => 'company', 'key' => 'company_name', 'value' => 'ТОО «BestProf»',        'type' => 'text', 'label' => 'Название компании'],
            ['group' => 'company', 'key' => 'bin',          'value' => '930840000844',            'type' => 'text', 'label' => 'БИН'],
            ['group' => 'company', 'key' => 'bank',         'value' => 'АО «Kaspi Bank»',        'type' => 'text', 'label' => 'Банк'],
            ['group' => 'company', 'key' => 'kbe',          'value' => '17',                      'type' => 'text', 'label' => 'КБе'],
            ['group' => 'company', 'key' => 'bik',          'value' => 'CASPKZKA',                'type' => 'text', 'label' => 'БИК'],
            ['group' => 'company', 'key' => 'iik',          'value' => 'KZ15722S000023548941',    'type' => 'text', 'label' => 'ИИК'],

            // ── Social ───────────────────────────────────
            ['group' => 'social', 'key' => 'instagram', 'value' => '#', 'type' => 'text', 'label' => 'Instagram'],
            ['group' => 'social', 'key' => 'twitter',   'value' => '#', 'type' => 'text', 'label' => 'Twitter'],
            ['group' => 'social', 'key' => 'github',    'value' => '#', 'type' => 'text', 'label' => 'GitHub'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting,
            );
        }
    }
}

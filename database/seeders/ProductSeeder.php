<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedGoldProducts();
        $this->seedAlProfProducts();
        $this->seedPvhProducts();
        $this->seedFurnituraProducts();
    }

    // ── Gold ─────────────────────────────────────────────

    private function seedGoldProducts(): void
    {
        $cat = Category::where('slug', 'gold-45-cold')->firstOrFail();
        Product::create([
            'category_id'  => $cat->id,
            'name'         => 'Gold 45 Cold',
            'slug'         => 'gold-45-cold',
            'sku'          => 'GOLD-45-COLD',
            'type_label'   => 'Алюминиевый профиль · Cold',
            'badge'        => 'Gold',
            'badge_color'  => '#00074B',
            'description'  => 'Холодная алюминиевая профильная система 45 мм для остекления балконов, витрин и неотапливаемых помещений',
            'specs'        => ['45 мм', 'Cold', 'ALU'],
            'hardware'     => 'Gold',
            'card_bg'      => 'linear-gradient(135deg, #F5F7FA, #E4E7EB)',
        ]);

        $cat = Category::where('slug', 'gold-55-warm')->firstOrFail();
        Product::create([
            'category_id'  => $cat->id,
            'name'         => 'Gold 55 Warm',
            'slug'         => 'gold-55-warm',
            'sku'          => 'GOLD-55-WARM',
            'type_label'   => 'Алюминиевый профиль · Warm',
            'badge'        => 'Gold',
            'badge_color'  => '#00074B',
            'description'  => 'Тёплая алюминиевая система 55 мм с термобарьером для оконных и дверных конструкций',
            'specs'        => ['55 мм', 'Warm', 'Термобарьер'],
            'hardware'     => 'Gold',
            'card_bg'      => 'linear-gradient(135deg, #F5F7FA, #E4E7EB)',
        ]);

        $cat = Category::where('slug', 'gold-74-warm')->firstOrFail();
        Product::create([
            'category_id'  => $cat->id,
            'name'         => 'Gold 74 Warm',
            'slug'         => 'gold-74-warm',
            'sku'          => 'GOLD-74-WARM',
            'type_label'   => 'Алюминиевый профиль · Warm',
            'badge'        => 'Gold',
            'badge_color'  => '#00074B',
            'description'  => 'Премиальная тёплая алюминиевая система 74 мм с усиленным термобарьером',
            'specs'        => ['74 мм', 'Warm', 'Премиум'],
            'hardware'     => 'Gold',
            'card_bg'      => 'linear-gradient(135deg, #F5F7FA, #E4E7EB)',
        ]);

        $cat = Category::where('slug', 'gold-facade')->firstOrFail();
        Product::create([
            'category_id'  => $cat->id,
            'name'         => 'Стоечно-ригельные системы Gold',
            'slug'         => 'gold-facade-system',
            'sku'          => 'GOLD-FACADE',
            'type_label'   => 'Алюминиевый профиль · Фасад',
            'badge'        => 'Gold',
            'badge_color'  => '#00074B',
            'description'  => 'Фасадные стоечно-ригельные конструкции Gold для витражного остекления',
            'specs'        => ['Фасад', 'Витраж', 'ALU'],
            'hardware'     => 'Gold',
            'card_bg'      => 'linear-gradient(135deg, #F5F7FA, #E4E7EB)',
        ]);
    }

    // ── AlProf ───────────────────────────────────────────

    private function seedAlProfProducts(): void
    {
        $data = [
            ['slug' => 'alprof-62',         'name' => 'AlProf 62 (теплый)',                 'sku' => 'ALPROF-62',          'type_label' => 'Алюминиевый профиль · Warm', 'description' => 'Тёплая алюминиевая система AlProf 62 мм для оконных и дверных конструкций',                  'specs' => ['62 мм', 'Тёплый', 'ALU']],
            ['slug' => 'alprof-72',         'name' => 'AlProf 72 (теплый)',                 'sku' => 'ALPROF-72',          'type_label' => 'Алюминиевый профиль · Warm', 'description' => 'Тёплая алюминиевая система AlProf 72 мм с усиленным термобарьером',                        'specs' => ['72 мм', 'Тёплый', 'Усиленный']],
            ['slug' => 'alprof-hs-portal',  'name' => 'AlProf HS Portal (теплый) 176 мм',  'sku' => 'ALPROF-HS-PORTAL',   'type_label' => 'Алюминиевый профиль · HS Portal', 'description' => 'Подъёмно-сдвижная портальная система AlProf HS Portal 176 мм для панорамного остекления', 'specs' => ['176 мм', 'HS Portal', 'Тёплый']],
            ['slug' => 'alprof-accordion',  'name' => 'AlProf Гармошка (тёплый) 62 мм',    'sku' => 'ALPROF-ACCORDION',   'type_label' => 'Алюминиевый профиль · Гармошка', 'description' => 'Складная система AlProf «Гармошка» 62 мм для террас и зимних садов',                     'specs' => ['62 мм', 'Гармошка', 'Тёплый']],
        ];

        foreach ($data as $item) {
            $cat = Category::where('slug', $item['slug'])->firstOrFail();
            Product::create([
                'category_id'  => $cat->id,
                'name'         => $item['name'],
                'slug'         => Str::slug($item['name']),
                'sku'          => $item['sku'],
                'type_label'   => $item['type_label'],
                'badge'        => 'AlProf',
                'badge_color'  => '#00074B',
                'description'  => $item['description'],
                'specs'        => $item['specs'],
                'hardware'     => 'AlProf',
                'card_bg'      => 'linear-gradient(135deg, #F5F7FA, #E4E7EB)',
            ]);
        }
    }

    // ── ПВХ ──────────────────────────────────────────────

    private function seedPvhProducts(): void
    {
        $brands = [
            'sapa' => [
                ['name' => 'Sapa 60 (3-камерный)',    'specs' => ['60 мм', '3 камеры', 'ПВХ']],
                ['name' => 'Sapa 70 (5-камерный)',    'specs' => ['70 мм', '5 камер', 'ПВХ']],
                ['name' => 'Sapa 82 (6-камерный)',    'specs' => ['82 мм', '6 камер', 'ПВХ']],
                ['name' => 'Sapa 60 Раздвижная',      'specs' => ['60 мм', 'Раздвижная', 'ПВХ']],
            ],
            'funke' => [
                ['name' => 'Funke 60 (3-камерный)',   'specs' => ['60 мм', '3 камеры', 'ПВХ']],
                ['name' => 'Funke 70 (5-камерный)',   'specs' => ['70 мм', '5 камер', 'ПВХ']],
                ['name' => 'Funke 76 (6-камерный)',   'specs' => ['76 мм', '6 камер', 'ПВХ']],
                ['name' => 'Funke 82 MD (6-камерный)','specs' => ['82 мм', '6 камер', 'Премиум']],
            ],
            'seiger-wdf' => [
                ['name' => 'Seiger WDF 60 (3-камерный)', 'specs' => ['60 мм', '3 камеры', 'ПВХ']],
                ['name' => 'Seiger WDF 70 (5-камерный)', 'specs' => ['70 мм', '5 камер', 'ПВХ']],
                ['name' => 'Seiger WDF 80 (6-камерный)', 'specs' => ['80 мм', '6 камер', 'ПВХ']],
                ['name' => 'Seiger WDF 70 Раздвижная',   'specs' => ['70 мм', 'Раздвижная', 'ПВХ']],
            ],
            'grunder' => [
                ['name' => 'Grunder 60 (3-камерный)',    'specs' => ['60 мм', '3 камеры', 'ПВХ']],
                ['name' => 'Grunder 70 (5-камерный)',    'specs' => ['70 мм', '5 камер', 'ПВХ']],
                ['name' => 'Grunder 80 (6-камерный)',    'specs' => ['80 мм', '6 камер', 'ПВХ']],
                ['name' => 'Grunder 70 MD (5-камерный)', 'specs' => ['70 мм', '5 камер', 'Улучшенный']],
            ],
        ];

        foreach ($brands as $catSlug => $products) {
            $cat = Category::where('slug', $catSlug)->firstOrFail();

            foreach ($products as $i => $product) {
                Product::create([
                    'category_id'  => $cat->id,
                    'name'         => $product['name'],
                    'slug'         => Str::slug($product['name']),
                    'sku'          => strtoupper(Str::slug($product['name'])),
                    'type_label'   => 'ПВХ профиль',
                    'badge'        => 'ПВХ',
                    'badge_color'  => '#2563EB',
                    'description'  => 'ПВХ профильная система ' . $product['name'],
                    'specs'        => $product['specs'],
                    'hardware'     => 'Grunder',
                    'card_bg'      => 'linear-gradient(135deg, #EEF2FF, #E0E7FF)',
                    'sort_order'   => $i + 1,
                ]);
            }
        }
    }

    // ── Фурнитура ────────────────────────────────────────

    private function seedFurnituraProducts(): void
    {
        $cat = Category::where('slug', 'pvh-furn')->firstOrFail();

        $items = [
            'Поворотно-откидной механизм Fores',
            'Поворотно-откидной механизм WinkHaus activPilot',
            'Ручка оконная Hoppe Secustik',
            'Ручка оконная Roto Swing',
            'Петля нижняя регулируемая',
            'Петля верхняя (ножницы)',
            'Запорная планка средняя',
            'Запорная планка ответная',
            'Микропроветривание (гребёнка)',
            'Ограничитель откидывания',
            'Цапфа противовзломная',
            'Угловой переключатель',
            'Основной запор поворотно-откидной',
            'Дополнительный запор средний',
            'Ответная планка для балконной двери',
            'Механизм подъёма створки',
            'Блокиратор ошибочного открывания',
            'Уплотнитель EPDM (чёрный)',
            'Уплотнитель TPE (серый)',
            'Подкладки под стеклопакет (комплект)',
        ];

        foreach ($items as $i => $name) {
            Product::create([
                'category_id'  => $cat->id,
                'name'         => $name,
                'slug'         => Str::slug($name) ?: 'furn-' . ($i + 1),
                'sku'          => 'FURN-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'type_label'   => 'Фурнитура ПВХ',
                'badge'        => 'Фурнитура',
                'badge_color'  => '#16A34A',
                'description'  => $name,
                'specs'        => ['Фурнитура', 'ПВХ'],
                'hardware'     => null,
                'card_bg'      => 'linear-gradient(135deg, #F0FDF4, #DCFCE7)',
                'sort_order'   => $i + 1,
            ]);
        }
    }
}

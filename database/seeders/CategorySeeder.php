<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Алюминий ─────────────────────────────────────────
        $alu = Category::create([
            'name'        => 'Алюминий',
            'slug'        => 'alu',
            'badge_color' => '#00074B',
            'sort_order'  => 1,
        ]);

        // Gold (sub-brand)
        $gold = Category::create([
            'parent_id'   => $alu->id,
            'name'        => 'Gold',
            'slug'        => 'gold',
            'badge_color' => '#00074B',
            'sort_order'  => 1,
        ]);

        foreach ([
            ['name' => 'Gold 45 Cold',               'slug' => 'gold-45-cold',  'sort_order' => 1],
            ['name' => 'Gold 55 Warm',                'slug' => 'gold-55-warm',  'sort_order' => 2],
            ['name' => 'Gold 74 Warm',                'slug' => 'gold-74-warm',  'sort_order' => 3],
            ['name' => 'Стоечно-ригельные системы',   'slug' => 'gold-facade',   'sort_order' => 4],
        ] as $child) {
            Category::create(array_merge($child, [
                'parent_id'   => $gold->id,
                'badge_color' => '#00074B',
            ]));
        }

        // AlProf (sub-brand)
        $alprof = Category::create([
            'parent_id'   => $alu->id,
            'name'        => 'AlProf',
            'slug'        => 'alprof',
            'badge_color' => '#00074B',
            'sort_order'  => 2,
        ]);

        foreach ([
            ['name' => 'AlProf 62 теплый',            'slug' => 'alprof-62',         'sort_order' => 1],
            ['name' => 'AlProf 72 теплый',            'slug' => 'alprof-72',         'sort_order' => 2],
            ['name' => 'AlProf HS Portal 176 мм',     'slug' => 'alprof-hs-portal',  'sort_order' => 3],
            ['name' => 'AlProf Гармошка 62 мм',       'slug' => 'alprof-accordion',  'sort_order' => 4],
        ] as $child) {
            Category::create(array_merge($child, [
                'parent_id'   => $alprof->id,
                'badge_color' => '#00074B',
            ]));
        }

        // ── ПВХ ──────────────────────────────────────────────
        $pvh = Category::create([
            'name'        => 'ПВХ',
            'slug'        => 'pvh',
            'badge_color' => '#2563EB',
            'sort_order'  => 2,
        ]);

        $pvhChildren = [
            ['name' => 'Sapa',       'slug' => 'sapa',       'sort_order' => 1],
            ['name' => 'Funke',      'slug' => 'funke',      'sort_order' => 2],
            ['name' => 'Seiger WDF', 'slug' => 'seiger-wdf', 'sort_order' => 3],
            ['name' => 'Grunder',    'slug' => 'grunder',    'sort_order' => 4],
        ];

        foreach ($pvhChildren as $child) {
            Category::create(array_merge($child, [
                'parent_id'   => $pvh->id,
                'badge_color' => '#2563EB',
            ]));
        }

        // Фурнитура (under ПВХ)
        Category::create([
            'parent_id'   => $pvh->id,
            'name'        => 'Фурнитура',
            'slug'        => 'pvh-furn',
            'badge_color' => '#16A34A',
            'sort_order'  => 5,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // Danh mục cha (parent_id = null)
        $parentCategories = [
            [
                'id' => 1,
                'name' => 'Điện tử',
                'code' => 'ELECTRONICS',
                'description' => 'Các sản phẩm điện tử và công nghệ',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Thời trang',
                'code' => 'FASHION',
                'description' => 'Quần áo, giày dép và phụ kiện thời trang',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Gia dụng',
                'code' => 'HOME',
                'description' => 'Đồ dùng gia đình và nội thất',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Sách & Văn phòng phẩm',
                'code' => 'BOOKS_OFFICE',
                'description' => 'Sách, văn phòng phẩm và dụng cụ học tập',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Thể thao & Du lịch',
                'code' => 'SPORTS_TRAVEL',
                'description' => 'Dụng cụ thể thao và đồ du lịch',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Danh mục con
        $childCategories = [
            // Điện tử
            [
                'name' => 'Điện thoại & Máy tính bảng',
                'code' => 'PHONES_TABLETS',
                'description' => 'Điện thoại di động, máy tính bảng và phụ kiện',
                'parent_id' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Laptop & Máy tính',
                'code' => 'LAPTOPS_COMPUTERS',
                'description' => 'Laptop, máy tính để bàn và linh kiện',
                'parent_id' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'TV & Thiết bị giải trí',
                'code' => 'TV_ENTERTAINMENT',
                'description' => 'TV, âm thanh và thiết bị giải trí',
                'parent_id' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Thời trang
            [
                'name' => 'Thời trang Nam',
                'code' => 'MEN_FASHION',
                'description' => 'Quần áo, giày dép nam',
                'parent_id' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Thời trang Nữ',
                'code' => 'WOMEN_FASHION',
                'description' => 'Quần áo, giày dép nữ',
                'parent_id' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Phụ kiện thời trang',
                'code' => 'FASHION_ACCESSORIES',
                'description' => 'Túi xách, đồng hồ, trang sức',
                'parent_id' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Gia dụng
            [
                'name' => 'Đồ điện gia dụng',
                'code' => 'HOME_APPLIANCES',
                'description' => 'Tủ lạnh, máy giặt, điều hòa',
                'parent_id' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Nội thất',
                'code' => 'FURNITURE',
                'description' => 'Bàn ghế, giường tủ, đồ trang trí',
                'parent_id' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Đồ dùng nhà bếp',
                'code' => 'KITCHENWARE',
                'description' => 'Nồi niêu, dao kéo, dụng cụ nấu ăn',
                'parent_id' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Sách & Văn phòng phẩm
            [
                'name' => 'Sách',
                'code' => 'BOOKS',
                'description' => 'Sách giáo khoa, tiểu thuyết, sách chuyên môn',
                'parent_id' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Văn phòng phẩm',
                'code' => 'OFFICE_SUPPLIES',
                'description' => 'Bút, giấy, dụng cụ văn phòng',
                'parent_id' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Thể thao & Du lịch
            [
                'name' => 'Dụng cụ thể thao',
                'code' => 'SPORTS_EQUIPMENT',
                'description' => 'Dụng cụ tập gym, bóng đá, cầu lông',
                'parent_id' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Đồ du lịch',
                'code' => 'TRAVEL_GEAR',
                'description' => 'Vali, ba lô, đồ dùng du lịch',
                'parent_id' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert dữ liệu
        DB::table('item_categories')->insert($parentCategories);
        DB::table('item_categories')->insert($childCategories);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ImageProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categoryIds = [];
        foreach ([
            'Thức ăn cho chó',
            'Thức ăn cho mèo',
            'Đồ chơi & vận động',
            'Phụ kiện hằng ngày',
            'Vệ sinh & chăm sóc',
            'Sức khỏe & bổ sung',
        ] as $categoryName) {
            $categoryIds[$categoryName] = Category::firstOrCreate(['name' => $categoryName])->idCat;
        }

        $products = [
            [
                'namePro' => 'Hạt cá hồi cho chó trưởng thành',
                'category' => 'Thức ăn cho chó',
                'description' => 'Công thức giàu đạm cá hồi, bổ sung omega-3 giúp bộ lông mềm mượt và phù hợp cho chó trưởng thành vận động mỗi ngày.',
                'count' => 26,
                'hot' => 1,
                'cost' => 289000,
                'discount' => 15,
                'image' => '11744188936.webp',
            ],
            [
                'namePro' => 'Pate gà mềm mịn cho mèo',
                'category' => 'Thức ăn cho mèo',
                'description' => 'Pate vị gà thơm mềm, độ ẩm cao và dễ ăn. Một bữa phụ nhẹ nhàng cho mèo kén ăn hoặc cần bổ sung nước.',
                'count' => 42,
                'hot' => 1,
                'cost' => 39000,
                'discount' => 0,
                'image' => '11744188980.webp',
            ],
            [
                'namePro' => 'Bánh thưởng vị gà ít béo',
                'category' => 'Thức ăn cho chó',
                'description' => 'Miếng thưởng nhỏ, thơm vị gà và ít béo để dùng trong lúc huấn luyện hoặc khen ngợi bé sau một ngày ngoan ngoãn.',
                'count' => 58,
                'hot' => 0,
                'cost' => 79000,
                'discount' => 10,
                'image' => '11744189056.webp',
            ],
            [
                'namePro' => 'Cát đậu nành khử mùi tự nhiên',
                'category' => 'Vệ sinh & chăm sóc',
                'description' => 'Cát đậu nành vón nhanh, bụi thấp và khử mùi dịu nhẹ. Có thể xả lượng nhỏ theo hướng dẫn của nhà sản xuất.',
                'count' => 31,
                'hot' => 1,
                'cost' => 179000,
                'discount' => 20,
                'image' => '11744189111.webp',
            ],
            [
                'namePro' => 'Bóng cao su phát âm thanh',
                'category' => 'Đồ chơi & vận động',
                'description' => 'Bóng cao su đàn hồi vừa phải, có âm thanh vui tai để khuyến khích chó vận động và chơi tương tác cùng chủ.',
                'count' => 18,
                'hot' => 1,
                'cost' => 99000,
                'discount' => 0,
                'image' => '11744189172.jpg',
            ],
            [
                'namePro' => 'Vòng cổ da mềm có chuông',
                'category' => 'Phụ kiện hằng ngày',
                'description' => 'Vòng cổ da mềm, nhẹ và có khóa điều chỉnh. Chuông nhỏ giúp dễ nhận biết vị trí của mèo trong nhà.',
                'count' => 23,
                'hot' => 0,
                'cost' => 129000,
                'discount' => 12,
                'image' => '11744353792.webp',
            ],
            [
                'namePro' => 'Lược chải lông chống rối',
                'category' => 'Vệ sinh & chăm sóc',
                'description' => 'Răng lược bo tròn giúp gỡ lông rụng và gỡ rối nhẹ nhàng, thích hợp cho cả chó mèo lông ngắn và lông vừa.',
                'count' => 34,
                'hot' => 0,
                'cost' => 149000,
                'discount' => 0,
                'image' => '11744603335.jpg',
            ],
            [
                'namePro' => 'Dầu gội yến mạch cho da nhạy cảm',
                'category' => 'Vệ sinh & chăm sóc',
                'description' => 'Dầu gội yến mạch làm sạch dịu nhẹ, lưu hương thanh mát và phù hợp cho thú cưng có làn da nhạy cảm.',
                'count' => 16,
                'hot' => 1,
                'cost' => 215000,
                'discount' => 15,
                'image' => '11744603398.webp',
            ],
            [
                'namePro' => 'Đệm ngủ lông mịn size M',
                'category' => 'Phụ kiện hằng ngày',
                'description' => 'Đệm êm có viền nâng đỡ, lớp vỏ tháo rời để vệ sinh và kích thước vừa cho mèo hoặc chó nhỏ.',
                'count' => 9,
                'hot' => 1,
                'cost' => 369000,
                'discount' => 20,
                'image' => '11744768386.webp',
            ],
            [
                'namePro' => 'Bát ăn inox chống trượt',
                'category' => 'Phụ kiện hằng ngày',
                'description' => 'Bát inox dễ rửa, không lưu mùi thức ăn và có đế chống trượt để giờ ăn của bé gọn gàng hơn.',
                'count' => 27,
                'hot' => 0,
                'cost' => 119000,
                'discount' => 0,
                'image' => '11744768508.webp',
            ],
            [
                'namePro' => 'Que gặm vệ sinh răng vị bạc hà',
                'category' => 'Sức khỏe & bổ sung',
                'description' => 'Que gặm có rãnh giúp làm sạch mảng bám trong lúc nhai, vị bạc hà nhẹ và phù hợp cho chó cỡ vừa.',
                'count' => 37,
                'hot' => 0,
                'cost' => 69000,
                'discount' => 10,
                'image' => '11744768615.webp',
            ],
            [
                'namePro' => 'Men vi sinh hỗ trợ tiêu hóa',
                'category' => 'Sức khỏe & bổ sung',
                'description' => 'Bột men vi sinh hỗ trợ hệ tiêu hóa khỏe mạnh, thích hợp dùng theo hướng dẫn khi bé thay đổi khẩu phần ăn.',
                'count' => 12,
                'hot' => 1,
                'cost' => 249000,
                'discount' => 5,
                'image' => '21744768508.webp',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::where('namePro', $data['namePro'])->first() ?? new Product();
            $product->namePro = $data['namePro'];
            $product->description = $data['description'];
            $product->count = $data['count'];
            $product->hot = $data['hot'];
            $product->cost = $data['cost'];
            $product->discount = $data['discount'];
            $product->idCat = $categoryIds[$data['category']];
            $product->save();

            ImageProduct::updateOrCreate(
                ['idPro' => $product->idPro],
                ['image' => $data['image']],
            );
        }
    }
}

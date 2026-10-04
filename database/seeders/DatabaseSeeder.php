<?php

namespace Database\Seeders;

use App\Models\ImageProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = [];
        foreach (['Thức ăn cho chó', 'Thức ăn cho mèo', 'Đồ chơi & vận động', 'Phụ kiện hằng ngày', 'Vệ sinh & chăm sóc', 'Sức khỏe & bổ sung'] as $categoryName) {
            $categoryIds[$categoryName] = Category::firstOrCreate(['name' => $categoryName])->idCat;
        }

        // Demo names and images describe the bundled photographs; prices are sample catalogue data.
        $products = [
            [
                'namePro' => 'Cát đậu nành Cature Natural Tofu Mix', 'legacy_name' => 'Hạt cá hồi cho chó trưởng thành',
                'category' => 'Vệ sinh & chăm sóc',
                'description' => 'Cát vệ sinh cho mèo Cature Natural Tofu Mix, túi 2,8 kg. Sử dụng và thay cát theo hướng dẫn trên bao bì.',
                'count' => 26, 'hot' => 1, 'cost' => 179000, 'discount' => 15,
                'image' => '11744188936.webp',
            ],
            [
                'namePro' => 'Chuông bấm huấn luyện thú cưng', 'legacy_name' => 'Pate gà mềm mịn cho mèo',
                'category' => 'Phụ kiện hằng ngày',
                'description' => 'Chuông để bàn có nút bấm hình dấu chân, dùng trong các buổi chơi và luyện tương tác với thú cưng. Có nhiều màu.',
                'count' => 42, 'hot' => 1, 'cost' => 59000, 'discount' => 0,
                'image' => '11744188980.webp',
            ],
            [
                'namePro' => 'Đồ chơi dây thừng hình xương T&D', 'legacy_name' => 'Bánh thưởng vị gà ít béo',
                'category' => 'Đồ chơi & vận động',
                'description' => 'Đồ chơi hình xương kết hợp dây thừng, có nhiều màu. Cho thú cưng chơi dưới sự quan sát và thay khi đồ chơi bị hỏng.',
                'count' => 58, 'hot' => 0, 'cost' => 79000, 'discount' => 10,
                'image' => '11744189056.webp',
            ],
            [
                'namePro' => 'Đồ chơi gặm hình xương T-Pets', 'legacy_name' => 'Cát đậu nành khử mùi tự nhiên',
                'category' => 'Đồ chơi & vận động',
                'description' => 'Đồ chơi hình xương màu đỏ dành cho những giờ chơi cùng thú cưng. Kiểm tra tình trạng đồ chơi trước mỗi lần sử dụng.',
                'count' => 31, 'hot' => 1, 'cost' => 69000, 'discount' => 20,
                'image' => '11744189111.webp',
            ],
            [
                'namePro' => 'Pate tươi cho chó mèo The Pet Vietnam', 'legacy_name' => 'Bóng cao su phát âm thanh',
                'category' => 'Thức ăn cho chó',
                'description' => 'Pate tươi The Pet Vietnam dành cho chó mèo, hộp 1 kg. Bảo quản và chia khẩu phần theo hướng dẫn của nhà sản xuất.',
                'count' => 18, 'hot' => 1, 'cost' => 149000, 'discount' => 0,
                'image' => '11744189172.jpg',
            ],
            [
                'namePro' => 'Hạt Royal Canin Kitten 400g', 'legacy_name' => 'Vòng cổ da mềm có chuông',
                'category' => 'Thức ăn cho mèo',
                'description' => 'Thức ăn khô Royal Canin Kitten, túi 400 g, dành cho mèo con từ 4 đến 12 tháng tuổi theo thông tin trên bao bì.',
                'count' => 23, 'hot' => 0, 'cost' => 129000, 'discount' => 12,
                'image' => '11744353792.webp',
            ],
            [
                'namePro' => 'Khăn tắm thấm hút cho chó mèo', 'legacy_name' => 'Lược chải lông chống rối',
                'category' => 'Vệ sinh & chăm sóc',
                'description' => 'Khăn lau cho thú cưng sau khi tắm, có nhiều màu và hộp đựng. Giặt sạch và phơi khô sau mỗi lần dùng.',
                'count' => 34, 'hot' => 0, 'cost' => 59000, 'discount' => 0,
                'image' => '11744603335.jpg',
            ],
            [
                'namePro' => 'Găng tay chải lông thú cưng', 'legacy_name' => 'Dầu gội yến mạch cho da nhạy cảm',
                'category' => 'Vệ sinh & chăm sóc',
                'description' => 'Găng tay chải lông với mặt gai màu xanh và dây đeo điều chỉnh ở cổ tay. Chải nhẹ nhàng và gỡ lông bám trên găng sau khi dùng.',
                'count' => 16, 'hot' => 1, 'cost' => 89000, 'discount' => 15,
                'image' => '21744603398.webp', 'gallery' => ['11744603398.webp', '31744603398.webp'],
            ],
            [
                'namePro' => "Pate cá hồi King's Pet", 'legacy_name' => 'Đệm ngủ lông mịn size M',
                'category' => 'Thức ăn cho mèo',
                'description' => "Pate đóng lon King's Pet vị cá biển và cá hồi. Xem khẩu phần, điều kiện bảo quản và hạn sử dụng trên nhãn sản phẩm.",
                'count' => 9, 'hot' => 1, 'cost' => 49000, 'discount' => 20,
                'image' => '11744768386.webp', 'gallery' => ['21744768386.webp'],
            ],
            [
                'namePro' => 'Pate tươi Googaga nhiều vị', 'legacy_name' => 'Bát ăn inox chống trượt',
                'category' => 'Thức ăn cho chó',
                'description' => 'Pate Googaga cho chó mèo với các lựa chọn gà bò, bò bí, heo và đà điểu. Giá minh họa cho một túi 200 g.',
                'count' => 27, 'hot' => 0, 'cost' => 39000, 'discount' => 0,
                'image' => '61744768508.webp',
            ],
            [
                'namePro' => 'Pate Royal Canin Hepatic cho chó', 'legacy_name' => 'Que gặm vệ sinh răng vị bạc hà',
                'category' => 'Sức khỏe & bổ sung',
                'description' => 'Thức ăn ướt Royal Canin Veterinary Hepatic dành cho chó. Dòng thức ăn thú y cần được sử dụng theo hướng dẫn của bác sĩ thú y.',
                'count' => 37, 'hot' => 0, 'cost' => 119000, 'discount' => 10,
                'image' => '21744768615.webp',
            ],
            [
                'namePro' => "Pate gà và gan King's Pet", 'legacy_name' => 'Men vi sinh hỗ trợ tiêu hóa',
                'category' => 'Thức ăn cho chó',
                'description' => "Pate đóng lon King's Pet vị gà và gan cho chó mèo. Bảo quản sau khi mở nắp và chia khẩu phần theo hướng dẫn trên bao bì.",
                'count' => 12, 'hot' => 1, 'cost' => 49000, 'discount' => 5,
                'image' => '31744768386.webp',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::where('namePro', $data['namePro'])->first()
                ?? Product::where('namePro', $data['legacy_name'])->first()
                ?? new Product();
            $product->namePro = $data['namePro'];
            $product->description = $data['description'];
            $product->count = $data['count'];
            $product->hot = $data['hot'];
            $product->cost = $data['cost'];
            $product->discount = $data['discount'];
            $product->idCat = $categoryIds[$data['category']];
            $product->save();

            // Keep the corrected primary image first, without deleting galleries or uploaded files.
            $primary = ImageProduct::where('idPro', $product->idPro)->orderBy('id')->first();
            if ($primary) {
                $primary->image = $data['image'];
                $primary->save();
            } else {
                ImageProduct::updateOrCreate(['idPro' => $product->idPro, 'image' => $data['image']], []);
            }
            foreach ($data['gallery'] ?? [] as $image) {
                ImageProduct::updateOrCreate(['idPro' => $product->idPro, 'image' => $image], []);
            }
        }
    }
}

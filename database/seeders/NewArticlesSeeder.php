<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class NewArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => '5 Bước Skincare cơ bản cho làn da căng bóng chuẩn Hàn',
                'description' => 'Khám phá quy trình chăm sóc da tối giản nhưng mang lại hiệu quả tối ưu, giúp làn da luôn rạng rỡ và tràn đầy sức sống.',
                'content' => '<p>Chăm sóc da không nhất thiết phải cầu kỳ với 10-12 bước. Xu hướng hiện nay là tập trung vào các bước cốt lõi giúp da khỏe từ bên trong.</p><h4>1. Làm sạch kép (Double Cleansing)</h4><p>Đây là bước quan trọng nhất để loại bỏ bụi bẩn, kem chống nắng và dầu thừa sau một ngày dài.</p><h4>2. Toner cân bằng</h4><p>Giúp da lấy lại độ pH tự nhiên và chuẩn bị cho các bước dưỡng tiếp theo.</p><h4>3. Serum đặc trị</h4><p>Tùy vào nhu cầu của da (cấp ẩm, làm sáng, chống lão hóa) để chọn loại serum phù hợp.</p>',
                'category' => 'Làm đẹp',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfeb450085?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Xu hướng Denim-on-denim quay trở lại mạnh mẽ trong năm 2026',
                'description' => 'Từng bị coi là lỗi thời, phong cách Denim-on-denim đang đổ bộ các sàn diễn thời trang lớn nhất thế giới mùa này.',
                'content' => '<p>Thời trang là một vòng tuần hoàn, và năm 2026 đánh dấu sự trở lại huy hoàng của phong cách Denim-on-denim cổ điển.</p><p>Các nhà thiết kế đã làm mới phong cách này bằng những đường cắt xẻ táo bạo và chất liệu bền vững hơn.</p>',
                'category' => 'Thời trang',
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Bí quyết sống thọ: Tại sao người Nhật luôn duy trì thói quen uống trà xanh?',
                'description' => 'Trà xanh không chỉ là một thức uống truyền thống mà còn là chìa khóa vàng cho sức khỏe và sự trường thọ của người dân xứ Phù Tang.',
                'content' => '<p>Tại các vùng xanh (Blue Zones) của Nhật Bản, trà xanh là thức uống không thể thiếu hàng ngày.</p><p>Hợp chất EGCG trong trà xanh giúp bảo vệ tế bào và giảm nguy cơ mắc các bệnh tim mạch.</p>',
                'category' => 'Sống khỏe',
                'image' => 'https://images.unsplash.com/photo-1523906630133-f1c83ff3f4b0?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Kính thực tế ảo thế hệ mới: Khi ranh giới giữa thực và ảo dần xóa nhòa',
                'description' => 'Với độ phân giải 8K và công nghệ cảm biến xúc giác, những chiếc kính VR/AR đời mới đang thay đổi cách chúng ta tương tác.',
                'content' => '<p>Công nghệ thực tế ảo đã tiến một bước dài. Giờ đây, trải nghiệm không chỉ dừng lại ở phần nhìn mà còn là cảm giác chân thực qua các bộ đồ haptic.</p>',
                'category' => 'Công nghệ',
                'image' => 'https://images.unsplash.com/photo-1622979135225-d2ba269cf1ac?q=80&w=800&auto=format&fit=crop',
            ]
        ];

        foreach ($posts as $p) {
            Post::create([
                'title' => $p['title'],
                'slug' => Str::slug($p['title']),
                'description' => $p['description'],
                'content' => $p['content'],
                'category' => $p['category'],
                'image' => $p['image'],
                'views' => rand(100, 900),
            ]);
        }
    }
}

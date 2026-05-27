<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('vi_VN');
        
        $vnTitles = [
            'Chính phủ ra mắt chính sách mới về phát triển công nghệ 4.0',
            'Thị trường chứng khoán hôm nay: VN-Index vượt mốc quan trọng',
            'Ra mắt mẫu xe điện mới với khả năng di chuyển 500km mỗi lần sạc',
            'Nhiều giải pháp sáng tạo để phát triển kinh tế xanh tại Việt Nam',
            'Đội tuyển quốc gia chuẩn bị bước vào vòng loại World Cup',
            'Khám phá những xu hướng thời trang mùa thu đông năm nay',
            'Bí quyết chăm sóc da khỏe đẹp từ các chuyên gia hàng đầu',
            'Ứng dụng trí tuệ nhân tạo vào hệ thống giáo dục hiện đại',
            'Startup Việt Nam nhận số vốn đầu tư kỷ lục từ quỹ quốc tế',
            'Du lịch trong nước phục hồi mạnh mẽ sau thời gian dài'
        ];
        
        $vnDescriptions = [
            'Đây là một bước tiến quan trọng trong việc thúc đẩy sự phát triển kinh tế, mang lại nhiều kỳ vọng cho các nhà đầu tư trong và ngoài nước.',
            'Sự kiện này đã thu hút đông đảo sự quan tâm của giới truyền thông và cộng đồng mạng. Nhiều chuyên gia đã đưa ra những phân tích đa chiều.',
            'Theo số liệu mới nhất, xu hướng này đang ngày càng mở rộng và ảnh hưởng tích cực đến thói quen sinh hoạt của nhiều người dân.',
            'Các chuyên gia dự đoán trong thời gian tới, thị trường sẽ tiếp tục có những biến động đáng chú ý, mở ra cả cơ hội và thách thức mới.'
        ];

        $title = $faker->randomElement($vnTitles) . ' - ' . $faker->word();
        $categories = ['Thời trang', 'Làm đẹp', 'Sống khỏe', 'Công nghệ', 'Thế giới', 'Kinh doanh', 'Giáo dục', 'Thể thao'];
        
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => $faker->randomElement($vnDescriptions),
            'content' => '<p>' . $faker->randomElement($vnDescriptions) . '</p><p>Nội dung chi tiết bài viết đang được cập nhật...</p>',
            'image' => 'https://picsum.photos/seed/' . $faker->uuid() . '/800/600',
            'category' => $faker->randomElement($categories),
            'views' => $faker->numberBetween(100, 10000),
            'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

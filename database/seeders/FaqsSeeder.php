<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'title' => 'Làm thế nào để doanh nghiệp của tôi xuất hiện cao hơn trên Google Maps?',
                'content' => 'Để doanh nghiệp của bạn xuất hiện cao hơn trên Google Maps, hãy đảm bảo thông tin của bạn chính xác và đầy đủ (địa chỉ, số điện thoại, giờ mở cửa, v.v.). Tạo nội dung mới thường xuyên như hình ảnh, bài đăng, và khuyến khích khách hàng đánh giá. Đồng thời, xác minh doanh nghiệp của bạn qua Google My Business.'
            ],
            [
                'title' => 'Đánh giá của khách hàng ảnh hưởng như thế nào đến thứ hạng?',
                'content' => 'Đánh giá tích cực từ khách hàng rất quan trọng trong việc cải thiện thứ hạng. Google Maps ưu tiên doanh nghiệp có nhiều đánh giá chất lượng, trung thực. Khuyến khích khách hàng để lại đánh giá và phản hồi chuyên nghiệp cho mọi đánh giá, dù tích cực hay tiêu cực.'
            ],
            [
                'title' => 'Tôi có cần cập nhật thông tin doanh nghiệp thường xuyên không?',
                'content' => 'Có, việc cập nhật thông tin doanh nghiệp giúp Google thấy bạn hoạt động tích cực. Hãy đảm bảo giờ mở cửa, dịch vụ, và các thông tin liên quan luôn chính xác. Điều này cũng tạo lòng tin với khách hàng.'
            ],
            [
                'title' => 'Làm thế nào để khách hàng tìm thấy tôi dễ dàng hơn?',
                'content' => 'Sử dụng từ khóa liên quan đến ngành nghề của bạn trong tên doanh nghiệp, mô tả, và các bài đăng trên Google My Business. Điều này giúp Google hiểu rõ về lĩnh vực kinh doanh của bạn và kết nối với khách hàng tiềm năng.'
            ],
            [
                'title' => 'Việc thêm hình ảnh có giúp cải thiện thứ hạng không?',
                'content' => 'Có, hình ảnh chất lượng giúp thu hút sự chú ý và tương tác của khách hàng. Hãy thêm hình ảnh thực tế về không gian, sản phẩm, dịch vụ của bạn thường xuyên để giữ cho trang Google Maps của bạn luôn sinh động và chuyên nghiệp.'
            ],
            [
                'title' => 'Có cách nào để tối ưu hóa Google My Business ngoài việc đánh giá không?',
                'content' => 'Ngoài việc đánh giá, bạn có thể tối ưu hóa Google My Business bằng cách sử dụng các bài đăng cập nhật, cung cấp ưu đãi, sự kiện, và trả lời các câu hỏi thường gặp. Tính năng hỏi & đáp (Q&A) cũng là một công cụ quan trọng để tương tác với khách hàng.'
            ],
            [
                'title' => 'Bao lâu thì tôi sẽ thấy kết quả sau khi tối ưu Google Maps?',
                'content' => 'Thời gian để thấy kết quả phụ thuộc vào sự cạnh tranh trong khu vực và ngành của bạn. Tuy nhiên, nếu bạn kiên trì và duy trì việc tối ưu hóa, bạn có thể thấy sự cải thiện về thứ hạng trong vòng vài tuần đến vài tháng.'
            ]
        ];
        Faq::insert($faqs);
    }
}

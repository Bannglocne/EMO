# Emo

![Logo](logo.png)

* Với việc nhiều người ngại gặp bác sĩ và các chuyên gia tâm lý, "Emo" là một trang web sẽ hỗ trợ mọi người tiếp cận với những chuyên gia hay bác sĩ tâm lý dưới thân phận ẩn danh. Ngoài ra, trang web cũng hỗ trợ cho họ xem tình trạng tâm lý cũng mình theo thời gian thông qua việc viết nhật ký hàng ngày.

# Giới thiệu
Trang web gồm các chức năng chính:
- Đăng nhập và đăng ký tài khoản
- Đọc bài viết được đăng
- Soạn thư cho chuyên gia/người dùng và xem thư phản hồi
- Viết nhật ký và xem nhật ký hàng ngày
- Xem rừng cây cùng mọi người
- Công khai rừng/nhật ký

# Thành viên
Trang web được phát triển bởi:
- Phan Thanh Sơn: Trưởng nhóm
- Nguyễn Minh Khôi
- Hoàng Thị Xuân Hoà
- Nguyễn Xuân Lộc

# Thiết lập

## 1. Cài đặt XAMPP
- Cài đặt XAMPP qua trang: https://www.apachefriends.org/download.html
- Nhấn vào file .exe vừa tải xuống để bắt đầu thiết lập, chọn "Next >" cho tất cả các thông báo 
- Mở thư mục xampp (Nơi cài đặt XAMPP), chọn thư mục htdocs sau đó xoá tệp index.php, đưa thư mục của dự án vào trong

## Thiết lập cơ sở dữ liệu
- Mở XAMPP, chọn action "Start" cho 2 module "Apache" và "MySQL", chọn action "Admin" cho module "MySQL"
- Lúc này trình duyệt sẽ mở chạy trang: localhost/phpmyadmin/
- Sau đó chọn tải khoản người dùng, nhấn vào "Tạo tài khoản người dùng mới"
- Nhập thông tin đăng nhập:
  - Tài khoản: emo
  - Tên máy: localhost
  - Mật khẩu: 123456EmoR2
- Tích hết 2 ô trong phần "Tạo cơ sở dữ liệu cho người dùng" và tích vào ô "Theo dõi bảng" bên dưới
- Bấm nút "Thực hiện"
- Chọn cơ sở dữ liệu "emo", chọn SQL sau đó dán toàn bộ đoạn code trong tệp "emo.sql" và bấm nút thực hiện
- **Lưu ý: Với bác sĩ tâm lý sẽ có một trang web riêng, thư của người dùng gửi về sẽ được hiển thị ở đó. Để dảm bảo thì việc chỉ định một tài khoản là tài khoản của bác sĩ tâm lý sẽ được làm thủ công bằng cách thay đổi "role" (vai trò) của tài khoản thành "expert" trong bảng "users" của cơ sở dữ liệu "emo".**

**LƯU Ý: ĐẦU TIÊN CẦN TẠO ÍT NHẤT 1 TÀI KHOẢN CHUYÊN GIA TRƯỚC**

## Chạy chương trình
- Trên thanh tìm kiếm của trình duyệt, gõ "localhost" và bấm Enter, trình duyệt sẽ tải trang "Index of"
- Chọn vào tên thư mục đã chứa toàn bộ tệp của dự án (Mặc định có tên là "The_Rule_Breakers")
- Trang frontend: Chọn "frontend" - Trang chính người dùng và chuyên gia
- Trang Backend: Chọn "backend" - Trang cho admin, dùng để quản lý người dùng và thêm các bài viết mới

## Các công cụ sử dụng
- Frontend: PHP, HTML, CSS, Javascript
- Backend: PHP, HTML, CSS, Javascript
- CSDL: PHPMyadmin
- Phần mềm: XAMPP
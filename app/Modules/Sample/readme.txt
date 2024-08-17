======= Cấu trúc cơ bản một Module =======
* Config : Tạo cấu hình cho của module -> Tạo tiền tố cho tất cả các hằng số : return array('sample' => $configs);
* Controllers : Tạo các controller của module (Nếu có nhiều Controller thì có thể nhóm theo Folder)
* Database : Tạo Migrate, Seeder... của module
* Helpers: Tạo Helper xử lý riêng cho module
* Polices: Tạo Policy xử lý riêng cho module
* Requests : Tạo Request cho module (Nếu có nhiều Request có thể nhóm lại theo Folder)
* Resources : Tạo Resource trả về API (Nếu có nhiều Resource có thể nhóm lại theo Folder)
* Routers : Tạo Route cho module (Nếu có nhiều Route có thể nhóm lại theo Folder)
* Services : Tạo Service cho module (Nếu có nhiều Service có thể nhóm lại theo Folder)
* Views : Tạo View cho module (Nếu có nhiều View có thể nhóm lại theo Folder)
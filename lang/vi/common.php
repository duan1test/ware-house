<?php
return [
    'app_name' => 'CS-Warehouse',
    'auth' => [
        'remember' => 'Lưu đăng nhập',
        'login' => 'Đăng nhập',
        'user_name_required' => 'Vui lòng nhập tài khoản',
        'password_required' => 'Vui lòng nhập mật khẩu',
        'user_name' => 'Tài khoản',
        'login_error' => 'Tài khoản hoặc mật khẩu không chính xác, vui lòng nhập lại',
    ],
    'user' => [
        'title' => 'Người dùng',
        'index' => 'Danh sách người dùng',
        'create' => 'Tạo mới người dùng',
        'not_trashed' => 'Tất cả',
        'only_trashed' => 'Dừng hoạt động',
        'with_trashed' => 'Đang hoạt động',
        'trashed' => 'Trạng thái',
        'page_description' => 'Vui lòng xem lại dữ liệu trong bảng dưới đây.',
        'delete' => 'Xóa người dùng',
        'updated' => 'Cập nhật người dùng thành công.',
        'created' => 'Tạo mới người dùng thành công.',
        'deleted' => 'Xóa người dùng thành công.',
        'update' => 'Cập nhật người dùng',
        'update_password' => 'Cập nhật mật khẩu',
    ],
    'role' => [
        'index' => 'Danh sách quyền',
        'create' => 'Tạo mới quyền',
        'not_trashed' => 'Tất cả',
        'only_trashed' => 'Đã xóa',
        'with_trashed' => 'Chưa xóa',
        'trashed' => 'Trạng thái',
        'created' => 'Tạo mới quyền thành công.',
        'delete' => 'Xóa quyền',
        'deleted' => 'Xóa quyền thành công.',
        'updated' => 'Cập nhật quyền thành công.',
        'update' => 'Cập nhật quyền',
        'full' => 'Lựa chọn tất cả quyền',
        'cannot_delete_assigned_role' => 'Không thể xóa quyền',
    ],
    'page_description' => 'Vui lòng điền dữ liệu xuống form dưới đây để tạo bản ghi.',
    'warehouse' => [
        'title' => 'Kho',
        'index' => 'Danh sách kho',
        'detail' => 'Chi tiết kho',
        'delete' => 'Xoá kho',
        'restore' => 'Phục hồi',
        'permanently_delete' => 'Xoá vĩnh viễn',
        'update' => 'Cập nhật kho',
        'create' => 'Tạo mới kho',
        'import' => 'Nhập dữ liệu kho',
        'export' => 'Xuất dữ liệu kho',
        'active' => 'Hoạt động',
        'inactive' => 'Không hoạt động',
        'not_trashed' => 'Tất cả',
        'with_trashed' => 'Đang sử dụng',
        'only_trashed' => 'Không sử dụng',
        'delete_confirm' => 'Bạn có chắc muốn xoá không?',
        'submit_import' => 'Tải lên',
        'download' => 'Tải xuống file lỗi',
        'text_import' => 'Vui lòng tải lên tệp excel để nhập hồ sơ.',
        'title_import' => 'Nhập dữ liệu kho',
        'chose_file' => 'Chọn tệp',
        'chose_file_end' => 'hoặc kéo và thả',
        'import_columns' => 'Tệp Excel phải có :columns',
        'import_data' => 'Bạn phải điền các cột :columns để nhập dữ liệu cùng với cột :column là :data',
    ],
    'category' => [
        'title' => 'Danh mục sản phẩm',
        'index' => 'Danh sách danh mục',
        'create' => 'Tạo mới danh mục',
        'update' => 'Cập nhật danh mục',
        'import' => 'Nhập dữ liệu danh mục',
        'export' => 'Xuất dữ liệu danh mục',
        'submit_import' => 'Tải lên',
        'chose_file' => 'Chọn tệp',
        'chose_file_end' => 'hoặc kéo và thả',
        'text_import' => 'Vui lòng tải lên tệp excel để nhập hồ sơ.',
        'title_import' => 'Nhập dữ liệu danh mục',
        'download' => 'Tải xuống file lỗi',
        'import_columns' => 'Tệp Excel phải có :columns',
        'import_data' => 'Bạn phải điền các cột :columns để nhập dữ liệu',
    ],
    'pagination' => [
        'info' => 'Hiển thị :perpage trong tổng số :total bản ghi',
    ],
    'create' => 'Tạo',
    'filters' => 'Lọc',
    'permanently_delete' => 'Xoá vĩnh viễn',
    'paginate_info' => 'Hiển thị từ :from đến :to trên tổng số :total.',
    'search' => 'Tìm kiếm',
    'no_data' => 'Không có dữ liệu.',
    'save' => 'Lưu',
    'confirm_delete' => 'Bạn có chắc chắn muốn xóa bản ghi này?',
    'confirm_restore' => 'Bạn có chắc chắn muốn khôi phục bản ghi này?',
    'confirm_permanent_delete' => 'Bạn có chắc chắn muốn xóa bản ghi này?',
    'alert_permanent_delete' => 'Sau khi xóa, toàn bộ tài nguyên và dữ liệu của nó sẽ bị xóa vĩnh viễn.',
    'swal_button' => [
        'cancel' => 'Hủy bỏ',
        'confirm' => 'Xác nhận',
    ],
    'can_view_all_record' => 'Có thể xem tất cả bản ghi',
    'can_edit_all_record' => 'Có thể sửa tất cả bản ghi',
    'permission' => [
        'update' => 'Cập nhật phân quyền',
        'select_all' => 'Lựa chọn tất cả phân quyền',
        'updated' => 'Cập nhật phân quyền thành công.',
    ],
    'items' => [
        'title' => 'Sản phẩm',
        'create' => 'Tạo mới sản phẩm',
        'index' => 'Danh sách sản phẩm',
        'detail' => 'Chi tiết sản phẩm',
        'created' => 'Tạo mới sản phẩm thành công.',
        'only_trashed' => 'Đã xoá',
        'with_trashed' => 'Chưa xoá',
        'not_trashed' => 'Tất cả',
        'update' => 'Cập nhật sản phẩm',
        'updated' => 'Cập nhật sản phẩm thành công.',
        'deleted' => 'Xóa sản phẩm thành công.',
        'variant' => 'Sản phẩm con',
        'option' => 'Tùy chọn',
        'variant_name' => 'Tên đặc điểm',
        'import' => 'Nhập dữ liệu sản phẩm',
        'export' => 'Xuất dữ liệu sản phẩm',
        'title_import' => 'Nhập dữ liệu sản phẩm',
        'text_import' => 'Vui lòng tải lên tệp excel để nhập sản phẩm.',
        'chose_file' => 'Chọn tệp',
        'chose_file_end' => 'hoặc kéo và thả',
        'import_columns' => 'Tệp Excel phải có :columns',
        'import_data' => 'Bạn phải điền các cột :columns để nhập dữ liệu',
        'trail' => 'Lịch sử chỉnh sửa',
        'download' => 'Tải xuống file lỗi',
        'instruct' => 'Thêm sản phẩm vào danh sách bằng cách tìm kiếm',
    ],
    'transfer' => [
        'title' => 'Chuyển kho',
        'create' => 'Tạo mới chuyển kho',
        'index' => 'Danh sách chuyển kho',
        'only_trashed' => 'Đã xoá',
        'with_trashed' => 'Chưa xoá',
        'not_trashed' => 'Tất cả',
        'update' => 'Cập nhật chuyển kho',
        'select_warehouse' => 'Chọn kho',
        'detail' => 'Chi tiết chuyển kho',
        'draft' => 'Bản ghi này là bản nháp',
        'instruct' => 'Thêm sản phẩm vào danh sách bằng cách tìm kiếm hoặc quét mã',
        'delete' => 'Xóa vận chuyển',
        'select_user' => 'Chọn người dùng',
        'select_category' => 'Chọn danh mục',
    ],
    'adjustment' => [
        'title' => 'Điều chỉnh',
        'index' => 'Danh sách điều chỉnh',
        'create' => 'Tạo điều chỉnh mới',
        'update' => 'Cập nhật điều chỉnh',
        'damage' => 'Hư hỏng',
        'addition' => 'Thêm',
        'subtraction' => 'Bớt',
        'detail' => 'Chi tiết điều chỉnh',
        'draft' => 'Bản ghi này vẫn là một bản nháp',
        'delete' => 'Xóa điều chỉnh',
    ],
    'checkin' => [
        'title' => 'Nhập kho',
        'index' => 'Danh sách nhập kho',
        'create' => 'Tạo mới nhập kho',
        'edit' => 'Cập nhật nhập kho',
        'detail' => 'Chi tiết nhập kho',
        'delete' => 'Xóa nhập kho',
        'instruct' => 'Thêm mặt hàng vào danh sách bằng cách tìm kiếm hoặc quét mã',
    ],
    'checkout' => [
        'title' => 'Xuất kho',
        'index' => 'Danh sách xuất kho',
        'create' => 'Tạo mới xuất kho',
        'edit' => 'Cập nhật xuất kho',
        'detail' => 'Chi tiết xuất kho',
        'delete' => 'Xóa xuất kho',
        'instruct' => 'Thêm mặt hàng vào danh sách bằng cách tìm kiếm hoặc quét mã',
    ],
    'select' => 'Lựa chọn',
    'select_file' => 'Chọn tệp',
    'no_file_selected' => 'Không có file nào được chọn',
    'import' => 'Nhập',
    'sweat_alert' => [
        'sweat_alert' => 'Chọn sản phẩm con',
        'cancel' => 'Hủy',
        'select' => 'Chọn',
    ],
    'loading' => 'Đang tải',
    'tap_to_cancel' => 'Ấn để hủy',
    'contact' => [
        'title' => 'Liên hệ',
        'create' => 'Tạo mới liên hệ',
        'index' => 'Danh sách liên hệ',
        'detail' => 'Chi tiết liên hệ',
        'created' => 'Tạo mới liên hệ thành công.',
        'only_trashed' => 'Đã xoá',
        'with_trashed' => 'Chưa xoá',
        'not_trashed' => 'Tất cả',
        'update' => 'Cập nhật liên hệ',
        'updated' => 'Cập nhật liên hệ thành công.',
        'deleted' => 'Xóa liên hệ thành công.',
        'import' => 'Nhập dữ liệu liên hệ',
        'export' => 'Xuất dữ liệu liên hệ',
        'title_import' => 'Nhập dữ liệu liên hệ',
        'text_import' => 'Vui lòng tải lên tệp excel để nhập liên hệ.',
        'chose_file' => 'Chọn tệp',
        'chose_file_end' => 'hoặc kéo và thả',
        'import_columns' => 'Tệp Excel phải có :columns',
        'import_data' => 'Bạn phải điền các cột :columns để nhập dữ liệu',
        'download' => 'Tải xuống file lỗi',
        'delete' => 'Xóa liên hệ',
    ],
    'unit' => [
        'title' => 'Đơn vị',
        'index' => 'Danh sách đơn vị',
        'create' => 'Tạo mới đơn vị',
        'import' => 'Nhập dữ liệu đơn vị',
        'export' => 'Xuất dữ liệu đơn vị',
        'title_import' => 'Nhập dữ liệu đơn vị',
        'text_import' => 'Vui lòng tải lên tệp excel để nhập đơn vị.',
        'chose_file' => 'Chọn tệp',
        'chose_file_end' => 'hoặc kéo và thả',
        'import_columns' => 'Tệp Excel phải có :columns',
        'import_data' => 'Bạn phải điền các cột :columns để nhập dữ liệu',
        'update' => 'Cập nhật đơn vị',
        'delete' => 'Xóa đơn vị',
    ],
    'print' => 'in', 
    'filter' => 'Lọc theo trạng thái',
    'reset' => 'Làm mới',
    'detail' => 'Thông tin chi tiết',
    'edit' => 'Cập nhật',
    'delete' => 'Xóa',
    'soft-delete' => 'Xóa vĩnh viễn',
    'restore' => 'Khôi phục',
    'trail' => 'Lịch sử chỉnh sửa',
    'translation_role'  => [
        'update'        => 'Cập nhật',
        'delete'        => 'Xóa',
        'create'        => 'Tạo mới',
        'read'          => 'Xem',
        'users'         => 'người dùng',
        'roles'         => 'quyền',
        'warehouses'    => 'kho',
        'categories'    => 'danh mục',
        'items'         => 'sản phẩm',
        'transfers'     => 'chuyển kho',
        'adjustments'   => 'điều chỉnh',
        'checkins'      => 'nhập kho',
        'checkouts'     => 'xuất kho',
        'import'        => 'Nhập',
        'units'         => 'đơn vị',
        'contacts'      => 'liên hệ',
    ],
    'settings' => [
        'setting'               => 'Cài đặt',
        'note'                  => 'Vui lòng điền vào mẫu dưới đây để cập nhật cài đặt.',
        'preview'               => 'Xem trước',
        'formart_date_number'   => 'Định dạng số và ngày',
        'number'                => 'Số',
        'date'                  => 'Ngày',
        'datetime'              => 'Ngày giờ',
    ],
    'account'=> [
        'manage' => 'Quản lý tài khoản',
        'profile' => 'Hồ sơ',
        'log_out' => 'Đăng xuất',
        'update_password_title' => 'Cập nhật mật khẩu',
        'update_password_description' => 'Hãy chắc chắn rằng bạn sử dụng mật khẩu dài,ngẫu nhiên để đảm bảo an toàn.',
        'current_password' => 'Mật khẩu cũ',
        'new_password' =>  'Mật khẩu mới',
        'password' => 'Mật khẩu',
        'confirm_password' => 'Nhập lại mật khẩu',
        'save' => 'Lưu',
        'browser_sessions' => 'Phiên trình duyệt',
        'sessions_description' => 'Quản lý và đăng xuất các phiên bản hoạt động của bạn trên các trình duyệt và thiết bị khác.',
        'sessions_content' => 'Nếu cần thiết, bạn có thể đăng xuất khỏi tất cả các phiên bản trình duyệt khác trên tất cả các thiết bị của mình. Một số phiên bản gần đây của bạn được liệt kê bên dưới; tuy nhiên, danh sách này có thể không đầy đủ. Nếu bạn cảm thấy tài khoản của mình đã bị xâm phạm, bạn nên cập nhật mật khẩu của mình.',
        'logout_content' => 'Vui lòng nhập mật khẩu để xác nhận bạn muốn đăng xuất khỏi các phiên bản trình duyệt khác trên mọi thiết bị của mình.',
        'logout_session' => 'Thoát khỏi phiên bản trình duyệt khác',
        'cancel' => 'Hủy',
        'delete' => 'Xóa tài khoản',
        'permently_delete' => 'Xóa vĩnh viễn tài khoản',
        'delete_content' => 'Sau khi tài khoản của bạn bị xóa, tất cả tài nguyên và dữ liệu của tài khoản đó sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào mà bạn muốn giữ lại.',
        'confirm_delete' => 'Bạn có chắc chắn muốn xóa tài khoản của mình không? Sau khi xóa tài khoản, tất cả tài nguyên và dữ liệu của tài khoản sẽ bị xóa vĩnh viễn. Vui lòng nhập mật khẩu để xác nhận bạn muốn xóa vĩnh viễn tài khoản của mình.',
        'profile_information' => 'Thông tin hồ sơ',
        'name' => 'Tên',
        'profile_description' =>'Cập nhật thông tin hồ sơ tài khoản và địa chỉ email của bạn.',
        'email_not_verified' => 'Địa chỉ email của bạn chưa được xác minh.',
        'email_verify' => 'Nhấp vào đây để gửi lại email xác minh.',
        'link_verify' => 'Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.',
    ],
    'report' => [
        'title'                 => 'Báo cáo',
        'transfer'              => 'Báo cáo chuyển kho',
        'checkin'               => 'Báo cáo nhập kho',
        'checkout'              => 'Báo cáo xuất kho',
        'adjustments'           => 'Báo cáo điều chỉnh',
        'total'                 => 'Tổng số bản ghi',
        'total_messages'        => 'Vui lòng xem lại tổng số bản ghi bên dưới',
        'link'                  => 'Vui lòng chọn để xem báo cáo',
        'total_sub'             => [
            'items'         => 'Sản phẩm',
            'contacts'      => 'Liên hệ',
            'categories'    => 'Danh mục',
            'warehouses'    => 'Kho',
            'checkins'      => 'Nhập kho',
            'checkouts'     => 'Xuất kho',
            'transfers'     => 'Chuyển kho',
            'adjustments'   => 'Điều chỉnh',
            'units'         => 'Đơn vị',
            'users'         => 'Người dùng',
            'roles'         => 'Quyền',
        ],
        'select_user'           => 'Chọn người tạo',
    ],
    'dashboard' => [
        'index'              => 'Trang chủ',
        'checkin'            => 'Nhập kho',
        'checkout'           => 'Xuất kho',
        'adjustment'         => 'Điều chỉnh',
        'transfer'           => 'Chuyển kho',
        'item'               => 'Sản phẩm',
        'contact'            => 'Liên hệ',
        'month'              => 'Tháng',
        'bar_chart_title'    => 'Tổng quan năm',
        'bar_chart_subtitle' => 'Vui lòng xem biểu đồ bên dưới',
        'radial_chart_title' => 'Tổng quan tháng',
        'pie_chart_title'    => 'Top sản phẩm',
        'pie_chart_subtitle' => 'Top 10 sản phẩm trong tháng',
        'movement'           => 'Biến động',
    ],
];

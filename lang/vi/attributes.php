<?php

return [
    'user' => [
        'name' => 'Tên',
        'password' => 'Mật khẩu',
        'username' => 'Tên người dùng',
        'email' => 'Địa chỉ email',
        'confirm_password' => 'Xác nhận mật khẩu',
        'warehouse' => 'Kho',
        'phone' => 'Số điện thoại',
        'roles' => 'Quyền',
        'permissions' => 'Phân quyền',
        'soft_delete' => 'Đây là người dùng bị xoá tạm thời',
    ],
    'role' => [
        'name' => 'Tên',
        'soft_delete' => 'Đây là quyền bị xoá tạm thời',
    ],
    'warehouse' => [
        'code' => 'Mã kho',
        'name' => 'Tên kho',
        'phone' => 'Số điện thoại',
        'email' => 'Địa chỉ email',
        'logo' => 'Ảnh logo',
        'current_logo' => 'Logo hiện tại',
        'preview_logo' => 'Xem trước ảnh',
        'soft_delete' => 'Đây là kho bị xoá tạm thời',
        'contact' => 'Liên hệ',
        'location' => 'Vị trí',
        'address' => 'Địa chỉ',
        'status' => 'Trạng thái',
        'active' => 'Hoạt động',
        'inactive' => 'Không hoạt động',
        'not_trashed' => 'Tất cả',
        'with_trashed' => 'Đang sử dụng',
        'only_trashed' => 'Không sử dụng',
    ],
    'category' => [
        'code' => 'Mã danh mục',
        'name' => 'Tên danh mục',
        'parent_id' => 'Danh mục cấp trên',
        'parent_code' => 'Mã danh mục cấp trên',
        'soft_delete' => 'Đây là danh mục bị xoá tạm thời',
        'status' => 'Trạng thái',
        'not_trashed' => 'Tất cả',
        'with_trashed' => 'Đang sử dụng',
        'only_trashed' => 'Không sử dụng',
        'all' => 'Tất cả',
    ],
    'item' => [
        'name' => 'Tên',
        'code' => 'Mã',
        'category' => 'Danh mục',
        'unit' => 'Đơn vị',
        'barcode_symbology' => 'Ký mã vạch',
        'sku' => 'SKU',
        'details' => 'Chi tiết',
        'photo' => 'Hình ảnh',
        'rack_location' => 'Vị trí để hàng',
        'track_weight' => 'Theo dõi trọng lượng',
        'track_serial' => 'Theo dõi số serial',
        'track_quantity' => 'Theo dõi số lượng',
        'alert_quantity' => 'Cảnh báo',
        'alert_quantity_stock_on' => 'Cảnh báo khi hàng tồn kho thấp',
        'options' => 'Lựa chọn',
        'variants' => 'Đặc điểm',
        'variant_name' => 'Tên đặc điểm',
        'relations' => 'Thông tin thêm',
        'has_variants' => 'Theo dõi đặc điểm, ví dụ: kích thước hoặc/và màu sắc',
        'weight' => 'Trọng lượng',
        'quantity' => 'Số lượng',
        'soft_delete' => 'Đây là sản phẩm bị xoá tạm thời',
        'created_at' => 'Thời gian tạo',
        'warehouse' => 'Kho hàng',
        'variation' => 'Đặc điểm',
        'variant_alert' => 'Việc thay đổi các đặc điểm sau khi có hàng tồn kho có thể dẫn đến sai lệch số lượng tồn kho',
        'has_serial' => 'Tồn tại Sê-ri',
        'has_variant' => 'Tồn tại biến thể',
        'stock' => 'Hàng tồn kho',
    ],
    'transfer' => [
        'transfer' => 'Trạng thái',
        'relations' => 'Thông tin thêm',
        'details' => 'Chi tiết',
        'ref' => 'Mã chuyển kho',
        'date' => 'Ngày',
        'draft' => 'Bản nháp',
        'user' => 'Người tạo',
        'comment' => 'Ghi chú',
        'warehouse_to' => 'Đến kho',
        'warehouse_from' => 'Từ kho',
        'status' => 'Trạng thái',
        'not_trashed' => 'Tất cả',
        'with_trashed' => 'Chưa xoá',
        'only_trashed' => 'Đã xoá',
        'not_draft' => 'Tất cả',
        'only_draft' => 'Bản nháp',
        'items' => 'Sản phẩm',
        'with_draft' => 'Không bao gồm bản nháp',
        'search_item' => 'Tìm kiếm sản phẩm',
        'attachment' => 'Tệp đính kèm',
        'import_file' => 'Chọn tệp hoặc kéo và thả/ Bạn có thể chọn các tệp .png, .jpg, .pdf, .docx, .xlsx & .zip',
        'create_at' => 'Tạo lúc',
        'soft_delete' => 'Đây là vận chuyển bị xoá tạm thời',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'start_created_at' => 'Ngày tạo',
        'end_created_at' => 'Ngày kết thúc tạo',
        'category' => 'Danh mục',
        'reset' => 'Đặt lại',
        'submit' => 'Áp dụng',
        'trashed' => 'Bao gồm đã xóa',
        'draft' => 'Bản nháp',
    ],
    'adjustment' => [
        'type' => 'Loại',
        'warehouse' => 'Kho',
        'adjustment' => 'Điều chỉnh',
        'relation' => 'Thông tin thêm',
        'user' => 'Người tạo',
        'detail' => 'Chi tiết',
        'soft_delete' => 'Đây là điều chỉnh bị xoá tạm thời',
        'quantity' => 'Số lượng',
        'ref' => 'Mã điều chỉnh',
    ],
    'checkin' => [
        'checkin' => 'Nhập kho',
        'contact' => 'Người liên hệ',
        'ref' => 'Mã nhập kho',
        'warehouse' => 'Kho',
        'soft_delete' => 'Đây là Nhập kho bị xóa tạm thời',
    ],
    'checkout' => [
        'ref' => 'Mã xuất kho',
        'checkout' => 'Xuất kho',
        'contact' => 'Người liên hệ',
        'warehouse' => 'Kho',
        'soft_delete' => 'Đây là xuất kho bị xóa tạm thời',
    ],
    'contact' => [
        'name' => 'Tên liên hệ',
        'email' => 'email',
        'details' => 'thông tin chi tiết',
        'phone' => ' số điện thoại',
        'soft_delete' => 'Đây là liên hệ bị xóa tạm thời',

    ],
    'unit' => [
        'name' => 'Tên đơn vị',
        'code' => 'Mã đơn vị',
        'base_unit' => 'Đơn vị cơ sở',
        'operator' => 'Phép tính',
        'lw-name' => 'tên đơn vị',
        'lw-code' => 'mã đơn vị',
        'lw-base_unit' => 'đơn vị cơ sở',
        'lw-operator' => 'phép tính',
        'operator_sub' => [
            'plus' => 'Cộng',
            'minus' => 'Trừ',
            'multiply' => 'Nhân',
            'divide' => 'Chia',
        ],
        'operation_value' => 'Giá trị quy đổi',
        'lw-operation_value' => 'giá trị quy đổi',
        'status' => 'Trạng thái',
        'with_trashed' => 'Chưa xoá',
        'not_trashed' => 'Tất cả',
        'only_trashed' => 'Đã xoá',
        'formula' => 'Công thức',
        'soft_delete' => 'Đây là đơn vị bị xóa tạm thời',
    ],
    'settings' => [
        'web_name'          => 'Tên trang web',
        'language'          => 'Ngôn ngữ',
        'language_key'      => 'ngôn ngữ',
        'language_sub'      => [
            'vi'        => 'Tiếng việt',
            'en'        => 'Tiếng anh',
        ],
        'reference'         => 'Thẩm quyền giải quyết',
        'reference_key'     => 'thẩm quyền giải quyết',
        'ref_sub'           => [
            'ulid'      => 'ULID - Mã định danh có thể sắp xếp theo từ điển duy nhất trên toàn cầu',
            'ai'        => 'Tự động tăng (chỉ MYSQL)',
            'uniqid'    => 'Uniqid - PHP Generate a Unique ID',
            'uuid'      => 'UUID - Mã định danh duy nhất toàn cầu',
        ],
        'currency_code'     => 'Mã tiền tệ',
        'currency_code_key' => 'mã tiền tệ',
        'weight_unit'       => 'Đơn vị trọng lượng',
        'over_selling'      => 'Cho phép bán quá mức',
        'track_weight'      => 'Theo dõi trọng lượng của mặt hàng',
        'sidebar'           => 'Thanh menu',
        'sidebar_key'       => 'thanh menu',
        'sidebar_sub'       => [
            'default'   => 'Mặc định',
            'collapsed' => 'Đã thu gọn',
        ],
        'sidebar_style'     => 'Loại thanh menu',
        'sidebar_style_key' => 'loại thanh menu',
        'sidebar_style_sub' => [
            'full'      => 'Đầy đủ',
            'dropdown'  => 'Thả xuống',
        ],
        'per_page'          => 'Số hàng trên một trang',
        'per_page_key'      => 'số hàng trên một trang',
        'default_locale'    => 'Ngày & giờ theo vị trí',
        'default_locale_key'=> 'ngày & giờ theo vị trí',
        'fraction'          => 'Phân số thập phân',
        'fraction_key'      => 'phân số thập phân',
        'name'              => 'tên trang web',
    ]
];

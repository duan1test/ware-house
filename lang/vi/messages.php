<?php

return [
    'alert' => [
        'success' => 'Thành công',
        'error' => 'Thất bại',
    ],
    'import' => [
        'success' => ':added hàng được thêm và :updated hàng được cập nhật thành công',
        'error' => 'Nhập dữ liệu thất bại',
    ],
    'create' => [
        'success' => 'Tạo mới thành công',
        'error' => 'Tạo mới thất bại',
    ],
    'update' => [
        'success' => 'Cập nhật thành công',
        'error' => 'Cập nhật thất bại',
    ],
    'soft_delete' => [
        'success' => 'Xóa thành công',
        'error' => 'Xóa thất bại',
        'exception' => 'Không thể xóa thực thể đang sử dụng'
    ],
    'permanent_delete' => [
        'success' => 'Xóa vĩnh viễn thành công',
        'error' => 'Xóa vĩnh viễn thất bại',
    ],
    'restore' => [
        'success' => 'Khôi phục thành công',
        'error' => 'Khôi phục thất bại',
    ],
    'role' => [
        'no_modified' => 'Không thể thay đổi quyền Super Admin'
    ],
    'transfer' => [
        'quantity' => '{name} không có {quantity} trong kho, số lượng có sẵn {available}',
        'variant' => '{name} ({variant}) không có {quantity} trong kho, số lượng có sẵn {available}',
    ],
    'contact'=> [
        'delete_success'=> 'Liên hệ này đã bị xóa',
    ],
    'unit' => [
        'code' => [
            'required' => 'Trường mã đơn vị bắt buộc.',
            'max_20' => 'Mã đơn vị không được lớn hơn 20 ký tự.',
            'unique' => 'Mã đơn vị đã được sử dụng.',
        ]
    ],
    'settings' => [
        'locale_length' => 'Độ dài ngôn ngữ phải là 2 hoặc 5 ký tự, ví dụ: en hoặc en-US.',
    ],
];
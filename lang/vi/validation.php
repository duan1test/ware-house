<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Các thông báo lỗi xác thực
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau chứa các thông báo lỗi mặc định được sử dụng bởi
    | lớp xác thực. Một số quy tắc có nhiều phiên bản khác nhau như các quy tắc kích thước.
    | Bạn có thể điều chỉnh các thông báo này ở đây.
    |
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'accepted_if' => ':attribute phải được chấp nhận khi :other là :value.',
    'active_url' => ':attribute phải là một URL hợp lệ.',
    'after' => ':attribute phải là một ngày sau :date.',
    'after_or_equal' => ':attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ được chứa các ký tự chữ cái.',
    'alpha_dash' => ':attribute chỉ được chứa các ký tự chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ được chứa các ký tự chữ cái và số.',
    'array' => ':attribute phải là một mảng.',
    'ascii' => ':attribute chỉ được chứa các ký tự và ký hiệu đơn byte.',
    'before' => ':attribute phải là một ngày trước :date.',
    'before_or_equal' => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'array' => ':attribute phải có từ :min đến :max mục.',
        'file' => ':attribute phải từ :min đến :max kilobytes.',
        'numeric' => ':attribute phải từ :min đến :max.',
        'string' => ':attribute phải từ :min đến :max ký tự.',
    ],
    'boolean' => ':attribute phải là true hoặc false.',
    'can' => ':attribute chứa một giá trị không được phép.',
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'current_password' => 'Mật khẩu không chính xác.',
    'date' => ':attribute phải là một ngày hợp lệ.',
    'date_equals' => ':attribute phải là một ngày bằng :date.',
    'date_format' => ':attribute phải khớp với định dạng :format.',
    'decimal' => ':attribute phải có :decimal chữ số thập phân.',
    'declined' => ':attribute phải bị từ chối.',
    'declined_if' => ':attribute phải bị từ chối khi :other là :value.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải có :digits chữ số.',
    'digits_between' => ':attribute bao gồm :min-:max chữ số.',
    'dimensions' => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => ':attribute có một giá trị trùng lặp.',
    'doesnt_end_with' => ':attribute không được kết thúc bằng một trong những: :values.',
    'doesnt_start_with' => ':attribute không được bắt đầu bằng một trong những: :values.',
    'email' => ':attribute không hợp lệ.',
    'ends_with' => ':attribute phải kết thúc bằng một trong những: :values.',
    'enum' => 'Giá trị được chọn cho :attribute không hợp lệ.',
    'exists' => 'Giá trị được chọn cho :attribute không hợp lệ.',
    'extensions' => ':attribute phải có một trong những phần mở rộng: :values.',
    'file' => ':attribute phải là một tệp.',
    'filled' => ':attribute phải có một giá trị.',
    'gt' => [
        'array' => ':attribute phải có nhiều hơn :value mục.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'numeric' => ':attribute phải lớn hơn :value.',
        'string' => ':attribute phải nhiều hơn :value ký tự.',
    ],
    'gte' => [
        'array' => ':attribute phải có :value mục hoặc nhiều hơn.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'string' => ':attribute phải nhiều hơn hoặc bằng :value ký tự.',
    ],
    'hex_color' => ':attribute phải là một màu hex hợp lệ.',
    'image' => ':attribute phải là một hình ảnh.',
    'in' => 'Giá trị được chọn cho :attribute không hợp lệ.',
    'in_array' => ':attribute phải tồn tại trong :other.',
    'integer' => ':attribute phải là một số nguyên.',
    'ip' => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là một chuỗi JSON hợp lệ.',
    'lowercase' => ':attribute phải viết thường.',
    'lt' => [
        'array' => ':attribute phải có ít hơn :value mục.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'string' => ':attribute phải ít hơn :value ký tự.',
    ],
    'lte' => [
        'array' => ':attribute không được có nhiều hơn :value mục.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'string' => ':attribute phải ít hơn hoặc bằng :value ký tự.',
    ],
    'mac_address' => ':attribute phải là một địa chỉ MAC hợp lệ.',
    'max' => [
        'array' => ':attribute không được có nhiều hơn :max mục.',
        'file' => ':attribute không được vượt quá :max kilobytes.',
        'numeric' => ':attribute không được lớn hơn :max.',
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
    ],
    'max_digits' => ':attribute không được có nhiều hơn :max chữ số.',
    'mimes' => ':attribute phải có định dạng: :values.',
    'mimetypes' => ':attribute phải là một tệp loại: :values.',
    'min' => [
        'array' => ':attribute phải có ít nhất :min mục.',
        'file' => ':attribute phải ít nhất :min kilobytes.',
        'numeric' => ':attribute phải ít nhất :min.',
        'string' => ':attribute phải ít nhất :min ký tự.',
    ],
    'min_digits' => ':attribute phải có ít nhất :min chữ số.',
    'missing' => ':attribute phải bị thiếu.',
    'missing_if' => ':attribute phải bị thiếu khi :other là :value.',
    'missing_unless' => ':attribute phải bị thiếu trừ khi :other là :value.',
    'missing_with' => ':attribute phải bị thiếu khi :values có mặt.',
    'missing_with_all' => ':attribute phải bị thiếu khi :values có mặt.',
    'multiple_of' => ':attribute phải là bội số của :value.',
    'not_in' => 'Giá trị được chọn cho :attribute không hợp lệ.',
    'not_regex' => 'Định dạng của :attribute không hợp lệ.',
    'numeric' => ':attribute phải là một số.',
    'password' => [
        'letters' => ':attribute phải chứa ít nhất một chữ cái.',
        'mixed' => ':attribute phải chứa ít nhất một chữ cái viết hoa và một chữ cái viết thường.',
        'numbers' => ':attribute phải chứa ít nhất một số.',
        'symbols' => ':attribute phải chứa ít nhất một ký hiệu.',
        'uncompromised' => ':attribute đã xuất hiện trong một rò rỉ dữ liệu. Vui lòng chọn một :attribute khác.',
    ],
    'present' => ':attribute phải có mặt.',
    'present_if' => ':attribute phải có mặt khi :other là :value.',
    'present_unless' => ':attribute phải có mặt trừ khi :other là :value.',
    'present_with' => ':attribute phải có mặt khi :values có mặt.',
    'present_with_all' => ':attribute phải có mặt khi :values có mặt.',
    'prohibited' => ':attribute bị cấm.',
    'prohibited_if' => ':attribute bị cấm khi :other là :value.',
    'prohibited_unless' => ':attribute bị cấm trừ khi :other có trong :values.',
    'prohibits' => ':attribute cấm :other có mặt.',
    'regex' => 'Định dạng của :attribute không hợp lệ.',
    'required' => 'Trường :attribute bắt buộc.',
    'required_array_keys' => ':attribute phải chứa các mục cho: :values.',
    'required_if' => 'Trường :attribute là bắt buộc.',
    'required_if_accepted' => ':attribute là bắt buộc khi :other được chấp nhận.',
    'required_unless' => ':attribute là bắt buộc trừ khi :other có trong :values.',
    'required_with' => 'Trường :attribute là bắt buộc.',
    'required_with_all' => ':attribute là bắt buộc khi :values có mặt.',
    'required_without' => 'Trường :attribute bắt buộc.',
    'required_without_all' => ':attribute là bắt buộc khi không có :values nào có mặt.',
    'same' => ':attribute phải khớp với :other.',
    'size' => [
        'array' => ':attribute phải chứa :size mục.',
        'file' => ':attribute phải là :size kilobytes.',
        'numeric' => ':attribute phải là :size.',
        'string' => 'Trường :attribute phải là :size ký tự.',
    ],
    'starts_with' => ':attribute phải bắt đầu bằng một trong những: :values.',
    'string' => ':attribute phải là một chuỗi.',
    'timezone' => ':attribute phải là một múi giờ hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'uploaded' => ':attribute không thể tải lên.',
    'uppercase' => ':attribute phải viết hoa.',
    'url' => ':attribute phải là một URL hợp lệ.',
    'ulid' => ':attribute phải là một ULID hợp lệ.',
    'uuid' => ':attribute phải là một UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Các thông báo lỗi xác thực tùy chỉnh
    |--------------------------------------------------------------------------
    |
    | Tại đây bạn có thể chỉ định các thông báo lỗi tùy chỉnh cho các thuộc tính
    | bằng cách sử dụng quy tắc "attribute.rule" để đặt tên cho các dòng. Điều này giúp bạn
    | dễ dàng chỉ định một thông báo ngôn ngữ cụ thể cho một quy tắc thuộc tính nhất định.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Các thuộc tính xác thực tùy chỉnh
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau đây được sử dụng để thay thế các trình giữ chỗ thuộc tính
    | bằng những cái tên dễ đọc hơn như "Địa chỉ E-Mail" thay vì "email". Điều này giúp chúng tôi làm cho
    | thông điệp của chúng tôi trở nên rõ ràng hơn.
    |
    */

    'attributes' => [
        'name' => 'Tên',
        'excel' => 'File excel'
    ],

];

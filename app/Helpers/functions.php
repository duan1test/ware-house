<?php

if (!function_exists('getAccountId')) {
    function getAccountId($account_id = null)
    {
        return session('account_id', $account_id ?? optional(auth()->user())->account_id);
    }
}

function getDefaultWarehouseImage() {
    return asset('assets/images/icons/defautl-img.png');
}

function formatNumber(float|int $number) {
    $fraction = get_settings('fraction') ?? 2;
    return number_format($number, $fraction, '.', ',');
}

if (!function_exists('uuid1')) {
    function uuid1()
    {
        $nodeProvider = new \Ramsey\Uuid\Provider\Node\RandomNodeProvider();
        return \Ramsey\Uuid\Uuid::uuid1($nodeProvider->getNode());
    }
}

if (!function_exists('get_settings')) {
    function get_settings($key = null)
    {
        if ($key) {
            return optional(\App\Models\Setting::where('tec_key', $key)->first())->tec_value;
        }
        return \App\Models\Setting::all()->pluck('tec_value', 'tec_key')->merge(['baseUrl' => url('/')]);
    }
}

if (!function_exists('convert_to_base_quantity')) {
    function convert_to_base_quantity($quantity, $unit)
    {
        $base_quantity = $quantity;
        if ($unit && $unit->operator) {
            switch ($unit->operator) {
                case '*':
                    $base_quantity = $quantity * $unit->operation_value;
                    break;
                case '/':
                    $base_quantity = $quantity / $unit->operation_value;
                    break;
                case '+':
                    $base_quantity = $quantity + $unit->operation_value;
                    break;
                case '-':
                    $base_quantity = $quantity - $unit->operation_value;
                    break;
                default:
                    $base_quantity = $quantity;
            }
        }
        return $base_quantity;
    }
}

// Json translation with choice replace
if (!function_exists('__choice')) {
    function __choice($key, array $replace = [], $number = null)
    {
        return trans_choice($key, $number, $replace);
    }
}

if (!function_exists('uuid4')) {
    function uuid4()
    {
        return \Ramsey\Uuid\Uuid::uuid4();
    }
}

if (!function_exists('get_reference')) {
    function get_reference($model)
    {
        $format = get_settings('reference');

        return match ($format) {
            'ai'     => get_next_id($model),
            'ulid'   => ulid(),
            'uuid'   => uuid4(),
            'uniqid' => uniqid(),
            default  => ulid(),
        };
    }
}

if (!function_exists('get_next_id')) {
    function get_next_id($model)
    {
        return collect(\Illuminate\Support\Facades\DB::select("show table status like '{$model->getTable()}'"))->first()->Auto_increment;
    }
}

if (!function_exists('ulid')) {
    function ulid()
    {
        return (string) \Ulid\Ulid::generate(true);
    }
}

if(!function_exists('handleRoute')) {
    function handleRoute($route, $id = null, $options = [], $prv = false)
    {
        if(isset($options['prv'])){
            unset($options['prv']);
        }
        $options = array_merge(['prv' => $prv], $options);
        if(!is_null($id)) {
            $options = array_merge([$id], $options);
        }

        return route($route, $options);
    }

}

if(!function_exists(function: 'adjustmentType')) {
    function adjustmentType($type)
    {
        switch($type) {
            case "Damage": 
                return __('common.adjustment.damage');
            case "Addition":
                return __('common.adjustment.addition');
            case "Subtraction":
                return __('common.adjustment.subtraction');
        }
    }
}
<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Auth;

class ItemImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation
{
    use Importable;

    private $addedCount = 0;
    private $updatedCount = 0;
    private $errors = [];

    public function model(array $row)
    {
        $row = array_map(function($item) {
            if (is_null($item)) {
                return $item;
            }
            return preg_replace('/\s+/', ' ', trim($item));
        }, $row);

        $unit = Unit::where('code', $row['don_vi'])->first();
        $category = Category::where('code', $row['danh_muc'])->first();
        $item = Item::where('code', $row['ma'])->first();
        $symbologies = $this->getBarcode();
        $isCate = true;
        
        if ($item && !$this->isExistSku($row['sku'], $row['ma'])) {
            $item->update([
                'name'              => $row['ten'],
                'sku'               => $row['sku'],
                'symbology'         => in_array($row['ky_ma_vach'], array_keys($symbologies)) ? $symbologies[$row['ky_ma_vach']] : 'CODE128',
                'unit_id'           => $unit ? $unit->id : null,
                'category_id'       => $category ? $category->id : null,
                'details'           => $row['chi_tiet'],
                'has_serials'       => $row['ton_tai_se_ri'] === 'yes',
                'track_weight'      => $row['theo_doi_trong_luong'] === 'yes',
                'track_quantity'    => $row['theo_doi_so_luong'] === 'yes',
                'alert_quantity'    => $row['canh_bao'] ?? null,
                'has_variants'      => $row['ton_tai_bien_the'] === 'yes',
                'variants'          => $this->formatVariants($row['dac_diem']),
                'rack_location'     => $row['vi_tri_de_hang'],
            ]);
            $item->addVariations();
            $this->updatedCount++;
        }else if(!$item && !$this->isExistSku(sku: $row['sku'])) {
            $item = Item::create([
                'account_id'        => Auth::user()->id,
                'code'              => $row['ma'],
                'name'              => $row['ten'],
                'sku'               => $row['sku'],
                'symbology'         => in_array($row['ky_ma_vach'], array_keys($symbologies)) ? $symbologies[$row['ky_ma_vach']] : 'CODE128',
                'unit_id'           => $unit ? $unit->id : null,
                'category_id'       => $category ? $category->id : null,
                'details'           => $row['chi_tiet'],
                'has_serials'       => $row['ton_tai_se_ri'] === 'yes',
                'track_weight'      => $row['theo_doi_trong_luong'] === 'yes',
                'track_quantity'    => $row['theo_doi_so_luong'] === 'yes',
                'alert_quantity'    => $row['canh_bao'] ?? null,
                'has_variants'      => $row['ton_tai_bien_the'] === 'yes',
                'variants'          => $this->formatVariants($row['dac_diem']),
                'rack_location'     => $row['vi_tri_de_hang'],
            ]);
            $item->addVariations();
            $this->addedCount++;
        } else {
            $isCate = false;
            $this->errors[] = [
                ...$row,
                'error' => 'SKU đã tồn tại!'
            ];
        }

        if($isCate) {
            $item->categories()->sync(Category::whereIn('code', array_map('trim', explode(',', $row['danh_muc'])))->get()->pluck('id'));
            if ('yes' == $row['ton_tai_bien_the'] && $row['dac_diem']) {
                $item->addVariations();
            }
            if ($item->wasRecentlyCreated) {
                $item->setStock();
            }
        }
                
        return $item;
    }

    public function isExistSku($sku, $code = null)
    {
        if(is_null($sku)) {
            return false;
        }

        if(is_null($code)) {
            return Item::where('sku', '=' , $sku)->exists();
        }

        return Item::where([['code', '!=' , $code], ['sku', '=' , $sku]])->exists();
    }
    
    public function formatVariants($variants)
    {
        if (!$variants) {
            return [];
        }

        $result = [];
        $pairs = explode('|', $variants);
        foreach ($pairs as $pair) {
            list($name, $options) = explode('=', $pair);
            $result[] = [
                'name' => $name,
                'option' => explode(',', $options),
            ];
        }
        return $result;
    }

    public function getAddedCount()
    {
        return $this->addedCount;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }


    public function getErrors()
    {
        return $this->errors;
    }

    public function rules(): array
    {
        return [
            'ma'                    => 'required|max:255',
            'ten'                   => 'required|max:255',
            'don_vi'                => 'nullable|exists:units,code',
            'danh_muc'              => 'required|exists:categories,code',
            'sku'                   => 'nullable|max:255',
            'ky_ma_vach'            => 'nullable|max:255',
            'chi_tiet'              => 'nullable|string',
            'ton_tai_se_ri'         => 'nullable|in:yes,no',
            'theo_doi_trong_luong'  => 'nullable|in:yes,no',
            'theo_doi_so_luong'     => 'nullable|in:yes,no',
            'canh_bao'              => 'nullable|numeric',
            'ton_tai_bien_the'      => 'nullable|in:yes,no',
            'dac_diem'              => 'nullable|string',
            'vi_tri_de_hang'        => 'nullable|string|max:255',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $values = $failure->values();
            $errors = $failure->errors();
            $this->errors[] = [
                ...$values,
                'error' => implode(",", $errors)
            ];
        }
    }

    public function customValidationMessages()
    {
        return [
            'ma.required'               => 'Mã sản phẩm không được bỏ trống',
            'ma.max'                    => 'Mã sản phẩm không quá 255 ký tự.',
            'ten.required'              => 'Tên sản phẩm không được bỏ trống',
            'ten.max'                   => 'Tên sản phẩm không quá 255 ký tự.',
            'don_vi.exists'             => 'Mã đơn vị không hợp lệ.',
            'danh_muc.required'         => 'Thể loại không được bỏ trống',
            'danh_muc.exists'           => 'Thể loại không hợp lệ.',
            'sku.max'                   => 'SKU tối đa 255 ký tự.',
            'ky_ma_vach.max'            => 'Mã vạch không quá 255 ký tự.',
            'chi_tiet.string'           => 'Chi tiết phải là chuỗi.',
            'ton_tai_se_ri.in'          => 'Tồn tại sê-ri phải là yes or no.',
            'theo_doi_trong_luong.in'   => 'Theo dõi trọng lượng phải là yes or no.',
            'theo_doi_so_luong.in'      => 'Theo dõi số lượng phải là yes or no.',
            'canh_bao.integer'          => 'Số lượng phải là số.',
            'ton_tai_bien_the.in'       => 'Tồn tại biến thể phải là yes or no.',
            'dac_diem.string'           => 'Biến thể phải là chuỗi.',
            'vi_tri_de_hang.max'        => 'Vị trí hàng không quá 255 ký tự.',
        ];
    }
    
    public function getBarcode()
    {
        return [
            'CODE128'   => 'CODE128',
            'CODE39'    => 'CODE39',
            'EAN-5'     => 'EAN5',
            'EAN-8'     => 'EAN8',
            'EAN-13'    => 'EAN13',
            'UPC-A'     => 'UPC',
        ];
    }
}

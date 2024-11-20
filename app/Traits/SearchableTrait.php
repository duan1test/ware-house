<?php

namespace App\Traits;

trait SearchableTrait
{
    /**
     * Search fields.
     *
     * @return array
     */
    public static function searchFields()
    {
        return [
            'id',
            'sku'
        ];
    }

    /**
     * Handle search.
     */
    public static function search(null|string $value)
    {
        $query = get_called_class()::query();

        if (empty($value)) {
            return $query;
        }

        $fields = static::searchFields();

        return $query->where(function ($query) use ($fields, $value) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', "%{$value}%");
            } 
        });
    }
}

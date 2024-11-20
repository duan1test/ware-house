<?php

namespace App\Traits;

trait ScopeFilterTrashTrait
{
    protected $withTrash    = 'with';
    protected $onlyTrash    = 'only';
    protected $withoutTrash = 'without';
    /**
     * Apply filters to the query.
     *
     * @param Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @param string $type only, with, not.
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterTrash($query, string $type = 'without')
    {
        $type = strtolower($type);

        switch ($type) {
            case $this->onlyTrash:
                $query->onlyTrashed();
                break;
            case $this->withTrash:
                $query->withTrashed();
                break;
        }

        return $query;
    }

    /**
     * Returns an array of trashed filters with their corresponding labels.
     *
     * @param string $labelOnly The label for the 'only' filter. Defaults to the translation of 'common.only_trashed'.
     * @param string $labelWith The label for the 'with' filter. Defaults to the translation of 'common.with_trashed'.
     * @param string $labelNot The label for the 'not' filter. Defaults to the translation of 'common.not_trashed'.
     * @return array An associative array with the keys 'only', 'with', and 'not', and their corresponding labels.
     */
    public function scopeTrashFilters($query, array $array = []) : array
    {
        return [
            $this->withTrash    => $array['labelWith'] ?? __('common.with_trashed'),
            $this->onlyTrash    => $array['labelOnly'] ?? __('common.only_trashed'),
            $this->withoutTrash => $array['labelNot'] ?? __('common.not_trashed'),
        ];
    }
}

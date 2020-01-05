<?php
/**
 * Created by PhpStorm.
 * User: slavka
 * Date: 09.10.17
 * Time: 11:57
 */

namespace App\Scopes;

use App\Helpers\DataCacheHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PhoneLimitScope implements Scope
{
    public function __construct(string $field = 'id')
    {
        $this->field = $field;
    }

    public function apply(Builder $builder, Model $model)
    {
        $lastId = DataCacheHelper::lastShownPhoneId();
        if (!empty($lastId)) {
            $builder->where($this->field, '<', $lastId);
        }
    }
}
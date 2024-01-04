<?php

namespace LaravelBulkProcess\Trait;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Contracts\Support\Arrayable;

/**
 * BulkProcessで使用できる静的メソッドを管理する
 * 
 * @package LaravelBulkProcess\Trait
 * 
 * @method \Illuminate\Support\Collection data()
 * @method int limit()
 */
trait StaticMethod
{
    /**
     * dataを一括挿入する
     * 
     * @param array|Collection|EloquentCollection|Arrayable $data
     * @param bool $isTruncate
     * @return void
     */
    public static function insert(array|Collection|EloquentCollection|Arrayable $data, bool $isTruncate = false): void
    {
        // BulkProcessのインスタンスを生成する
        $instance = new static($data);

        // dataを一括挿入する
        $instance->bulkInsert($isTruncate);
    }

    /**
     * uniqueByのカラムを基に、存在する場合は更新、存在しない場合は挿入する
     * 
     * @param array|Collection|EloquentCollection|Arrayable $data
     * @param array|string $uniqueBy
     * @return void
     */

    public static function upsert(array|Collection|EloquentCollection|Arrayable $data, array|string $uniqueBy): void
    {
        // BulkProcessのインスタンスを生成する
        $instance = new static($data);

        // dataを一括挿入する
        $instance->bulkUpsert($uniqueBy);
    }
}

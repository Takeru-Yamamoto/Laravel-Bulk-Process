<?php

namespace LaravelBulkProcess\Trait;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * BulkProcessで使用する一括処理を管理する
 * 
 * @package LaravelBulkProcess\Trait
 * 
 * @method \Illuminate\Database\Eloquent\Model model()
 * @method \Illuminate\Support\Collection data()
 * @method int limit()
 */
trait BulkProcess
{
    /**
     * 一括処理を行うテーブルに紐づいたQueryBuilderを取得する
     * 
     * @return Builder
     */
    public function queryBuilder(): Builder
    {
        return DB::table($this->model()->getTable());
    }

    /**
     * 一括処理を行うテーブルをTruncateする
     * 
     * @return static
     */
    public function truncateTable(): static
    {
        $this->queryBuilder()->truncate();

        return $this;
    }

    /**
     * dataの一括処理を行う
     * 
     * @param \Closure $callback
     * @return static
     */
    public function bulkProcess(\Closure $callback): static
    {
        // dataを一括処理する
        $this->data()->chunk($this->limit())->each(function (Collection $chunk) use ($callback) {
            $callback($chunk);
        });

        return $this;
    }

    /**
     * dataを一括挿入する
     * 
     * @param bool $isTruncate
     * @return static
     */
    public function bulkInsert(bool $isTruncate = false): static
    {
        // テーブルをTruncateする
        if ($isTruncate) $this->truncateTable();

        // dataを一括挿入する
        $this->bulkProcess(function (Collection $chunk) {
            $this->queryBuilder()->insert($chunk->toArray());
        });

        return $this;
    }
    
    /**
     * uniqueByのカラムを基に、存在する場合は更新、存在しない場合は挿入する
     * 
     * @param array|string $uniqueBy
     * @return static
     */
    public function bulkUpsert(array|string $uniqueBy): static
    {
        // dataをUpsertする
        $this->bulkProcess(function (Collection $chunk) use ($uniqueBy) {
            $this->queryBuilder()->upsert($chunk->toArray(), $uniqueBy);
        });

        return $this;
    }
}

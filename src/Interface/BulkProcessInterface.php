<?php

namespace LaravelBulkProcess\Interface;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * BulkProcessのInterface
 * 
 * @package LaravelBulkProcess\Interface
 */
interface BulkProcessInterface
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * 一括処理に使用するデータ
     *
     * @return Collection
     */
    public function data(): Collection;

    /**
     * 一括処理に使用するデータの配列
     * 
     * @return array
     */
    public function dataArray(): array;

    /**
     * 一括処理に使用するデータの件数
     * 
     * @return int
     */
    public function dataCount(): int;

    /**
     * バリデーションに失敗したデータ
     *
     * @return Collection
     */
    public function failureData(): Collection;

    /**
     * バリデーションに失敗したデータの配列
     * 
     * @return array
     */
    public function failureDataArray(): array;

    /**
     * バリデーションに失敗したデータの件数
     * 
     * @return int
     */
    public function failureDataCount(): int;



    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * 一括処理を行う件数の閾値
     *
     * @return int
     */
    public function limit(): int;

    /**
     * 一括処理を行う件数の閾値を設定する
     * 
     * @param int $limit
     * @return static
     */
    public function setLimit(int $limit): static;

    /**
     * 一括処理を行うテーブルに紐づいたModelのClass名
     *
     * @return string
     */
    public function modelClass(): string;

    /**
     * 一括処理を行うテーブルに紐づいたModelのClass名を設定する
     * 
     * @param string $modelClass
     * @return static
     */
    public function setModelClass(string $modelClass): static;

    /**
     * 一括処理を行うテーブルに紐づいたModelのインスタンスを生成する
     *
     * @return Model
     */
    public function model(): Model;

    /**
     * 一括処理を行うテーブルに紐づいたModelのクラス名をインスタンスから設定する
     * 
     * @param Model $model
     * @return static
     */
    public function setModel(Model $model): static;



    /*----------------------------------------*
     * Bulk Process
     *----------------------------------------*/

    /**
     * 一括処理を行うテーブルに紐づいたQueryBuilderを取得する
     * 
     * @return Builder
     */
    public function queryBuilder(): Builder;

    /**
     * 一括処理を行うテーブルをTruncateする
     * 
     * @return static
     */
    public function truncateTable(): static;

    /**
     * dataの一括処理を行う
     * 
     * @param \Closure $callback
     * @return static
     */
    public function bulkProcess(\Closure $callback): static;

    /**
     * dataを一括挿入する
     * 
     * @param bool $isTruncate
     * @return static
     */
    public function bulkInsert(bool $isTruncate = false): static;

    /**
     * uniqueByのカラムを基に、存在する場合は更新、存在しない場合は挿入する
     * 
     * @param array|string $uniqueBy
     * @return static
     */
    public function bulkUpsert(array|string $uniqueBy): static;



    /*----------------------------------------*
     * Static Method
     *----------------------------------------*/

    /**
     * dataを一括挿入する
     * 
     * @param array|Collection|EloquentCollection|Arrayable $data
     * @param bool $isTruncate
     * @return void
     */
    public static function insert(array|Collection|EloquentCollection|Arrayable $data, bool $isTruncate = false): void;

    /**
     * uniqueByのカラムを基に、存在する場合は更新、存在しない場合は挿入する
     * 
     * @param array|Collection|EloquentCollection|Arrayable $data
     * @param array|string $uniqueBy
     * @return void
     */

    public static function upsert(array|Collection|EloquentCollection|Arrayable $data, array|string $uniqueBy): void;
}

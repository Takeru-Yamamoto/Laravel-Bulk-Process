<?php

namespace LaravelBulkProcess\Trait;

use Illuminate\Database\Eloquent\Model;

/**
 * BulkProcessのプロパティを管理する
 * 
 * @package LaravelBulkProcess\Trait
 */
trait Property
{
    /**
     * 一括処理を行う件数の閾値
     * 
     * @var int
     */
    protected int $limit = 1000;

    /**
     * 一括処理を行うテーブルに紐づいたModelのClass名
     * 
     * @var string
     */
    protected string $modelClass;


    /**
     * 一括処理を行う件数の閾値
     *
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * 一括処理を行う件数の閾値を設定する
     * 
     * @param int $limit
     * @return static
     */
    public function setLimit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * 一括処理を行うテーブルに紐づいたModelのClass名
     *
     * @return string
     */
    public function modelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * 一括処理を行うテーブルに紐づいたModelのClass名を設定する
     * 
     * @param string $modelClass
     * @return static
     */
    public function setModelClass(string $modelClass): static
    {
        $this->modelClass = $modelClass;

        return $this;
    }

    /**
     * 一括処理を行うテーブルに紐づいたModelのインスタンスを生成する
     *
     * @return Model
     */
    public function model(): Model
    {
        return new $this->modelClass;
    }

    /**
     * 一括処理を行うテーブルに紐づいたModelのクラス名をインスタンスから設定する
     * 
     * @param Model $model
     * @return static
     */
    public function setModel(Model $model): static
    {
        $this->modelClass = get_class($model);

        return $this;
    }
}

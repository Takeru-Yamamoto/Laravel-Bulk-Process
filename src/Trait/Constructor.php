<?php

namespace LaravelBulkProcess\Trait;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Contracts\Support\Arrayable;

/**
 * BulkProcessのコンストラクタを管理する
 * 
 * @package LaravelBulkProcess\Trait
 */
trait Constructor
{
    /**
     * 一括処理に使用するデータ
     *
     * @var Collection
     */
    protected Collection $data;

    /**
     * バリデーションに失敗したデータ
     * 
     * @var Collection
     */
    protected Collection $failureData;


    /**
     * BulkProcessのコンストラクタ
     *
     * @param array|Collection|EloquentCollection|Arrayable $data
     * @throws \InvalidArgumentException
     */
    function __construct(array|Collection|EloquentCollection|Arrayable $data)
    {
        // dataをCollectionに統一する
        $collection = match (true) {
            is_array($data)                     => collect($data),
            $data instanceof EloquentCollection => $data->toBase(),
            $data instanceof Collection         => $data,
            $data instanceof Arrayable          => collect($data->toArray()),

            default => null,
        };

        // collectionがCollectionでない場合は例外をthrowする
        if (!$collection instanceof Collection) throw new \InvalidArgumentException("Invalid data type: " . gettype($data));

        // dataが空の場合は例外をthrowする
        if ($collection->isEmpty()) throw new \InvalidArgumentException("data must not be empty");

        // dataのバリデーションを行い、失敗したデータをfailureDataに格納する
        $this->failureData = $collection->reject(function ($item) {
            return !$this->validate($item);
        });

        // collectionからfailureDataを除外する
        $collection = $collection->diff($this->failureData);

        // collectionが空の場合は例外をthrowする
        if ($collection->isEmpty()) throw new \InvalidArgumentException("data must not be empty");

        // dataの成型処理を行う
        $formatted = $collection->map(function ($item) {
            return $this->format($item);
        });

        // formattedをdataに格納する
        $this->data = $formatted;
    }

    /**
     * dataのバリデーションを行う
     * 
     * @param mixed $item
     * @return bool
     */
    abstract protected function validate(mixed $item): bool;

    /**
     * dataの成型処理を行う
     * 
     * @param mixed $item
     * @return array
     */
    abstract protected function format(mixed $item): array;


    /**
     * 一括処理に使用するデータ
     *
     * @return Collection
     */
    public function data(): Collection
    {
        return $this->data;
    }

    /**
     * 一括処理に使用するデータの配列
     * 
     * @return array
     */
    public function dataArray(): array
    {
        return $this->data->toArray();
    }

    /**
     * 一括処理に使用するデータの件数
     * 
     * @return int
     */
    public function dataCount(): int
    {
        return $this->data->count();
    }

    /**
     * バリデーションに失敗したデータ
     *
     * @return Collection
     */
    public function failureData(): Collection
    {
        return $this->failureData;
    }

    /**
     * バリデーションに失敗したデータの配列
     * 
     * @return array
     */
    public function failureDataArray(): array
    {
        return $this->failureData->toArray();
    }

    /**
     * バリデーションに失敗したデータの件数
     * 
     * @return int
     */
    public function failureDataCount(): int
    {
        return $this->failureData->count();
    }
}

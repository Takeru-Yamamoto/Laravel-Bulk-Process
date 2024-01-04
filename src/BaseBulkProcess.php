<?php

namespace LaravelBulkProcess;

use LaravelBulkProcess\Interface\BulkProcessInterface;

use LaravelBulkProcess\Trait\Constructor;
use LaravelBulkProcess\Trait\Property;
use LaravelBulkProcess\Trait\BulkProcess;
use LaravelBulkProcess\Trait\StaticMethod;

/**
 * 一括処理機能を持つ基底クラス
 * 
 * @package LaravelBulkProcess
 */
abstract class BaseBulkProcess implements BulkProcessInterface
{
    use Constructor;
    use Property;
    use BulkProcess;
    use StaticMethod;
}

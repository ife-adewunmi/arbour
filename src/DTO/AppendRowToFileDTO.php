<?php

declare(strict_types=1);

namespace Arbour\DTO;

use Spatie\LaravelData\Data;

class AppendRowToFileDTO extends Data
{
    public function __construct(
        public string $appendRow,
        public string $destinationFilePath,
        public string $beforeAppendRow = '[',
        public string $AfterAppendRow = '];',
    ) {
    }
}

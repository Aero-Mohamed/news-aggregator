<?php

namespace App\Services\User\DTOs;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Symfony\Component\Console\Attribute\Option;

class UserPreferenceData extends Data
{
    /**
     * @param array|null $source_ids
     * @param array|null $category_ids
     * @param array|null $author_ids
     */
    public function __construct(
        public ?array $source_ids = [],
        public ?array $category_ids = [],
        public ?array $author_ids = []
    ) {
    }


    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'source_ids' => ['array', 'required_without_all:category_ids,author_ids'],
            'category_ids' => ['array'],
            'author_ids' => ['array'],

            'source_ids.*' => ['uuid', 'exists:sources,id'],
            'category_ids.*' => ['uuid', 'exists:categories,id'],
            'author_ids.*' => ['uuid', 'exists:authors,id'],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'required_without_all' => 'Please select at least one source, category, or author.',
        ];
    }
}

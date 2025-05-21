<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function getCategories(): Collection
    {
        return $this->categoryRepository->getCategories();
    }
}

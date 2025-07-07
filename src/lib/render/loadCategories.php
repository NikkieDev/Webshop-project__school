<?php

declare(strict_types=1);

require_once __DIR__ ."/../repository/CategoryRepository.php";

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->getCategories();

<?php

function buildQuestions(string $language): array
{
    $config = require __DIR__ . '/assessment-questions.php';

    if (!isset($config[$language])) {
        throw new Exception("Unsupported language: $language");
    }

    $questions = [];
    $id = 1;

    $langConfig = $config[$language];

    foreach ($langConfig['categories'] as $category => $count) {
        for ($i = 1; $i <= $count; $i++) {
            $questions[] = [
                'id' => $id++,
                'text' => strtolower($langConfig['textPrefix'])
                    . '.'
                    . strtolower($category)
                    . '.q' . $i,
                'category' => $category
            ];
        }
    }

    return $questions;
}

<?php

function containsBannedWords(array $inputs, array $bannedWords): bool
{
    foreach ($inputs as $value) {

        if (!is_string($value)) {
            continue;
        }

        foreach ($bannedWords as $word) {

            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';

            if (preg_match($pattern, $value)) {
                return true;
            }
        }
    }

    return false;
}
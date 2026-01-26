<?php

function containsBannedWords(array $inputs, array $bannedWords): bool
{
    foreach ($inputs as $field => $value) {
        foreach ($bannedWords as $word) {
            if (stripos($value, $word) !== false) { // case-insensitive
                return true;
            }
        }
    }
    return false;
}
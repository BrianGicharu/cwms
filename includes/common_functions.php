<?php

// Generate a random ID With a prefix an a blankspace default
function randId(?string $pre=""):string{
    return $pre.rand(100000,999999);
}
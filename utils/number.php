<?php
function formatAsCurrency($value) {
    return number_format($value, 0, ",", ".");
}
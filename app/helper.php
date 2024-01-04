<?php 
function formatCurrency($value) {
    if(!$value) return '$0.00';
    return '$' . number_format($value, 2, '.', ',');
}
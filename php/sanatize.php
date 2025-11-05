<?php

function sanitizeString(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
  * Returns a copy of an assoc array with sanitized values. Good for the $_POST variable.
  */
function sanitizeAssocArray(array $items): array {
    foreach($items as $key => $value) {
        $items[$key] = $value;
    }
    return $items;
}
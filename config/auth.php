<?php
// Password helpers: hashes with password_hash() and verifies with password_verify().
// Accounts created before hashing was added still have plain-text passwords; they are
// accepted once and upgraded to a hash on that same login.

function maka_hash_password(string $plain): string {
    return password_hash($plain, PASSWORD_DEFAULT);
}

function maka_verify_password(PDO $pdo, int $userId, string $plain, string $stored): bool {
    if (!empty(password_get_info($stored)['algo'])) {
        return password_verify($plain, $stored);
    }
    if (!hash_equals($stored, $plain)) {
        return false;
    }
    $stmt = $pdo->prepare("UPDATE usuario SET contrasena = ? WHERE id = ?");
    $stmt->execute([maka_hash_password($plain), $userId]);
    return true;
}

<?php
require_once 'db.php';
require_once 'register.php';

// API endpoint to get wallet details by WalletID
function getWalletDetails($walletId, $conn) {
    $stmt = $conn->prepare("SELECT * FROM Wallet WHERE wallet_id = $walletId");
    $stmt->bind_param("i", $walletId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Return null if wallet not found
    }
}

// API endpoint to update wallet balance by WalletID
function updateWalletBalance($walletId, $newBalance, $conn) {
    if (!is_numeric($newBalance)) {
        throw new InvalidArgumentException("New balance must be a valid number");
    }

    $sql = "UPDATE Wallet SET Balance = ? WHERE WalletID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $newBalance, $walletId);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

// API endpoint to get transaction history by WalletID
function getTransactionHistory($walletId, $conn) {
    $sql = "SELECT th.TransactionID, th.WalletID, th.TransactionDateTime, th.TransactionType, th.Amount 
            FROM TransactionHistory th 
            INNER JOIN Wallet w ON w.WalletID = th.WalletID
            WHERE w.WalletID = ?
            ORDER BY th.TransactionDateTime DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $walletId);
    $stmt->execute();
    $result = $stmt->get_result();

    $transactionHistory = array();
    while($row = $result->fetch_assoc()) {
        $transactionHistory[] = $row;
    }
    return $transactionHistory;
}

// Usage examples:
// Uncomment the following lines to test the API endpoints


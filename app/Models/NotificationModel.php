<?php

namespace App\Models;

class NotificationModel
{
    private $pdo;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($judul, $isi, $tipe = 'info', $referensi = null, $target = null)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notifikasi WHERE judul = ? AND isi = ? AND referensi = ? AND DATE(created_at) = CURDATE()");
        $stmt->execute([$judul, $isi, $referensi]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        $ins = $this->pdo->prepare("INSERT INTO notifikasi (judul, isi, tipe, referensi, target) VALUES (?, ?, ?, ?, ?)");
        return $ins->execute([$judul, $isi, $tipe, $referensi, $target]);
    }

    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM notifikasi ORDER BY dibaca ASC, created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLatest($limit = 10)
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM notifikasi
        ORDER BY dibaca ASC, created_at DESC
        LIMIT ?
    ");
        $stmt->bindValue(1, (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUnreadCount()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM notifikasi WHERE dibaca = 0");
        return (int)$stmt->fetchColumn();
    }

    public function markAsRead($id)
    {
        $stmt = $this->pdo->prepare("UPDATE notifikasi SET dibaca = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function markAllRead()
    {
        $stmt = $this->pdo->exec("UPDATE notifikasi SET dibaca = 1 WHERE dibaca = 0");
        return $stmt !== false;
    }
}

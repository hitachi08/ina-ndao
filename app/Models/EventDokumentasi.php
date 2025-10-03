<?php
class EventDokumentasi
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Tambah dokumentasi */
    public function add($id_event, $fileName)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO event_dokumentasi (id_event, gambar_dokumentasi) VALUES (?, ?)"
        );
        return $stmt->execute([$id_event, $fileName]);
    }

    /** Ambil semua dokumentasi untuk 1 event */
    public function fetchByEvent($id_event)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM event_dokumentasi WHERE id_event = ? ORDER BY uploaded_at DESC"
        );
        $stmt->execute([$id_event]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Hapus 1 dokumentasi */
    public function delete($id_dokumentasi)
    {
        $stmt = $this->pdo->prepare(
            "SELECT gambar_dokumentasi FROM event_dokumentasi WHERE id_dokumentasi=?"
        );
        $stmt->execute([$id_dokumentasi]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && file_exists(__DIR__ . "/../../public/img/event/" . $row['gambar_dokumentasi'])) {
            unlink(__DIR__ . "/../../public/img/event/" . $row['gambar_dokumentasi']);
        }

        $stmt = $this->pdo->prepare("DELETE FROM event_dokumentasi WHERE id_dokumentasi=?");
        return $stmt->execute([$id_dokumentasi]);
    }

    /** Hapus banyak dokumentasi di DB */
    public function deleteMultiple(array $ids)
    {
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare("DELETE FROM event_dokumentasi WHERE id_dokumentasi IN ($placeholders)");
        return $stmt->execute($ids);
    }

    /** Ambil data file dokumentasi berdasarkan ID */
    public function getFilesByIds(array $ids)
    {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare("SELECT gambar_dokumentasi FROM event_dokumentasi WHERE id_dokumentasi IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

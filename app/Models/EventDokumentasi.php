<?php
class EventDokumentasi
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

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

    public function deleteMultiple(array $ids)
    {
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare("DELETE FROM event_dokumentasi WHERE id_dokumentasi IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function getFilesByIds(array $ids)
    {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare("SELECT gambar_dokumentasi FROM event_dokumentasi WHERE id_dokumentasi IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEventId($eventId)
    {
        $sql = "SELECT * FROM event_dokumentasi WHERE id_event = :id_event";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_event' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

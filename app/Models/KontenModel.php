<?php
class KontenModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getByHalaman($halaman)
    {
        $stmt = $this->db->prepare("SELECT * FROM konten_halaman WHERE halaman = ?");
        $stmt->execute([$halaman]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateKonten($halaman, $konten)
    {
        $stmt = $this->db->prepare("UPDATE konten_halaman SET konten = ?, updated_at = NOW() WHERE halaman = ?");
        return $stmt->execute([$konten, $halaman]);
    }
}

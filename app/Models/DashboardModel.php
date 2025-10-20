<?php
class DashboardModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllStats()
    {
        return [
            'kain_total'      => $this->countTable('kain'),
            'produk_total'    => $this->countTable('produk'),
            'event_total'     => $this->countTable('event'),
            'event_upcoming'  => $this->countUpcomingEvents(),
            'event_past'      => $this->countPastEvents(),
            'team_total'      => $this->countTeamMembers()
        ];
    }

    private function countTable($table)
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM $table");
        return (int)$stmt->fetchColumn();
    }

    public function getUpcomingEvents($limit = 5)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function countUpcomingEvents()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM event WHERE tanggal >= CURDATE()");
        return (int)$stmt->fetchColumn();
    }

    private function countPastEvents()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM event WHERE tanggal < CURDATE()");
        return (int)$stmt->fetchColumn();
    }

    private function countTeamMembers()
    {
        $stmt = $this->pdo->prepare("SELECT konten FROM konten_halaman WHERE halaman = 'beranda_team' LIMIT 1");
        $stmt->execute();
        $data = $stmt->fetchColumn();

        if (!$data) return 0;

        $decoded = json_decode($data, true);
        if (isset($decoded['team']) && is_array($decoded['team'])) {
            return count($decoded['team']);
        }

        return 0;
    }

    public function getAllKain()
    {
        $sql = "SELECT 
            k.id_kain,
            jk.nama_jenis AS jenis_kain,
            d.nama_daerah AS daerah_asal,
            CONCAT(k.panjang_cm, ' x ', k.lebar_cm, ' cm') AS ukuran,
            k.harga,
            k.bahan,
            k.jenis_pewarna,
            k.stok,
            REPLACE(kg.path_gambar, '/uploads/motif/', '') AS path_gambar
        FROM kain k
        LEFT JOIN jenis_kain jk ON k.id_jenis_kain = jk.id_jenis_kain
        LEFT JOIN daerah d ON k.id_daerah = d.id_daerah
        LEFT JOIN kain_gambar kg ON kg.id_kain = k.id_kain
        GROUP BY k.id_kain
        ORDER BY k.id_kain DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php
class Galeri
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // ============================
    // Fetch semua variasi + relasi
    // ============================
    public function fetchAll()
    {
        $stmt = $this->pdo->query("
            SELECT v.id_variasi,
                   j.nama_jenis,
                   d.nama_daerah,
                   m.nama_motif,
                   m.cerita,
                   m.gambar,
                   v.ukuran, v.bahan, v.jenis_pewarna, v.harga, v.stok
            FROM variasi_motif v
            JOIN kain_motif km ON v.id_kain_motif = km.id_kain_motif
            JOIN motif m ON km.id_motif = m.id_motif
            JOIN kain k ON km.id_kain = k.id_kain
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchSingle($id_variasi)
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*, 
                   m.nama_motif, m.cerita, m.gambar,
                   j.id_jenis_kain, j.nama_jenis,
                   d.id_daerah, d.nama_daerah
            FROM variasi_motif v
            JOIN kain_motif km ON v.id_kain_motif = km.id_kain_motif
            JOIN motif m ON km.id_motif = m.id_motif
            JOIN kain k ON km.id_kain = k.id_kain
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            WHERE v.id_variasi = ?
        ");
        $stmt->execute([$id_variasi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================
    // Jenis kain & daerah helper
    // ============================
    public function getJenisByName($nama)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM jenis_kain WHERE nama_jenis = ?");
        $stmt->execute([$nama]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addJenisKain($nama)
    {
        $stmt = $this->pdo->prepare("INSERT INTO jenis_kain (nama_jenis) VALUES (?)");
        $stmt->execute([$nama]);
        return $this->pdo->lastInsertId();
    }

    public function getDaerahByName($nama)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM daerah WHERE nama_daerah = ?");
        $stmt->execute([$nama]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addDaerah($nama)
    {
        $stmt = $this->pdo->prepare("INSERT INTO daerah (nama_daerah) VALUES (?)");
        $stmt->execute([$nama]);
        return $this->pdo->lastInsertId();
    }

    public function getOrCreateKain($idJenis, $idDaerah)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kain WHERE id_jenis_kain=? AND id_daerah=?");
        $stmt->execute([$idJenis, $idDaerah]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row)
            return $row['id_kain'];

        $stmt = $this->pdo->prepare("INSERT INTO kain (id_jenis_kain, id_daerah) VALUES (?, ?)");
        $stmt->execute([$idJenis, $idDaerah]);
        return $this->pdo->lastInsertId();
    }

    // ============================
    // Motif & Variasi
    // ============================
    public function addMotif($data, $gambar = null)
    {
        // insert motif
        $stmt = $this->pdo->prepare("INSERT INTO motif (nama_motif, cerita, gambar) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['nama_motif'],
            $data['cerita'],
            $gambar
        ]);
        $idMotif = $this->pdo->lastInsertId();

        // buat relasi dengan kain
        $stmt = $this->pdo->prepare("INSERT INTO kain_motif (id_kain, id_motif) VALUES (?, ?)");
        $stmt->execute([$data['id_kain'], $idMotif]);
        return $this->pdo->lastInsertId(); // id_kain_motif
    }

    public function addVariasi($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO variasi_motif (id_kain_motif, ukuran, bahan, jenis_pewarna, harga, stok)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_kain_motif'],
            $data['ukuran'],
            $data['bahan'],
            $data['jenis_pewarna'],
            $data['harga'],
            $data['stok']
        ]);
    }

    public function updateVariasi($id_variasi, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE variasi_motif 
            SET ukuran=?, bahan=?, jenis_pewarna=?, harga=?, stok=? 
            WHERE id_variasi=?
        ");
        return $stmt->execute([
            $data['ukuran'],
            $data['bahan'],
            $data['jenis_pewarna'],
            $data['harga'],
            $data['stok'],
            $id_variasi
        ]);
    }

    public function deleteVariasi($id_variasi)
    {
        $stmt = $this->pdo->prepare("DELETE FROM variasi_motif WHERE id_variasi=?");
        return $stmt->execute([$id_variasi]);
    }
}

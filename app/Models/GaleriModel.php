<?php
class Galeri
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // ============================
    // FETCH DATA
    // ============================
    public function fetchAll()
    {
        $stmt = $this->pdo->query("
            SELECT v.id_variasi,
                   j.nama_jenis,
                   d.nama_daerah,
                   m.id_motif,
                   m.nama_motif,
                   m.cerita,
                   v.ukuran, 
                   v.bahan, 
                   v.jenis_pewarna, 
                   v.harga, 
                   v.stok,
                   GROUP_CONCAT(mg.gambar) AS motif_gambar
            FROM variasi_motif v
            JOIN kain_motif km ON v.id_kain_motif = km.id_kain_motif
            JOIN motif m ON km.id_motif = m.id_motif
            JOIN kain k ON km.id_kain = k.id_kain
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            LEFT JOIN motif_gambar mg ON m.id_motif = mg.id_motif
            GROUP BY v.id_variasi
        ");

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['motif_gambar'] = $row['motif_gambar'] ? explode(',', $row['motif_gambar']) : [];
        }

        return $result;
    }

    public function fetchSingle($idVariasi)
    {
        $stmt = $this->pdo->prepare("
            SELECT v.id_variasi,
                   j.nama_jenis,
                   d.nama_daerah,
                   m.id_motif,
                   m.nama_motif,
                   m.cerita,
                   v.ukuran, 
                   v.bahan, 
                   v.jenis_pewarna, 
                   v.harga, 
                   v.stok,
                   GROUP_CONCAT(mg.gambar) AS motif_gambar
            FROM variasi_motif v
            JOIN kain_motif km ON v.id_kain_motif = km.id_kain_motif
            JOIN motif m ON km.id_motif = m.id_motif
            JOIN kain k ON km.id_kain = k.id_kain
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            LEFT JOIN motif_gambar mg ON m.id_motif = mg.id_motif
            WHERE v.id_variasi = ?
            GROUP BY v.id_variasi
        ");
        $stmt->execute([$idVariasi]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row['motif_gambar'] = $row['motif_gambar'] ? explode(',', $row['motif_gambar']) : [];
        }
        return $row;
    }

    // ============================
    // JENIS KAIN & DAERAH HELPER
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
    // MOTIF
    // ============================
    public function getMotifByName($namaMotif)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM motif WHERE nama_motif = ?");
        $stmt->execute([$namaMotif]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addMotif($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO motif (nama_motif, cerita) VALUES (?, ?)");
        $stmt->execute([$data['nama_motif'], $data['cerita']]);
        return $this->pdo->lastInsertId();
    }

    public function updateMotif($idMotif, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE motif SET nama_motif=?, cerita=? WHERE id_motif=?");
        return $stmt->execute([$data['nama_motif'], $data['cerita'], $idMotif]);
    }

    public function deleteMotif($idMotif)
    {
        $stmt = $this->pdo->prepare("DELETE FROM motif WHERE id_motif=?");
        return $stmt->execute([$idMotif]);
    }

    // ============================
    // MOTIF GAMBAR
    // ============================
    public function addMotifGambar($idMotif, $gambar)
    {
        $stmt = $this->pdo->prepare("INSERT INTO motif_gambar (id_motif, gambar) VALUES (?, ?)");
        return $stmt->execute([$idMotif, $gambar]);
    }

    public function getMotifGambar($idMotif)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM motif_gambar WHERE id_motif = ?");
        $stmt->execute([$idMotif]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteAllMotifGambar($idMotif)
    {
        $stmt = $this->pdo->prepare("DELETE FROM motif_gambar WHERE id_motif=?");
        return $stmt->execute([$idMotif]);
    }

    // ============================
    // VARIASI
    // ============================
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

    public function updateVariasi($idVar, $data)
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
            $idVar
        ]);
    }

    public function deleteVariasiByKainMotif($idKainMotif)
    {
        $stmt = $this->pdo->prepare("DELETE FROM variasi_motif WHERE id_kain_motif=?");
        return $stmt->execute([$idKainMotif]);
    }

    // ============================
    // KAIN-MOTIF RELASI
    // ============================
    public function addKainMotif($idKain, $idMotif)
    {
        $stmt = $this->pdo->prepare("INSERT INTO kain_motif (id_kain, id_motif) VALUES (?, ?)");
        $stmt->execute([$idKain, $idMotif]);
        return $this->pdo->lastInsertId();
    }

    public function getKainMotif($idKain, $idMotif)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kain_motif WHERE id_kain=? AND id_motif=?");
        $stmt->execute([$idKain, $idMotif]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getKainMotifById($idKainMotif)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kain_motif WHERE id_kain_motif=?");
        $stmt->execute([$idKainMotif]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ambil data variasi_motif berdasarkan id_variasi
    public function getVariasiById($idVariasi)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM variasi_motif WHERE id_variasi=?");
        $stmt->execute([$idVariasi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ambil id_jenis_kain dari nama_jenis (insert jika belum ada)
    public function getOrCreateJenisKain($namaJenis)
    {
        $stmt = $this->pdo->prepare("SELECT id_jenis_kain FROM jenis_kain WHERE nama_jenis=?");
        $stmt->execute([$namaJenis]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            $stmt = $this->pdo->prepare("INSERT INTO jenis_kain(nama_jenis) VALUES(?)");
            $stmt->execute([$namaJenis]);
            return $this->pdo->lastInsertId();
        }
        return $row['id_jenis_kain'];
    }

    // Ambil id_daerah dari nama_daerah (insert jika belum ada)
    public function getOrCreateDaerah($namaDaerah)
    {
        $stmt = $this->pdo->prepare("SELECT id_daerah FROM daerah WHERE nama_daerah=?");
        $stmt->execute([$namaDaerah]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            $stmt = $this->pdo->prepare("INSERT INTO daerah(nama_daerah) VALUES(?)");
            $stmt->execute([$namaDaerah]);
            return $this->pdo->lastInsertId();
        }
        return $row['id_daerah'];
    }
    public function updateKainJenis($idKain, $idJenis)
    {
        $stmt = $this->pdo->prepare("UPDATE kain SET id_jenis_kain=? WHERE id_kain=?");
        return $stmt->execute([$idJenis, $idKain]);
    }

    public function updateKainDaerah($idKain, $idDaerah)
    {
        $stmt = $this->pdo->prepare("UPDATE kain SET id_daerah=? WHERE id_kain=?");
        return $stmt->execute([$idDaerah, $idKain]);
    }


}

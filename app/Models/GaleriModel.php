<?php
class GaleriModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    // ============================
    // CRUD KAIN
    // ============================

    public function getAllKain()
    {
        $stmt = $this->pdo->prepare("
            SELECT k.*, j.nama_jenis, d.nama_daerah, m.nama_motif, mm.makna
            FROM kain k
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            JOIN motif m ON k.id_motif = m.id_motif
            LEFT JOIN makna_motif mm ON k.id_motif = mm.id_motif AND k.id_daerah = mm.id_daerah
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKainById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT k.*, j.nama_jenis, d.nama_daerah, m.nama_motif, mm.makna
            FROM kain k
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            JOIN motif m ON k.id_motif = m.id_motif
            LEFT JOIN makna_motif mm ON k.id_motif = mm.id_motif AND k.id_daerah = mm.id_daerah
            WHERE k.id_kain = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertKain($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO kain 
            (id_jenis_kain, id_daerah, id_motif, panjang_cm, lebar_cm, bahan, jenis_pewarna, harga, stok)
            VALUES (:id_jenis_kain, :id_daerah, :id_motif, :panjang, :lebar, :bahan, :jenis_pewarna, :harga, :stok)
        ");
        return $stmt->execute([
            ':id_jenis_kain' => $data['id_jenis_kain'],
            ':id_daerah' => $data['id_daerah'],
            ':id_motif' => $data['id_motif'],
            ':panjang' => $data['panjang'],
            ':lebar' => $data['lebar'],
            ':bahan' => $data['bahan'],
            ':jenis_pewarna' => $data['jenis_pewarna'],
            ':harga' => $data['harga'],
            ':stok' => $data['stok']
        ]);
    }

    public function getAllJenis()
    {
        $stmt = $this->pdo->prepare("SELECT id_jenis_kain, nama_jenis FROM jenis_kain");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDaerah()
    {
        $stmt = $this->pdo->prepare("SELECT id_daerah, nama_daerah FROM daerah");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllMotif()
    {
        $stmt = $this->pdo->prepare("SELECT id_motif, nama_motif FROM motif");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateKain($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE kain SET
            id_jenis_kain=:id_jenis_kain,
            id_daerah=:id_daerah,
            id_motif=:id_motif,
            panjang_cm=:panjang,
            lebar_cm=:lebar,
            bahan=:bahan,
            jenis_pewarna=:jenis_pewarna,
            harga=:harga,
            stok=:stok
            WHERE id_kain=:id
        ");
        return $stmt->execute([
            ':id_jenis_kain' => $data['id_jenis_kain'],
            ':id_daerah' => $data['id_daerah'],
            ':id_motif' => $data['id_motif'],
            ':panjang' => $data['panjang'],
            ':lebar' => $data['lebar'],
            ':bahan' => $data['bahan'],
            ':jenis_pewarna' => $data['jenis_pewarna'],
            ':harga' => $data['harga'],
            ':stok' => $data['stok'],
            ':id' => $id
        ]);
    }

    public function updateMaknaMotif($id_motif, $id_daerah, $makna)
    {
        // Cek apakah sudah ada record
        $stmt = $this->pdo->prepare("SELECT id_makna FROM makna_motif WHERE id_motif=? AND id_daerah=?");
        $stmt->execute([$id_motif, $id_daerah]);
        $exists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            // Update jika sudah ada
            $stmt = $this->pdo->prepare("UPDATE makna_motif SET makna=? WHERE id_motif=? AND id_daerah=?");
            return $stmt->execute([$makna, $id_motif, $id_daerah]);
        } else {
            // Insert jika belum ada
            $stmt = $this->pdo->prepare("INSERT INTO makna_motif (id_motif, id_daerah, makna) VALUES (?, ?, ?)");
            return $stmt->execute([$id_motif, $id_daerah, $makna]);
        }
    }


    public function deleteKain($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM kain WHERE id_kain = ?");
        return $stmt->execute([$id]);
    }

    // ============================
    // CRUD GAMBAR
    // ============================
    public function getGambarByKain($id_kain)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kain_gambar WHERE id_kain = ?");
        $stmt->execute([$id_kain]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertGambar($id_kain, $path)
    {
        $stmt = $this->pdo->prepare("INSERT INTO kain_gambar (id_kain, path_gambar) VALUES (?, ?)");
        return $stmt->execute([$id_kain, $path]);
    }

    public function deleteGambar($id_gambar)
    {
        $stmt = $this->pdo->prepare("DELETE FROM kain_gambar WHERE id_gambar = ?");
        return $stmt->execute([$id_gambar]);
    }

    // ============================
    // CRUD PRODUK TURUNAN
    // ============================
    public function getAllProduk()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produk_turunan");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProduk($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO produk_turunan (nama_produk, deskripsi, harga, stok)
            VALUES (:nama, :deskripsi, :harga, :stok)
        ");
        $stmt->execute([
            ':nama' => $data['nama_produk'],
            ':deskripsi' => $data['deskripsi'],
            ':harga' => $data['harga'],
            ':stok' => $data['stok']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function linkProdukKain($id_produk, $id_kain, $jumlah_pakai = 1)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO produk_kain (id_produk, id_kain, jumlah_pakai)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE jumlah_pakai=VALUES(jumlah_pakai)
        ");
        return $stmt->execute([$id_produk, $id_kain, $jumlah_pakai]);
    }

    public function searchGaleri($keyword)
    {
        $sql = "
        SELECT 
            k.id_kain,
            k.panjang_cm,
            k.lebar_cm,
            k.bahan,
            k.jenis_pewarna,
            k.harga,
            k.stok,
            j.nama_jenis,
            d.nama_daerah,
            m.nama_motif,
            COALESCE(mm.makna, '') AS makna
        FROM kain k
        JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
        JOIN daerah d ON k.id_daerah = d.id_daerah
        JOIN motif m ON k.id_motif = m.id_motif
        LEFT JOIN makna_motif mm ON mm.id_motif = m.id_motif AND mm.id_daerah = d.id_daerah
        WHERE j.nama_jenis LIKE :kw 
           OR d.nama_daerah LIKE :kw 
           OR m.nama_motif LIKE :kw
        ORDER BY k.id_kain DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':kw' => "%$keyword%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ambil juga gambar tiap kain
        foreach ($result as &$row) {
            $gStmt = $this->pdo->prepare("SELECT path_gambar FROM kain_gambar WHERE id_kain = ?");
            $gStmt->execute([$row['id_kain']]);
            $row['motif_gambar'] = $gStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
}

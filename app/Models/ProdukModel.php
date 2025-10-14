<?php
class ProdukModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function createSlug($text)
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return $text;
    }

    private function isSlugExists($slug)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM produk WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetchColumn() > 0;
    }

    private function isSlugExistsForUpdate($slug, $excludeId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM produk WHERE slug = ? AND id_produk != ?");
        $stmt->execute([$slug, $excludeId]);
        return $stmt->fetchColumn() > 0;
    }

    // ============================
    // GET ALL PRODUK
    // ============================
    public function getAllProduk()
    {
        $sql = "
        SELECT 
            p.*, 
            sk.nama_sub_kategori, 
            k.nama_kategori, 
            d.nama_daerah, 
            m.nama_motif, 
            j.nama_jenis,
            (
                SELECT pg.path_gambar 
                FROM produk_gambar pg 
                WHERE pg.id_produk = p.id_produk 
                LIMIT 1
            ) AS path_gambar
        FROM produk p
        LEFT JOIN sub_kategori sk ON p.id_sub_kategori = sk.id_sub_kategori
        LEFT JOIN kategori k ON sk.id_kategori = k.id_kategori
        LEFT JOIN kain ka ON p.id_kain = ka.id_kain
        LEFT JOIN jenis_kain j ON ka.id_jenis_kain = j.id_jenis_kain
        LEFT JOIN daerah d ON ka.id_daerah = d.id_daerah
        LEFT JOIN motif m ON ka.id_motif = m.id_motif
        ORDER BY p.id_produk DESC
    ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $sql = "
        SELECT 
            p.*, 
            sk.id_kategori, 
            sk.nama_sub_kategori, 
            k.nama_kategori
        FROM produk p
        LEFT JOIN sub_kategori sk ON p.id_sub_kategori = sk.id_sub_kategori
        LEFT JOIN kategori k ON sk.id_kategori = k.id_kategori
        WHERE p.id_produk = ?
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $produk = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produk) {
            $stmt = $this->pdo->prepare("SELECT * FROM produk_gambar WHERE id_produk = ?");
            $stmt->execute([$id]);
            $produk['gambar'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $produk ?: null;
    }


    // ============================
    // ADD PRODUK
    // ============================
    public function addProduk($data, $files)
    {
        // ========== HANDLE KATEGORI ==========
        if (!is_numeric($data['id_kategori'])) {
            $stmt = $this->pdo->prepare("SELECT id_kategori FROM kategori WHERE nama_kategori = ?");
            $stmt->execute([$data['id_kategori']]);
            $kategori = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($kategori) {
                $data['id_kategori'] = $kategori['id_kategori'];
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
                $stmt->execute([$data['id_kategori']]);
                $data['id_kategori'] = $this->pdo->lastInsertId();
            }
        }

        // ========== HANDLE SUB KATEGORI ==========
        if (!is_numeric($data['id_sub_kategori'])) {
            $stmt = $this->pdo->prepare("SELECT id_sub_kategori FROM sub_kategori WHERE nama_sub_kategori = ? AND id_kategori = ?");
            $stmt->execute([$data['id_sub_kategori'], $data['id_kategori']]);
            $sub = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($sub) {
                $data['id_sub_kategori'] = $sub['id_sub_kategori'];
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO sub_kategori (id_kategori, nama_sub_kategori) VALUES (?, ?)");
                $stmt->execute([$data['id_kategori'], $data['id_sub_kategori']]);
                $data['id_sub_kategori'] = $this->pdo->lastInsertId();
            }
        }

        // ========== BUAT SLUG ==========
        $slug = $this->createSlug($data['nama_produk']);
        $i = 1;
        $baseSlug = $slug;
        while ($this->isSlugExists($slug))
            $slug = $baseSlug . "-" . $i++;

        // ========== SIMPAN PRODUK ==========
        $stmt = $this->pdo->prepare("INSERT INTO produk 
        (id_sub_kategori, id_kain, nama_produk, ukuran, harga, stok, deskripsi, slug)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['id_sub_kategori'],
            $data['id_kain'],
            $data['nama_produk'],
            $data['ukuran'],
            $data['harga'],
            $data['stok'],
            $data['deskripsi'],
            $slug
        ]);

        $idProduk = $this->pdo->lastInsertId();

        // ========== SIMPAN GAMBAR ==========
        if ($files['gambar'] && !empty($files['gambar']['name'][0])) {
            $uploadDir = __DIR__ . '/../../public/uploads/produk/';
            foreach ($files['gambar']['tmp_name'] as $key => $tmp_name) {
                $name = time() . "_" . $files['gambar']['name'][$key];
                $target = $uploadDir . $name;
                if (move_uploaded_file($tmp_name, $target)) {
                    $stmt = $this->pdo->prepare("INSERT INTO produk_gambar (id_produk, path_gambar) VALUES (?, ?)");
                    $stmt->execute([$idProduk, "/uploads/produk/" . $name]);
                } else {
                    throw new Exception("Gagal upload file: " . $name);
                }
            }
        }

        return $idProduk;
    }



    // ============================
    // UPDATE PRODUK
    // ============================
    public function updateProduk($id, $data, $files)
    {
        // === Buat slug unik ===
        $slug = $this->createSlug($data['nama_produk']);
        $i = 1;
        $baseSlug = $slug;
        while ($this->isSlugExistsForUpdate($slug, $id))
            $slug = $baseSlug . "-" . $i++;

        // === Update data produk utama ===
        $stmt = $this->pdo->prepare("UPDATE produk SET 
        id_sub_kategori=?, id_kain=?, nama_produk=?, ukuran=?, harga=?, stok=?, deskripsi=?, slug=?
        WHERE id_produk=?");
        $stmt->execute([
            $data['id_sub_kategori'],
            $data['id_kain'],
            $data['nama_produk'],
            $data['ukuran'],
            $data['harga'],
            $data['stok'],
            $data['deskripsi'],
            $slug,
            $id
        ]);

        // === Jika admin mengupload gambar baru ===
        if ($files['gambar'] && !empty($files['gambar']['name'][0])) {
            // Lokasi folder upload
            $uploadDir = __DIR__ . '/../../public/uploads/produk/';

            // 🔥 1. Ambil gambar lama dari database
            $stmt = $this->pdo->prepare("SELECT path_gambar FROM produk_gambar WHERE id_produk = ?");
            $stmt->execute([$id]);
            $oldImages = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // 🔥 2. Hapus file lama dari folder (jika ada)
            foreach ($oldImages as $imgPath) {
                $fullPath = __DIR__ . '/../../public' . $imgPath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            // 🔥 3. Hapus data gambar lama dari tabel
            $stmt = $this->pdo->prepare("DELETE FROM produk_gambar WHERE id_produk = ?");
            $stmt->execute([$id]);

            // 🔥 4. Upload gambar baru
            foreach ($files['gambar']['tmp_name'] as $key => $tmp_name) {
                $name = time() . "_" . $files['gambar']['name'][$key];
                $target = $uploadDir . $name;

                if (move_uploaded_file($tmp_name, $target)) {
                    $stmt = $this->pdo->prepare("INSERT INTO produk_gambar (id_produk, path_gambar) VALUES (?, ?)");
                    $stmt->execute([$id, "/uploads/produk/" . $name]);
                } else {
                    throw new Exception("Gagal upload file: " . $name);
                }
            }
        }
    }


    // ============================
    // DELETE PRODUK
    // ============================
    public function deleteProduk($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM produk_gambar WHERE id_produk = ?");
        $stmt->execute([$id]);

        $stmt = $this->pdo->prepare("DELETE FROM produk WHERE id_produk = ?");
        $stmt->execute([$id]);
    }

    // ============================
    // GET OPTIONS DROPDOWN
    // ============================
    public function getOptions()
    {
        try {
            $data = [];

            // Ambil kategori & sub kategori tetap seperti biasa
            $data['kategori'] = $this->pdo->query("
            SELECT * FROM kategori ORDER BY nama_kategori ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

            $data['sub_kategori'] = $this->pdo->query("
            SELECT * FROM sub_kategori ORDER BY nama_sub_kategori ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

            // Ambil data kain lengkap (gabungan jenis, daerah, motif)
            $data['kain'] = $this->pdo->query("
            SELECT 
                k.id_kain,
                CONCAT(jk.nama_jenis, ' ', d.nama_daerah, ' motif ', m.nama_motif) AS nama_kain
            FROM kain k
            JOIN jenis_kain jk ON k.id_jenis_kain = jk.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            JOIN motif m ON k.id_motif = m.id_motif
            ORDER BY jk.nama_jenis, d.nama_daerah, m.nama_motif ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function searchProduk($keyword)
    {
        $sql = "
        SELECT 
            p.id_produk,
            p.nama_produk,
            p.harga,
            p.stok,
            p.deskripsi,
            s.nama_sub_kategori,
            k.nama_kategori,
            (SELECT path_gambar FROM produk_gambar WHERE id_produk = p.id_produk LIMIT 1) AS path_gambar
        FROM produk p
        JOIN sub_kategori s ON p.id_sub_kategori = s.id_sub_kategori
        JOIN kategori k ON s.id_kategori = k.id_kategori
        WHERE 
            p.nama_produk LIKE :kw 
            OR p.deskripsi LIKE :kw
            OR s.nama_sub_kategori LIKE :kw
            OR k.nama_kategori LIKE :kw
        ORDER BY p.id_produk DESC
        ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':kw' => "%$keyword%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ambil gambar produk
        foreach ($result as &$row) {
            $gStmt = $this->pdo->prepare("SELECT path_gambar FROM produk_gambar WHERE id_produk = ?");
            $gStmt->execute([$row['id_produk']]);
            $row['gambar'] = $gStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

}

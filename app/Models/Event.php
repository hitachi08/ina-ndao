<?php
class Event
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // app/Models/EventModel.php
    private function slugify($text)
    {
        $text = strtolower(trim($text));
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');

        return $text;
    }


    /** Tambah Event */
    public function add($data, $bannerFile = null, $docFiles = [])
    {
        $slug = $this->slugify($data['nama_event']);

        $originalSlug = $slug;
        $i = 1;
        while ($this->isSlugExist($slug)) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO event (nama_event, slug, tempat, tanggal, waktu, deskripsi, gambar_banner)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['nama_event'],
            $slug,
            $data['tempat'],
            $data['tanggal'],
            $data['waktu'],
            $data['deskripsi'],
            $bannerFile
        ]);

        $eventId = $this->pdo->lastInsertId();

        if (!empty($docFiles)) {
            $this->addDokumentasi($eventId, $docFiles);
        }

        return $eventId;
    }

    private function isSlugExist($slug)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM event WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetchColumn() > 0;
    }

    /** Update Event */
    public function update($id, $data, $bannerFile = null, $docFiles = [])
    {
        // Ambil data lama untuk banner
        $stmt0 = $this->pdo->prepare("SELECT gambar_banner FROM event WHERE id_event=?");
        $stmt0->execute([$id]);
        $row = $stmt0->fetch(PDO::FETCH_ASSOC);
        if (!$bannerFile) $bannerFile = $row['gambar_banner'];

        $stmt = $this->pdo->prepare(
            "UPDATE event SET nama_event=?, tempat=?, tanggal=?, waktu=?, deskripsi=?, gambar_banner=? 
             WHERE id_event=?"
        );
        $stmt->execute([
            $data['nama_event'],
            $data['tempat'],
            $data['tanggal'],
            $data['waktu'],
            $data['deskripsi'],
            $bannerFile,
            $id
        ]);

        // Tambah dokumentasi baru jika ada
        if (!empty($docFiles)) {
            $this->addDokumentasi($id, $docFiles);
        }

        return true;
    }

    /** Hapus Event + Dokumentasi */
    public function delete($id)
    {
        // Hapus file banner
        $stmt0 = $this->pdo->prepare("SELECT gambar_banner FROM event WHERE id_event=?");
        $stmt0->execute([$id]);
        $row = $stmt0->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['gambar_banner']) {
            @unlink(__DIR__ . "/../../public/img/event/" . $row['gambar_banner']);
        }

        // Hapus semua dokumentasi terkait
        $docs = $this->getDokumentasi($id);
        foreach ($docs as $doc) {
            @unlink(__DIR__ . "/../../public/img/event/" . $doc['gambar_dokumentasi']);
        }

        // Hapus event
        $stmt = $this->pdo->prepare("DELETE FROM event WHERE id_event=?");
        return $stmt->execute([$id]);
    }

    /** Ambil 1 Event + Dokumentasi */
    public function fetchSingle($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event WHERE id_event=?");
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            $event['dokumentasi'] = $this->getDokumentasi($id);
        }

        return $event;
    }

    /** Ambil semua Event */
    public function fetchAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM event ORDER BY tanggal DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Ambil data Event per halaman */
    public function fetchPaginated($limit, $offset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event ORDER BY tanggal DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Hitung jumlah event */
    public function countAll()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM event");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event WHERE id_event = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ================== Dokumentasi ================== */

    /** Tambah dokumentasi */
    public function addDokumentasi($eventId, $docFiles = [])
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO event_dokumentasi (id_event, gambar_dokumentasi) VALUES (?, ?)"
        );
        foreach ($docFiles as $file) {
            $stmt->execute([$eventId, $file]);
        }
    }

    /** Ambil semua event mendatang (Coming Soon) */
    public function fetchUpcoming()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event WHERE tanggal >= CURDATE() ORDER BY tanggal ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Ambil semua event yang telah berlalu (Past Event) */
    public function fetchPast()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event WHERE tanggal < CURDATE() ORDER BY tanggal DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Ambil semua event mendatang beserta dokumentasi */
    public function fetchUpcomingWithDocs()
    {
        $events = $this->fetchUpcoming();
        foreach ($events as &$ev) {
            $ev['dokumentasi'] = $this->getDokumentasi($ev['id_event']);
        }
        return $events;
    }

    /** Ambil semua event yang telah berlalu beserta dokumentasi */
    public function fetchPastWithDocs()
    {
        $events = $this->fetchPast();
        foreach ($events as &$ev) {
            $ev['dokumentasi'] = $this->getDokumentasi($ev['id_event']);
        }
        return $events;
    }

    /** Ambil dokumentasi event */
    public function getDokumentasi($eventId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event_dokumentasi WHERE id_event=? ORDER BY uploaded_at DESC");
        $stmt->execute([$eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Hapus dokumentasi */
    public function deleteDokumentasi($idDokumentasi)
    {
        $stmt = $this->pdo->prepare("SELECT gambar_dokumentasi FROM event_dokumentasi WHERE id_dokumentasi=?");
        $stmt->execute([$idDokumentasi]);
        $doc = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($doc && $doc['gambar_dokumentasi']) {
            @unlink(__DIR__ . "/../../public/img/event/" . $doc['gambar_dokumentasi']);
        }

        $stmt = $this->pdo->prepare("DELETE FROM event_dokumentasi WHERE id_dokumentasi=?");
        return $stmt->execute([$idDokumentasi]);
    }

    public function findBySlugOrId($idOrSlug)
    {
        $sql = "SELECT * FROM event WHERE slug = :slug OR id_event = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':slug' => $idOrSlug,
            ':id'   => is_numeric($idOrSlug) ? $idOrSlug : 0
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

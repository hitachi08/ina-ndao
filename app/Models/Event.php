<?php
// app/Models/Event.php
class Event
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($data, $bannerFile = null, $docFile = null)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO event (nama_event, tempat, tanggal, waktu, deskripsi, gambar_banner, gambar_dokumentasi)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['nama_event'],
            $data['tempat'],
            $data['tanggal'],
            $data['waktu'],
            $data['deskripsi'],
            $bannerFile,
            $docFile
        ]);
    }

    public function update($id, $data, $bannerFile = null, $docFile = null)
    {
        $stmt0 = $this->pdo->prepare("SELECT gambar_banner, gambar_dokumentasi FROM event WHERE id_event=?");
        $stmt0->execute([$id]);
        $row = $stmt0->fetch(PDO::FETCH_ASSOC);

        if (!$bannerFile) $bannerFile = $row['gambar_banner'];
        if (!$docFile) $docFile = $row['gambar_dokumentasi'];

        $stmt = $this->pdo->prepare(
            "UPDATE event SET nama_event=?, tempat=?, tanggal=?, waktu=?, deskripsi=?, gambar_banner=?, gambar_dokumentasi=? WHERE id_event=?"
        );
        return $stmt->execute([
            $data['nama_event'],
            $data['tempat'],
            $data['tanggal'],
            $data['waktu'],
            $data['deskripsi'],
            $bannerFile,
            $docFile,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt0 = $this->pdo->prepare("SELECT gambar_banner, gambar_dokumentasi FROM event WHERE id_event=?");
        $stmt0->execute([$id]);
        $row = $stmt0->fetch(PDO::FETCH_ASSOC);
        if ($row['gambar_banner']) unlink("../img/event/" . $row['gambar_banner']);
        if ($row['gambar_dokumentasi']) unlink("../img/event/" . $row['gambar_dokumentasi']);

        $stmt = $this->pdo->prepare("DELETE FROM event WHERE id_event=?");
        return $stmt->execute([$id]);
    }

    public function fetchSingle($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM event WHERE id_event=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM event ORDER BY tanggal DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

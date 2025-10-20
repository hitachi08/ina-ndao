<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

use App\Models\NotificationModel;

$notifModel = new NotificationModel($pdo);

$today = new DateTime();
$tomorrow = (new DateTime())->modify('+1 day');
$yesterday = (new DateTime())->modify('-1 day');

$stmt = $pdo->prepare("SELECT * FROM event WHERE tanggal = :tgl");
$stmt->execute([':tgl' => $tomorrow->format('Y-m-d')]);
$eventsBesok = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($eventsBesok as $ev) {
    $judul = "Event akan dimulai besok";
    $isi = "Event '{$ev['nama_event']}' akan dimulai besok pada {$ev['waktu']} di {$ev['tempat']}.";
    $referensi = "event:{$ev['id_event']}";
    $notifModel->create($judul, $isi, 'peringatan', $referensi, 'admin');
}

$stmt = $pdo->prepare("SELECT * FROM event WHERE tanggal = :tgl");
$stmt->execute([':tgl' => $today->format('Y-m-d')]);
$eventsToday = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($eventsToday as $ev) {
    $judul = "Event berlangsung hari ini";
    $isi = "Event '{$ev['nama_event']}' sedang berlangsung hari ini di {$ev['tempat']}.";
    $referensi = "event:{$ev['id_event']}";
    $notifModel->create($judul, $isi, 'peringatan', $referensi, 'admin');
}

$stmt = $pdo->prepare("
    SELECT e.* 
    FROM event e
    LEFT JOIN event_dokumentasi d ON d.id_event = e.id_event
    WHERE e.tanggal < :today
    GROUP BY e.id_event
    HAVING COUNT(d.id_dokumentasi) = 0
");
$stmt->execute([':today' => $today->format('Y-m-d')]);
$eventsNoDoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($eventsNoDoc as $ev) {
    $judul = "Event";
    $isi = "Event '{$ev['nama_event']}' telah selesai. Silakan unggah dokumentasi acara pada halaman event.";
    $referensi = "event:{$ev['id_event']}";
    $notifModel->create($judul, $isi, 'tugas', $referensi, 'admin');
}

echo "Cron run at " . date('Y-m-d H:i:s') . PHP_EOL;

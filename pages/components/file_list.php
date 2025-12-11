<?php
require_once(__DIR__ . '/../../model/Files.php');

// MODEL
$filesModel = new Files();
$files = $filesModel->getAll();

// BASE URL
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Cloudify/');
}

// Helper aman untuk nama file
function getFileName($f) {
    return $f['name']
        ?? $f['filename']
        ?? $f['file_name']
        ?? "Tidak diketahui";
}
?>

<div id="fileWrapper" class="file-wrapper grid-view">

<?php if (empty($files)) : ?>

    <div style="grid-column: 1/-1; text-align:center; padding: 40px; color:#888;">
        <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom:10px;"></i>
        <p>Tidak ada file tersimpan.</p>
    </div>

<?php else: ?>

<?php foreach ($files as $f): ?>

<?php
// ===============================
// NORMALISASI NAMA
// ===============================
$name = getFileName($f);

// ===============================
// NORMALISASI URL
// ===============================
$finalUrl = $f['file_url'] ?? "";

if (empty($finalUrl)) {
    $clean = str_replace("C:/xampp/htdocs/Cloudify/Cloudify/", "", $f['path']);
    $clean = ltrim($clean, "/");
    $finalUrl = BASE_URL . $clean;
}

// cek image
$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
$isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','avif']);

// ===============================
// ICON
// ===============================
$iconClass = "fa-file";

$map = [
    "pdf" => "fa-file-pdf",
    "doc" => "fa-file-word", "docx" => "fa-file-word",
    "xls" => "fa-file-excel", "xlsx" => "fa-file-excel",
    "zip" => "fa-file-archive","rar" => "fa-file-archive","7z" => "fa-file-archive",
    "mp4" => "fa-file-video","mov" => "fa-file-video","avi" => "fa-file-video",
    "mp3" => "fa-file-audio","wav" => "fa-file-audio"
];

if (isset($map[$ext])) {
    $iconClass = $map[$ext];
}

// Favorit
$isFav = $f['is_favorite'] ?? false;
?>

<div class="file-card gd-item" data-file-id="<?= $f['id'] ?>">

<div class="file-thumb">
    <?php if ($isImage): ?>
        <img src="<?= htmlspecialchars($finalUrl) ?>"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
             alt="<?= htmlspecialchars($name) ?>">
        <div class="icon-placeholder" style="display:none;">
            <i class="fas fa-image"></i>
        </div>
    <?php else: ?>
        <div class="icon-placeholder">
            <i class="fas <?= $iconClass ?>"></i>
        </div>
    <?php endif; ?>
</div>

    <div class="file-info">
        <div class="file-name"><?= htmlspecialchars($name) ?></div>
        <div class="file-meta">
            <?= ($f['size'] ?? 0) ?> • <?= date("d M Y", strtotime($f['created_at'])) ?>
        </div>
    </div>

    <div class="file-actions">

        <!-- FAVORIT -->
        <a href="javascript:void(0)"
           onclick="toggleFavorite(<?= $f['id'] ?>)"
           class="favorite-btn <?= $isFav ? 'active':'' ?>">
           <i class="<?= $isFav ? 'fas':'far' ?> fa-star"></i>
        </a>

        <!-- DOWNLOAD -->
        <a href="<?= htmlspecialchars($finalUrl) ?>" download class="download-btn">
            <i class="fas fa-download"></i>
        </a>

        <!-- DELETE KE SAMPAH YANG BENAR -->
        <a href="<?= BASE_URL ?>aksi/sampah.php?file=<?= $f['id'] ?>"
           onclick="return confirm('Yakin hapus file ini?')"
           class="delete-btn">
           <i class="fas fa-trash"></i>
        </a>
    </div> 

</div>

<?php endforeach; endif; ?>

</div>



<style>
/* STYLE SESUAI UI KAMU */
.file-wrapper { display:grid; gap:15px; padding:10px 0; }

.file-wrapper.grid-view {
    grid-template-columns:repeat(auto-fill, minmax(160px, 1fr));
}

.file-card {
    background:#fff;
    border:1px solid #ddd;
    border-radius:12px;
    padding:12px;
    display:flex;
    flex-direction:column;
    text-align:center;
    transition:.25s;
}
.file-card:hover {
    transform:translateY(-4px);
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}

.file-thumb {
    height:100px;
    background:#fafafa;
    display:flex;
    justify-content:center;
    align-items:center;
    border-radius:8px;
    overflow:hidden;
}
.file-thumb img {
    width:100%; height:100%; object-fit:cover;
}
.icon-placeholder i {
    font-size:48px; color:#666;
}

.file-info { margin-top:10px; }
.file-name {
    font-weight:600; font-size:14px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.file-meta { font-size:12px; color:#777; }

.file-actions {
    margin-top:auto;
    display:flex;
    justify-content:center;
    gap:14px;
    padding-top:10px;
    border-top:1px solid #eee;
}

.favorite-btn i { color:#bbb; }
.favorite-btn.active i { color:#ffb400; }

.download-btn:hover { color:#1e88e5 !important; }
.delete-btn:hover { color:#e53935 !important; }
</style>

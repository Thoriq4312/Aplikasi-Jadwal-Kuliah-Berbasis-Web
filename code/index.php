<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    mysqli_query($koneksi, "INSERT INTO jadwal_kuliah VALUES (
        '',
        '$_POST[matkul]',
        '$_POST[dosen]',
        '$_POST[hari]',
        '$_POST[jam]',
        '$_POST[ruang]'
    )");
    header("Location: index.php");
}

if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM jadwal_kuliah WHERE id=$_GET[hapus]");
    header("Location: index.php");
}

$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $data = mysqli_fetch_array(
        mysqli_query($koneksi, "SELECT * FROM jadwal_kuliah WHERE id=$_GET[edit]")
    );
}

if (isset($_POST['update'])) {
    mysqli_query($koneksi, "UPDATE jadwal_kuliah SET
        mata_kuliah='$_POST[matkul]',
        dosen='$_POST[dosen]',
        hari='$_POST[hari]',
        jam='$_POST[jam]',
        ruang='$_POST[ruang]'
        WHERE id=$_POST[id]'
    ");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Jadwal Kuliah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Aplikasi Jadwal Kuliah</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $edit ? $data['id'] : '' ?>">

    <input type="text" name="matkul" placeholder="Mata Kuliah" required
        value="<?= $edit ? $data['mata_kuliah'] : '' ?>">

    <input type="text" name="dosen" placeholder="Dosen" required
        value="<?= $edit ? $data['dosen'] : '' ?>">

    <select name="hari" required>
        <option value="">-- Hari --</option>
        <?php
        $hari = ["Senin","Selasa","Rabu","Kamis","Jumat"];
        foreach ($hari as $h) {
            $selected = ($edit && $data['hari'] == $h) ? "selected" : "";
            echo "<option $selected>$h</option>";
        }
        ?>
    </select>

    <input type="text" name="jam" placeholder="Jam (08.00 - 10.00)" required
        value="<?= $edit ? $data['jam'] : '' ?>">

    <input type="text" name="ruang" placeholder="Ruang" required
        value="<?= $edit ? $data['ruang'] : '' ?>">

    <button name="<?= $edit ? 'update' : 'simpan' ?>">
        <?= $edit ? 'Update' : 'Simpan' ?>
    </button>
</form>

<table>
    <tr>
        <th>No</th>
        <th>Mata Kuliah</th>
        <th>Dosen</th>
        <th>Hari</th>
        <th>Jam</th>
        <th>Ruang</th>
        <th>Aksi</th>
    </tr>

<?php
$no = 1;
$result = mysqli_query($koneksi, "SELECT * FROM jadwal_kuliah");
while ($row = mysqli_fetch_array($result)) {
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['mata_kuliah'] ?></td>
    <td><?= $row['dosen'] ?></td>
    <td><?= $row['hari'] ?></td>
    <td><?= $row['jam'] ?></td>
    <td><?= $row['ruang'] ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>">Edit</a> |
        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus jadwal?')">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>

</div>

</body>
</html>

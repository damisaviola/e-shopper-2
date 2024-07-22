<!DOCTYPE html>
<html>
<head>
    <title>Update Nomor Resi</title>
</head>
<body>
    <h1>Update Nomor Resi</h1>
    <?php if(isset($detail)): ?>
        <form action="<?php echo site_url('detailorder/update_nomor_resi'); ?>" method="post">
            <label for="idDetailOrder">ID Detail Order:</label>
            <input type="text" name="idDetailOrder" id="idDetailOrder" value="<?php echo $detail->idDetailOrder; ?>" readonly>
            <br>
            <label for="nomor_resi">Nomor Resi:</label>
            <input type="text" name="nomor_resi" id="nomor_resi" required>
            <br>
            <input type="submit" value="Update Nomor Resi">
        </form>
    <?php else: ?>
        <p>Data tidak ditemukan.</p>
    <?php endif; ?>
</body>
</html>

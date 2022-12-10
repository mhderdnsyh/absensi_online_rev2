<div class="row detail">
    <div class="col-md-10 col-sm-8 col-6">
        <dl class="row">
            <dt class="col-sm-5">Nama Pegawai:</dt>
            <dd class="col-sm-7"><?= $dataabsensi['namaGtk'] ?></dd>
            <dt class="col-sm-5">Tanggal Absen:</dt>
            <dd class="col-sm-7"><?= $dataabsensi['tglAbsen'] ?></dd>
            <dt class="col-sm-5">Waktu Datang:</dt>
            <dd class="col-sm-7"><?= $dataabsensi['jamMasuk'] ?></dd>
            <dt class="col-sm-5">Waktu Pulang:</dt>
            <dd class="col-sm-7"><?= (empty($dataabsensi['jamPulang'])) ? 'Belum Absen Pulang' : $dataabsensi['jamPulang']; ?></dd>
            <dt class="col-sm-5">Status Kehadiran:</dt>
            <dd class="col-sm-7"><?= ($dataabsensi['statusGtk'] == 1) ? '<span class="badge badge-success">Sudah Absensi</span>' : (($dataabsensi['statusGtk'] == 2) ? '<span class="badge badge-danger">Absensi Terlambat</span>' : '<span class="badge badge-primary">Belum Absensi</span>'); ?></dd>
            <dt class="col-sm-5">Keterangan Absen:</dt>
            <dd class="col-sm-7"><?= $dataabsensi['keteranganAbsen'] ?></dd>
        </dl>
    </div>
</div>

<?php if ($dataapp['mapsUse'] == 1) : ?>
    <h4 class="my-2"><span class="fas fa-map-marked-alt mr-1"></span>Maps</h4>
    <?php if (!empty($dataabsensi['mapsAbsen']) && $dataabsensi['mapsAbsen'] != 'No Location') : ?>
        <div id='maps-view-absen' style='width: 100%; height:250px;'></div>
        <a class="btn btn-primary my-2" href="http://maps.google.com/maps?q=<?= $dataabsensi['mapsAbsen']; ?>" target="_blank"><span class="fas fa-fw fa-map-marker-alt mr-1"></span>Lihat Lokasi</a>
        <script>
            if (document.getElementById("maps-view-absen")) {
                var map = L.map('maps-view-absen').setView([<?= $dataabsensi['mapsAbsen']; ?>], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.marker([<?= $dataabsensi['mapsAbsen']; ?>]).addTo(map);
            }
        </script>
    <?php else : ?>
        <div class="my-2 text-center">Lokasi Tidak Ditemukan</div>
    <?php endif; ?>
<?php endif; ?>
<div class="container">
    <div class="jumbotron shadow-lg">
        <div class="text-center">
            <img src="<?= (empty($dataapp['logoInstansi'])) ? FCPATH . 'assets/img/clock-image.png' : (($dataapp['logoInstansi'] == 'default-logo.png') ? FCPATH . 'assets/img/clock-image.png' : FCPATH . 'storage/setting/' . $dataapp['logoInstansi']); ?>" style="width:20%;">
            <h3>
                <?= (empty($dataapp['namaInstansi'])) ? '[Nama Instansi Belum Disetting]' : $dataapp['namaInstansi']; ?>
            </h3>
        </div>
    </div>
    <p class="my-2">Dibawah Ini Merupakan Data Absensi Yang Telah Terdata:</p>
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
                <dd class="col-sm-7"><?= (empty($dataabsensi['jamPulang'])) ? 'Belum Absensi Pulang' : $dataabsensi['jamPulang']; ?></dd>
                <dt class="col-sm-5">Status Kehadiran:</dt>
                <dd class="col-sm-7"><?= ($dataabsensi['statusGtk'] == 1) ? 'Sudah Absensi' : (($dataabsensi['statusGtk'] == 2) ? 'Absensi Terlambat' : 'Belum Absensi'); ?></dd>
                <dt class="col-sm-5">Keterangan Absen:</dt>
                <dd class="col-sm-7"><?= $dataabsensi['keteranganAbsen'] ?></dd>
                <dt class="col-sm-5">Titik Lokasi Maps:</dt>
                <dd class="col-sm-7"><?= (empty($dataabsensi['mapsAbsen'])) ? 'Lokasi Tidak Ditemukan' : (($dataabsensi['mapsAbsen'] == 'No Location') ? 'Lokasi Tidak Ditemukan' : $dataabsensi['mapsAbsen']); ?></dd>
            </dl>
        </div>
    </div>
    <div class="text-right">
        <p>Atas Nama.</p>
        <p><?= $dataabsensi['namaGtk'] ?></p>
    </div>
    <div class="small">
        PDF was generated on <?= date("Y-m-d H:i:s"); ?>
    </div>
</div>
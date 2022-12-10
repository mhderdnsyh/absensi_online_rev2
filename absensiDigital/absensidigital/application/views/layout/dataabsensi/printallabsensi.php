<div class="container">
    <div class="jumbotron shadow-lg">
        <div class="text-center">
            <img src="<?= (empty($dataapp['logoInstansi'])) ? FCPATH . 'assets/img/clock-image.png' : (($dataapp['logoInstansi'] == 'default-logo.png') ? FCPATH . 'assets/img/clock-image.png' : FCPATH . 'storage/setting/' . $dataapp['logoInstansi']); ?>" style="width:20%;">
            <h3>
                <?= (empty($dataapp['namaInstansi'])) ? '[Nama Instansi Belum Disetting]' : $dataapp['namaInstansi']; ?>
            </h3>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pegawai</th>
                <th scope="col">Tanggal Absen</th>
                <th scope="col">Jam Datang</th>
                <th scope="col">Jam Pulang</th>
                <th scope="col">Status Kehadiran</th>
                <th scope="col">Keterangan Absen</th>
                <th scope="col">Titik Lokasi Maps</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($dataabsensi as $absen) : ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $absen->namaGtk; ?></td>
                    <td><?= $absen->tglAbsen; ?></td>
                    <td><?= $absen->jamMasuk; ?></td>
                    <td><?= (empty($absen->jamPulang)) ? 'Belum Absensi Pulang' : $absen->jamPulang; ?></td>
                    <td><?= ($absen->statusGtk == 1) ? 'Sudah Absensi' : (($absen->statusGtk == 2) ? 'Absensi Terlambat' : 'Belum Absensi'); ?></td>
                    <td><?= $absen->keteranganAbsen; ?></td>
                    <td><?= (empty($absen->mapsAbsen)) ? 'Lokasi Tidak Ditemukan' : (($absen->mapsAbsen == 'No Location') ? 'Lokasi Tidak Ditemukan' : $absen->mapsAbsen); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="small">
        PDF was generated on <?= date("Y-m-d H:i:s"); ?>
    </div>
</div>
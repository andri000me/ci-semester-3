<!DOCTYPE html>
<html>
<head>
	<title>Daftar Lagu</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>bootstrap/css/styledepan.css">
</head>
<body>
	<div id="header">
		<div id="addpl">
	<a href="<?= base_url('UploadController/admin');?>">Tambah Lagu</a>
</div>

	
	</div>
	<div id="daftar">
			<h1>Daftar Lagu</h1>
			<div style="background-color: green;  display: inline-block; color: white;"> <?= $this->session->flashdata('sukses'); ?> </div>
		<style>
		table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
		</style>
		<?php echo form_open('admin/dashboard/daftar-lagu/cari') ?>
			<input class="searchlagu" name="keyword" placeholder="search" required>
			<input class="carilagu" type="submit" value="Cari">
		<?php echo form_close() ?>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th>No</th>
				<th>Tgl Upload</th>
				<th>Judul Lagu</th>
				<th>Artis</th>
				<th>Album</th>
				<th>Dirilis</th>
				<th>Genre</th>
				<th>File</th>
				<th>Uploader</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $a = 1; foreach ($lagu as $l) { ?>
			<tr>
				<td><?= $a++; ?></td>
				<td><?= date('d - m - Y', $l->tgl_upload); ?></td>
				<td><?= $l->judul_lagu; ?></td>
				<td><?= $l->penyanyi; ?></td>
				<td><?= $l->album; ?></td>
				<td><?= $l->dirilis; ?></td>
				<td><?= $l->genre; ?></td>
				<td>
					<audio id="aud" controls="controls">
						<source src="<?= base_url('assets/music/'.str_replace(' ', '_', $l->judul_lagu).'.mp3'); ?>" type="audio/mp3" />
					</audio>
				</td>
				<td><?= substr($l->nama, 2); ?></td>
				<?php echo form_open('admin/dashboard/daftar-lagu/hapus'. '/' . $l->kd_lagu) ?>
					<td><a href="<?= base_url('admin/dashboard/daftar-lagu/edit').'/'.$l->kd_lagu ?>">Edit</a> | <input type="hidden" name="judul_lagu" value="<?= $l->judul_lagu; ?>"> <input class="del" type="submit" value="Hapus"></td>
				<?php echo form_close() ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
		</div>
</body>
</html>
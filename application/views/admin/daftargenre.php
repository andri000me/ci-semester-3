<!DOCTYPE html>
<html>
<head>
	<title>Daftar Lagu</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>bootstrap/css/styledepan.css">
</head>
<body>
	<div id="header">
		<div id="addpl">
	<a href="<?= base_url('admin/dashboard/tambah-genre');?>">Tambah Playlist</a>
</div>

	</div>
	<div id="daftarcuy">
			<h1>Daftar Lagu</h1>
	<?= $this->session->flashdata('sukses'); ?>
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
				<th>Genre</th>
				<th>Kode Genre</th>
				<th>Thumbnail</th>
				<th>Slug</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $a = 1; foreach ($lagu as $l) { ?>
			<tr>
				<td><?= $a++; ?></td>
				<td><?= $l->genre; ?></td>
				<td><?= $l->kd_genre; ?></td>
				<td><?= $l->thumbnail; ?></td>
				<td><?= $l->slug; ?></td>
				<td><a href="<?= base_url('	admin/dashboard/daftar-genre/edit').'/'.$l->kd_genre ?>">Edit</a> | 
				<?php echo form_open('admin/dashboard/daftar-genre/hapus'. '/' . $l->kd_genre) ?>
					<input type="hidden" name="thumbnail" value="<?= $l->thumbnail; ?>">
					<input class="del" type="submit" value="Hapus"></<input>
				<?php echo form_close() ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
		</div>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=rekap-".date('d-m-Y').".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
	<center>
		<h2>Rekap Absensi (<?=$kode_diklat?>) <?= $nama_diklat?></h2>
	</center>
	<table width="100%" border="1">
		<thead>
			<tr style="text-align: center;">
				<th>
					#
				</th>
				<th>
					NIP
				</th>
				<th>
					Nama Pegawai
				</th>
				<th>
					Email
				</th>
				<th>
					Unit
				</th>
				<th>
					Tanggal
				</th>
				<th>
					Jam Masuk
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=0;
			foreach ($get_data as $key => $value) { ?>
				<tr style="text-align: center;">
					<td><?= ++$no?></td>
					<td><?=$value->nip?></td>
					<td><?=$value->nama_lengkap?></td>
					<td><?=$value->email?></td>
					<td><?=$value->unit?></td>
					<td><?=date('d F Y',strtotime($value->tgl))?></td>
					<td><?=$value->jam_masuk?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>
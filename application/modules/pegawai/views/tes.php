<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
	<div>
		<p style="Margin-top: 0;color: #028EA1;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Terima Kasih Sudah Mendaftar</p>

		<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hai, <?php echo $nama_lengkap;?>,</p>

		<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"><?=$pembuka?> "<b><?=$nama_diklat?></b>"</p>
		
		<table style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 13px;line-height: 25px;Margin-bottom: 25px">
			<tr>
				<th>Tanggal</th>
				<th>:</th>
				<td><?= $tgl_mulai.' - '.$tgl_berakhir?></td>
			</tr>
			<tr>
				<th>Waktu</th>
				<th>:</th>
				<td><?= $jam_mulai.' - '.$jam_selesai?></td>
			</tr>
			<tr>
				<th>Tempat</th>
				<th>:</th>
				<td><?=$tempat?></td>
			</tr>
			<tr>
				<th>Dress code</th>
				<th>:</th>
				<td><?=$dc?></td>
			</tr>
		</table>

		<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"><?=$penutup?></p>

		<p style="Margin-top: 0;color: #028EA1;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Terima Kasih ...</p>
		<center>
			<table  style="text-align: center; border: 2px solid blue; width:90%; height: 95%">
				<tr>
					<td style="padding: 30px">
						<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/20/Logo_PLN.svg/1200px-Logo_PLN.svg.png" alt="logo" width="100%"/>

						<h1 style="color: #565656;font-family: Georgia,serif;">PLN PUSAT</h1>

						<img src="<?php echo base_url('assets/qrcode/'.$qrcode)?>" width="100%"> 

						<!-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQkYFpCFHO88f6yiDS-1KQJlWe2BFtV8yKRn7RSfgnEDIYGw6VT" alt="logo" width="100%"/> -->

						<h3 style="color: #565656;font-family: Georgia,serif;"><?=$nama_lengkap?></h3>
						<h3 style="color: #565656;font-family: Georgia,serif;"><?=$nip?></h3>
						<br/><br/>
						<p>Powered By</p>
						<p>PLN UPDL Jakarta</p>
					</td>
				</tr>
			</table>
		</center>
	</div>

</body>

</html>
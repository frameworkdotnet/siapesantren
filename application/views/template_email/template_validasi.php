<!DOCTYPE html>
<html>
<head>
	<title>DINUS KARIR CENTER</title>
<style type="text/css">
	.containers{
		margin: auto;
    	width: 90%;
    	padding: 10px;
    	text-align:center;
	}
	.container2{
		margin: auto;
    	width: 89.1%;
    	border: 0.05em #b3bed0 solid;
    	padding:15px;
	}
	.content{font-size: 18px;font-family: serif;}
	.content1{font-size: 18px;font-family: monospace;}

</style>
</head>
<body>
<div class="containers" style="background-color:#1e427c;color:white;">
	<img width="100" height="100" src="https://ci4.googleusercontent.com/proxy/kvW93YMFaBx_9LgRJzw1-ndQrbYG_S4HeJK5MsQg2m0yQHNkP68bp-w3QXyJcPv3l7KBGJ3iwI_jCDlYU3o4BBorU9BTBGMjqiYs4SAu_PCGXVO2eQ=s0-d-e1-ft#http://dinus.ac.id/gallery2/albums/userpics/10001/logoemail.png">
	<p style="font-size:25px;">DINUS KARIR CENTER</p>
</div>
<div class="container2">
	<?php 
	if($status){
		?>
			<p class="content">Verifikasi akun berhasil, Klik disini untuk Login Kedalam sistem anda <a href="<?php echo base_url(); ?>login">LOGIN</a></p>			
		<?php
	}else{
		?>
			<p class="content">Verifikasi akun gagal atau mungkin akun anda sudah terverifikasi, segera konfirmasi kepada kami <b>bantuan@psi.dinus.ac.id</b></a></p>
		<?php
	}
	 ?>
</div>
<div class="containers" style="background-color:rgb(231, 163, 0);">
	<h3><a href="www.dinus.ac.id">Universitas Dian Nuswantoro</a></h3>
	<a href="www.dinus.ac.id">Universitas Dian Nuswantoro</a>
	<br>Jl. Nakula I No. 5-11 Semarang<br>Jl. Imam Bonjol No. 207 Semarang<br>Telp. (024) 3517261<br>Fax. (024) 3569684<br>Kode Pos : 50131<br>E-Mail:&nbsp;<a href="mailto:sekretariat@dinus.ic.id" target="_blank">sekretariat@dinus.ic.i<wbr>d</a>
</div>

</body>
</html>

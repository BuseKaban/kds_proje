<?php include("head.php");

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

?>

<script src="js/jquery-3.6.0.js"></script>

<body>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#gecersiz').hide();
			$("#giris_button").click(function() {
				$.post("giris.php", {
						isim: $("#isim").val(),
						sifre: $("#sifre").val(),
					},
					function(data, status) {
						if (data != 1) {
							//alert("geçersiz giriş!!")
							$('#gecersiz').show();
						} else {
							$(location).attr("href", "index.php")
						}
					}
				)
			});
		});
	</script>
	<div class="giris">
		<div class="giris_form">
			<b class="baslik">Admin Girişi</b>
			<div class="container">
				<label for="isim'">İsim:</label>
				<input type="text" placeholder="Kullanıcı adı" name="isim" id="isim" required>

				<label for="sifre">Şifre:</label>
				<input type="password" placeholder="Şifre" name="sifre" id="sifre" required>

				<button id="giris_button">Giriş</button>
				<span id="gecersiz">Geçersiz giriş!</span>
				
			</div>
		</div>
	</div>

</body>
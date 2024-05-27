<!DOCTYPE html>
<html>
	<?php
	require_once "partials/head.php";
	?>
	<body>
		<header class="container">
			<h1>ISSUU and Calameo PDF Downloader</h1>
			<div class="alert alert-secondary">
				<strong>Update 07.01.24</strong>
				<br>
				Cześć 🐕
				<br> 
				Od teraz można pobierać tym również czasopisma z Calameo. Wklejamy link i wpisujemy liczbę stron. Generujemy tabelę z linkami i pobieramy pdf. M.
			</div>
			<div class="alert alert-secondary">
				<strong>Update 13.05.23</strong>
				<br>
				Cześć :)
				<br> 
				Dodałem opcję pobierania wszystkich stron gazet do paczki zip zawierającej dokument pdf i folder z plikami jpg przenumerowanymi na potrzeby rscana. Nad/pod tabelą z linkami znajduje się przycisk do pobrania gazety jako pdf. Po wybraniu tej opcji należy poczekaż aż rozpocznie się pobieranie pliku. Po pobraniu każdej kolejnej strony serwer odpoczywa przez 100ms. Wprowadziłem to ogranicznenie celowo, żeby chronić zasoby mojego prywatnego serwera. Proszę o rozsądne korzystanie z tej opcji i o to, by w tym samym czasie z aplikacji korzystała jedna osoba. Aplikacja jest we wczesnej wersji rozwoju, postaram się podgrywać aktualizacje w miarę regularnie. M.
			</div>
		</header>
		<main class="container">
			<section>
				<form data-bitwarden-watching="1" action="actions/submit.php" method="post">
					<fieldset>
						<legend>ISSUU Magazine Info</legend>
						<label for="number-of-pages" class="col-sm-2 col-form-label">Number of pages</label>
						<div class="form-group row">
							<div class="col-sm-10">
								<input type="number"  class="form-control" name="number-of-pages" placeholder="100" required>
								<small id="number-of-pages-help" class="form-text text-muted">Make sure to check how many pages are in the magazine.</small>
							</div>
						</div>
						<div class="form-group">
							<label for="issuu-link" class="form-label mt-4">ISSUU Magazine Link</label>
							<input type="text" class="form-control" name="issuu-link" aria-describedby="issuu-link-help" placeholder="Paste the ISSUU Link here" required>
							<small id="issuu-link-help" class="form-text text-muted">Follow the instruction. You can find it at the bottom of this page.</small>
						</div>
						<button type="submit" class="btn btn-primary">Generate table of links</button>
					</form>
				</section>
				<section class="mt-4 mb-4">
					<h2>Instruction:</h2>
					<div class="alertalert-light">
						<img src="files/instruction.gif" alt="Instruction GIF" width="20%">
						<p><strong>Open in fullscreen mode <a href="files/instruction.gif">here.</a></strong></p>
					</div>
					
				</section>
			</main>
			<footer class="container py-3 my-4 border-top">Mateusz Owczarek DRiPI | <a href="mailto:mateuszowczarek@onet.eu">mateuszowczarek@onet.eu</a></footer>
		</body>
	</html>

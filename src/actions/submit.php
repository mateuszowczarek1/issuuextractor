<!DOCTYPE html>
<html>
<?php
require_once "../partials/head.php";
require "curl.php";
?>

<body>
	<header class="container">
		<h1>Extracted links:</h1>
		<a href="/" type="button" class="btn btn-warning">Go Back</a>
	</header>
	<main class="container">
		<?php
		$publisher;
		$linksArray = [];
		$numberOfPages = $_POST['number-of-pages'];
		$magazineLink = $_POST['issuu-link'];
		$extractedLink = getSource($magazineLink);
		$publisher = (bool) preg_match("/issuu|isu\.pub/i", $extractedLink) !== false
		? ['name' => 'ISSUU', 'referrer' => 'https://issuu.com']
		: ['name' => 'CALAMEO', 'referrer' => 'https://calameo.com'];
		$shortenedLink = dirname($extractedLink, 1) . "/";
		if ($publisher['name'] === 'ISSUU') {
			for ($i = 0; $i < $numberOfPages; $i++) {
				$linksArray[] = $shortenedLink . "page_" . ($i + 1) . ".jpg";
			}
		} else {
			for ($i = 0; $i < $numberOfPages; $i++) {
				$linksArray[] = $shortenedLink . "p" . ($i + 1) . ".jpg";
			}
		}
		?>
		<section>
			<form action="/actions/downloadPdf.php" method="post">
				<?php
				foreach ($linksArray as $link) {
					echo '<input type="hidden" name="links[]" value="' . $link . '">';
					echo '<input type="hidden" name="publisher" value="' . $publisher['referrer'] . '">';
				}
				?>
				<button type="submit" class="btn btn-outline-success" id="pdf-button">Download magazine as PDF</button>
			</form>
		</section>
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Page Number</th>
					<th scope="col">Link</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($linksArray as $index => $link) {
					echo "
					<tr class='table-info'>
							<th scope='row'>Page " . ($index + 1) . "</th>
							<td><a class='btn btn-outline-dark' href='$link' target='_blank'>Download page</a></td>
					</tr>
					";
				}
				?>
			</tbody>
		</table>
	</main>
	</script>
</body>

</html>
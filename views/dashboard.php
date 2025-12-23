<?php include '../views/layouts/plugins-header.php'; ?>

<div class="main-div">
	<!-- sidebar div -->
	<?php include "../views/layouts/sidebar.php";  ?>

	<!-- content div -->
	<div class="content-container">
		<!-- topbar div -->
		<?php include "../views/layouts/topbar.php";  ?>

        <div class="content-bottom">
			<div class="content-title">
				<h5>Dashboard</h5>
			</div>
			<div class="cards-div row mx-0">
				<?php 
				$arrays = [
					[
						"icons"=> "ri-wallet-2-line",
						"bg-color"=> "#4680ff",
						"title"=> "Capital",
					],
					[
						"icons"=> "ri-hand-coin-line",
						"bg-color"=> "#00bcd4",
						"title"=> "Revenue",
					],
					[
						"icons"=> "ri-bar-chart-line",
						"bg-color"=> "#4caf50",
						"title"=> "Upcoming Income",
					],
					[
						"icons"=> "ri-bar-chart-horizontal-line",
						"bg-color"=> "#011b37",
						"title"=> "Owner's Income",
					],
				];
				$values = [
					$r['capital'],
					$r['revenue'],
					$r['pending_income'],
					$r['owner_income']
				];
				foreach ($arrays as $key => $array):

					switch ($key) {
						case '0':
							$paddingClass = "px-0 pe-md-2 ps-lg-0";
							break;
						case '1':
							$paddingClass = "px-0 ps-md-2 px-lg-2";
							break;
						case '2':
							$paddingClass = "px-0 pe-md-2 px-lg-2";
							break;
						case '3':
							$paddingClass = "px-0 ps-md-2";
							break;
						default:
							$paddingClass = "px-lg-2";
							break;
					}
					
				?>
				<div class="col-lg-3 col-md-6 col-12 <?= $paddingClass; ?>">
					<div class="card-items" style="background-color: <?= $array['bg-color']; ?>;">
						<div class="card-details">
							<small><?= $array['title']; ?></small>
							<div>₱ <?= number_format($values[$key], 2) ?></div>
						</div>
						<div class="card-icon">
							<i class="<?= $array['icons']; ?>"></i>
						</div>
					</div>
				</div>
				<?php
				endforeach;
				?>
			</div>
			<div class="row mx-0">
				<div class="col-12 px-0 pe-xxl-2">
					<div class="chart-div">
						<div class="chart-top">
							<strong class="text-secondary">Monthly Revenue</strong>
						</div>
						<div id="chartSample" class="chart-format"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$months = !empty($r['months']) ? $r['months'] : [];
$monthlyLoanCounts = !empty($r['charts']) ? $r['charts'] : [];
?>

<script>
const months = <?= json_encode($months, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const monthlyLoanCounts = <?= json_encode($monthlyLoanCounts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<?php include '../views/layouts/plugins-footer.php'; ?>

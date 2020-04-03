<?php
global $main_import;
?>
<div class="wrap yanka-wrap">
    <h1><?php esc_html_e( 'Welcome to Yanka!', 'yanka' ); ?></h1>
    <div class="about-text"><?php esc_html_e( 'Yanka is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'yanka' ); ?></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=yanka' ), esc_html__( 'Welcome', 'yanka' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=yanka-plugins' ), esc_html__( 'Plugins', 'yanka' ) );
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( 'Install Samples', 'yanka' ) );
        ?>
    </h2>
    <div class="yanka-section">
		<div class="yanka-import-area yanka-row yanka-three-columns <?php echo esc_attr( $main_import->gen_imported_pages_classes() ); ?>">
	<div class="yanka-column import-base">
		<div class="yanka-column-inner">
			<div class="yanka-box yanka-box-shadow">
				<div class="yanka-box-header">
					<h2><?php esc_html_e('Base Data Import', 'yanka'); ?></h2>
					<span class="yanka-box-label yanka-label-error"><?php esc_html_e('Required', 'yanka'); ?></span>
				</div>
				<div class="yanka-box-info">
					<p>
						<?php esc_html_e( 'It includes Home Default (Home 1) version , blog posts, portfolios, pages, demo products. It is a required data to be able to import additional pages.', 'yanka' ); ?>
					</p>
				</div>
				<div class="yanka-box-content">
					<?php $main_import->imported_pages(); ?>
					<?php $main_import->base_import_screen(); ?>
					<div class="yanka-success base-imported-alert">
						<span class="highlight">
                            <?php esc_html_e( 'Base Data is successfully imported. Now you can choose any pages to apply its settings for your website. You are be able to back to default version by click to "Activate Base Version" Button.', 'yanka' ); ?>
            </span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="yanka-column import-pages">
		<div class="yanka-column-inner">
			<div class="yanka-box yanka-box-shadow">
				<div class="yanka-box-header">
					<h2><?php esc_html_e('Home Setup', 'yanka'); ?></h2>
					<span class="yanka-box-label yanka-label-recommended"><?php esc_html_e('Recommended', 'yanka'); ?></span>
				</div>
				<div class="yanka-box-info">
					<p>
						<?php esc_html_e( 'Select one Home Page from box then click to "Import Home", It will import Home content, Home sliders, and Home setting and set that Home to Frontpage.', 'yanka' ); ?>
						<br>
					</p>
				</div>
				<div class="yanka-box-content">
					<?php $main_import->homes_import_screen(); ?>
				</div>

			</div>
		</div>
	</div>
	<div class="yanka-column import-pages">
		<div class="yanka-column-inner">
			<div class="yanka-box yanka-box-shadow">
				<div class="yanka-box-header">
					<h2><?php esc_html_e('Pages Import', 'yanka'); ?></h2>
					<span class="yanka-box-label yanka-label-warning"><?php esc_html_e('Optional', 'yanka'); ?></span>
				</div>
				<div class="yanka-box-info">
					<p>
						<?php esc_html_e( 'Select one Page from box then click to "Import Page", It will be import page content, help you easy to create page like on demo.', 'yanka' ); ?>
					</p>
				</div>
				<div class="yanka-box-content">
					<?php $main_import->pages_import_screen(); ?>
				</div>

			</div>
		</div>
	</div>
	<br />
	<p>
		<?php esc_html_e( 'Note : Base Data Import must download all attachment from server so sometime it broken when use internet slow. Dont worry refresh this page again then click to Base Import again, it will be ok.', 'yanka' ); ?>
	</p>
</div>
    </div>
</div>

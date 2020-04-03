<?php
$theme = wp_get_theme();
if ($theme->parent_theme) {
    $template_dir =  basename(get_template_directory());
    $theme = wp_get_theme($template_dir);
}
?>
<div class="wrap yanka-wrap">
    <h1><?php esc_html_e( 'Welcome to Yanka!', 'yanka' ); ?></h1>
    <div class="about-text"><?php esc_html_e( 'Yanka is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'yanka' ); ?></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( 'Welcome', 'yanka' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=yanka-plugins' ), esc_html__( 'Plugins', 'yanka' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=yanka-samples' ), esc_html__( 'Install Samples', 'yanka' ) );
        ?>
    </h2>
    <div class="yanka-section">
        <p class="about-description">
            <?php printf( esc_html__( 'Before you get started, please be sure to always check out', 'yanka')); ?> <a href="<?php printf(esc_url('//wp-docs.jmsthemes.com/yanka/'));?>" target="_blank"><?php printf(esc_html__('this documentation','yanka'));?></a>. <?php printf( esc_html__( 'We outline all kinds of good information, and provide you with all the details you need to use Shopp.', 'yanka')); ?>
        </p>
        <p class="about-description">
            <?php printf( esc_html__( 'If you are unable to find your answer in our documentation, we encourage you to contact us through','yanka'));?> <a href="<?php printf(esc_url('//joommasters.ticksy.com/'));?>" target="_blank"><?php printf(esc_html__('support page','yanka'));?></a> <?php printf( esc_html__( 'with your site CPanel (or FTP) and WordPress admin details. We are very happy to help you and you will get reply from us more faster than you expected.', 'yanka')); ?>
        </p>

    </div>
    <div class="yanka-thanks">
        <p class="description"><?php esc_html_e( 'Thank you, we hope you to enjoy using Yanka!', 'yanka' ); ?></p>
    </div>
</div>

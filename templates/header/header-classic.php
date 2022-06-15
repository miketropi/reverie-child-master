<?php 
/**
 * Header classic
 */

?>
<?php do_action('ccs/before_header'); ?>

<header id="SiteHeader" class="site-header main-header header-classic">
  <div class="site-container">
    <div class="header-classic__inner">
      <div class="site-brand"><?php ccs_site_logo(); ?></div>
      <div class="site-nav"><?php ccs_site_nav(); ?></div>
      <div class="site-extra"><?php ccs_site_header_extra(); ?></div>
    </div>
  </div>
</header>

<?php do_action('ccs/after_header'); ?>

<div class="mobile-menu-offcanvas">
  <div class="mobile-menu-offcanvas__inner">
    <a href="#" class="mobile-menu-offcanvas__close">
      <span><?php echo ccs_icon('close') ?></span>  
      <?php _e('Close', 'ccs') ?>
    </a>
    <?php do_action('ccs/before_mobile_menu') ?>
    
    <div class="site-nav"><?php ccs_site_nav(); ?></div>
    
    <?php do_action('ccs/after_mobile_menu') ?>
  </div>
</div> <!-- .mobile-menu-offcanvas -->
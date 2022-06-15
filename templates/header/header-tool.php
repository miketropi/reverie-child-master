<?php
/**
 * Header tools 
 */

$tools = apply_filters('site-header-tools', [
  'help' => [
    'title' => __('Help', 'ccs'),
    'icon' => ccs_icon('help'),
    'link' => '/#',
  ],
  'search' => [
    'icon' => ccs_icon('search'),
    'link' => get_search_link(),
  ],
  'mini-cart' => [
    'icon' => ccs_icon('cart') . ccs_icon('cart-mobi'),
    'link' => (function_exists('wc_get_cart_url')) ? wc_get_cart_url() : '/#',
  ]
]);
?>
<ul class="header-tool">
  <?php foreach($tools as $k => $t) { ?>
  <li class="header-tool__item __<?php echo $k ?>">
    <a href="<?php echo $t['link'] ?>">
      <?php echo isset($t['title']) ? $t['title'] : '' ?>
      <span class="__icon"><?php echo $t['icon'] ?></span>
    </a>
  </li>
  <?php } ?>
  <li class="header-tool__item __mobi-toggle-button">
    <span class="__icon"><?php echo ccs_icon('hamburger'); ?></span>
  </li>
</ul>
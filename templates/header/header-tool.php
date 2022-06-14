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
    'link' => '/#',
  ],
  'mini-cart' => [
    'icon' => ccs_icon('cart'),
    'link' => '/#',
  ]
]);
?>
<ul class="header-tool">
  <?php foreach($tools as $t) { ?>
  <li class="header-tool__item">
    <a href="<?php echo $t['link'] ?>">
      <?php echo isset($t['title']) ? $t['title'] : '' ?>
      <span class="__icon"><?php echo $t['icon'] ?></span>
    </a>
  </li>
  <?php } ?>
</ul>
export default () => {
  const $nav = jQuery('ul.site-main-menu');
  const arrowSVG = `<svg width="8" height="7" viewBox="0 0 8 7" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M0.611328 0.0117302L0.611328 3.46627L4.12447 7L7.61133 3.4956L7.61133 0L4.10695 3.51906L0.611328 0.0117302Z" fill="#E4752E"/> </svg>`;
  
  const $btnToggleMobileMenu = jQuery('.header-tool__item.__mobi-toggle-button');
  const $mobileMenuOffcanvas = jQuery('.mobile-menu-offcanvas');

  const appendArrowHasSub = () => {
    $nav.find('li.menu-item-has-children > a').append(`<span class="__arrow-nav-item">${ arrowSVG }</span>`)
  }

  const MobileMenuHandle = () => {
    $btnToggleMobileMenu.on('click', e => {
      document.body.classList.toggle('__mobile-menu-active')
    })

    $mobileMenuOffcanvas.find('.mobile-menu-offcanvas__close').on('click', e => {
      e.preventDefault();
      document.body.classList.remove('__mobile-menu-active')
    })

    $mobileMenuOffcanvas.find('li.menu-item-has-children > a').on('click', function(e) {
      e.preventDefault();
      let $a = jQuery(this);
      let $parentLi = jQuery(this).closest('li');
      let _status = $a.data('__is-open');

      if(_status == false) {
        $parentLi.children('ul.sub-menu').slideDown();
        $a.data('__is-open', true);
      } else {
        $parentLi.children('ul.sub-menu').slideUp();
        $a.data('__is-open', false);
      }

    })
  }

  appendArrowHasSub();
  MobileMenuHandle();
}
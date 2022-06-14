export default () => {
  const $nav = jQuery('ul.site-main-menu');
  const arrowSVG = `<svg width="8" height="7" viewBox="0 0 8 7" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M0.611328 0.0117302L0.611328 3.46627L4.12447 7L7.61133 3.4956L7.61133 0L4.10695 3.51906L0.611328 0.0117302Z" fill="#E4752E"/> </svg>`;

  const appendArrowHasSub = () => {
    $nav.find('li.menu-item-has-children > a').append(`<span class="__arrow-nav-item">${ arrowSVG }</span>`)
  }

  appendArrowHasSub();
}
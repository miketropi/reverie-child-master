const mix = require('laravel-mix');

mix
  .js('./src/main.js', 'dist')
  .sass('./src/scss/main.scss', 'css')
  .setPublicPath('dist')
  .options({
    processCssUrls: false
  })
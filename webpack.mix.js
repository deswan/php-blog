const { mix } = require('laravel-mix');
const path = require('path');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
function resolve(dir){
  return dir ? path.resolve(__dirname,'resources/assets',dir) : path.resolve(__dirname,'resources/assets')
}
mix.webpackConfig({
  resolve:{
    alias:{
      '@':resolve(),
      home:resolve('home'),
      admin:resolve('admin'),
      img:resolve('images')
    }
  }
})

mix.disableNotifications();

mix.js('resources/assets/home/home.js', 'public/js').sourceMaps()
  .js('resources/assets/admin/admin.js', 'public/js')

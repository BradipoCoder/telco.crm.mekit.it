module.exports = function (grunt) {
  grunt.initConfig({

    uglify: {
      options: {
        beautify: false,
        mangle: false,
        sourceMap: true,
        banner: '/*! SuiteMekit Style JS files <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: [
          /*'themes/SuiteMekit/js/style/suitep.js',*/
          'themes/SuiteMekit/js/style/exposed.js',
          'themes/SuiteMekit/js/style/sugar.js',
          'themes/SuiteMekit/js/style/mekit.js',
          'themes/SuiteMekit/js/style/navbar.js',
          'themes/SuiteMekit/js/style/sidebar.js',
          'themes/SuiteMekit/js/style/footer.js',
          'themes/SuiteMekit/js/style/mobile.js'
        ],
        dest: 'themes/SuiteMekit/js/style.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['uglify']);
};


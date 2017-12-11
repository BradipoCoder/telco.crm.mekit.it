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
          'themes/SuiteMekit/js/style/suitep.js',
          'themes/SuiteMekit/js/style/sidebar.js',
          'themes/SuiteMekit/js/style/mekit.js'
        ],
        dest: 'themes/SuiteMekit/js/style.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['uglify']);
};



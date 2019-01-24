'use strict';
module.exports = function(grunt) {
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');

  var config = grunt.file.readYAML('config.yml');
  grunt.initConfig(config);

  // Sobreescribimos la tarea concat:bootstrap-js para concatenar sólo los
  // archivos de los componentes activados en jsComponents.
  if (grunt.config('jsComponents')) {
    var javascript = grunt.config('jsComponents'),
    paths = [];
    javascript.forEach(function(js) {
      paths.push('node_modules/bootstrap-sass/assets/javascripts/bootstrap/' + js + '.js')
    });
    grunt.config('concat.bootstrap-js.src', paths);
  }

  grunt.registerTask('bootstrap', ['sass:bootstrap', 'copy:bootstrap-fonts', 'concat:bootstrap-js']);
  grunt.registerTask('default', ['bootstrap', 'sass:dist', 'copy:assets']);
};

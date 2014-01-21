module.exports = function( grunt ) {

	// All configurations go here
	grunt.initConfig({

		// Reads the package.json file
		pkg: grunt.file.readJSON( 'package.json' ),

		// Each Grunt plugins configurations will go here
		less: {
			app: {
				files: {
					'css/app.css': 'less/app.less',
				}
			}
		},
		concat: {
			app: {
				src: ['js/**/*.js'],
				dest: 'js/build/app.js'
			}
		},
		uglify: {
			options: {
				report: true
			},
			build: {
				src: 'js/build/app.js',
				dest: 'js/build/app.min.js'
			}
		},
		cssmin: {
			minify: {
				options: {
					keepSpecialComments: 0
				},
				files: {
					'css/app.min.css': ['css/app.css']
				}
			}
		},
		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					cwd: 'images/',
					src: ['**/*.{png,jpg,gif}'],
					dest: 'images/'
				}]
			}
		},
		watch: {
			options: {
				dateFormat: function( time ) {
					grunt.log.writeln( 'Completed tasks in ' + time + 'ms at ' + ( new Date() ).toString() );
					grunt.log.writeln( 'Waiting for more changes...' );
				}
			},
			scripts: {
				files: ['js/**/*.js'],
				tasks: ['concat','uglify'],
				options: {
					spawn: false
				}
			},
			css: {
				files: ['less/**/*.less', 'less/bootstrap/**/*.less'],
				tasks: ['less','cssmin'],
				options: {
					spawn: false
				}
			},
			images: {
				files: ['images/**/*.{png,jpg,gif}'],
				tasks: ['imagemin'],
				option: {
					spawn: false
				}
			}
		}
	});
	
	// Simplify the repetivite work of listing each plugin in grunt.loadNomTasks(), just get the list from package.json and load them...
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// Tell Grunt to run these tasks by default.
	// We can create new tasks with different names for specific tasks
	grunt.registerTask( 'js', ['concat', 'uglify'] );
	grunt.registerTask( 'css', ['less', 'cssmin'] );
	grunt.registerTask( 'default', ['js', 'css', 'watch'] );

};
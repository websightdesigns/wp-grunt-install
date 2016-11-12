module.exports = function (grunt) {
	grunt.initConfig({
		path: 'wp-content/themes/my-theme/',
		includes: 'wp-includes/',
		jshint: {
			files: [
				'gruntfile.js',
				'<%= path %>js/project.js'
			],
			options: {
				globals: {
					jQuery: true
				}
			}
		},
		concat: {
			options: {
				stripBanners: true
			},
			dist: {
				src: [
					'<%= path %>js/lib/jquery.min.js',
					'<%= path %>js/lib/bootstrap.min.js', // @url http://getbootstrap.com/
					'<%= includes %>js/comment-reply.js', // @desc wp_enqueue_script( 'comment-reply' );
					'<%= includes %>js/wp-embed.min.js', // @desc wp_enqueue_script( 'wp-embed' );
					'<%= path %>js/_project.js'
				],
				dest: '<%= path %>js/script.js'
			}
		},
		uglify: {
			files: {
				src: '<%= path %>js/script.js', // source files mask
				dest: '<%= path %>js/', // destination folder
				expand: true, // allow dynamic building
				flatten: true, // remove all unnecessary nesting
				ext: '.min.js' // replace .js to .min.js
			}
		},
		prettysass: {
			options: {
				alphabetize: false,
				indent: "t",
				removeBlankLines: true
			},
			dist: {
				src: ['<%= path %>sass/partials/*.scss']
			}
		},
		sass: {
			dist: {
				options: {
					style: 'expanded',
					lineNumbers: false,
					sourcemap: 'none'
				},
				files: {
					'<%= path %>style.css': '<%= path %>sass/style.scss'
				}
			}
		},
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1,
				keepSpecialComments: 0
			},
			target: {
				files: {
					'<%= path %>style.min.css': '<%= path %>style.css'
				}
			}
		},
		watch: {
			js: {
				files: '<%= path %>js/project.js',
				tasks: [ 'jshint', 'concat', 'uglify' ]
			},
			css: {
				files: '<%= path %>sass/**/*.scss',
				tasks: [ 'prettysass', 'sass', 'cssmin' ]
			}
		}
	});

	// load plugins
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-prettysass');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// register tasks
	grunt.registerTask( 'default', [ 'watch', 'jshint', 'concat', 'prettysass', 'sass', 'cssmin', 'uglify' ] );
	grunt.registerTask( 'build', [ 'jshint', 'concat', 'prettysass', 'sass', 'cssmin', 'uglify' ] );

};

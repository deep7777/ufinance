var path = require('path');

var paths = {
  rootPath: path.join(__dirname, '../'),
	cssPath: path.join(__dirname, './public/css'),
  jsPath: path.join(__dirname, './public/js'),
  bowerPath: path.join(__dirname, './bower_components'),
  publicPath: path.join(__dirname, './public'),
  imgPath: path.join(__dirname, './public/images')
};


var scripts = {
  jsPlugins: [
    paths.cssPath   +'/vendors/jquery/dist/jquery.min.js',
		paths.cssPath   +'/vendors/bootstrap/dist/js/bootstrap.min.js',
		paths.cssPath   +'/vendors/fastclick/lib/fastclick.js',
		paths.cssPath   +'/vendors/nprogress/nprogress.js',
		paths.cssPath   +'/vendors/Chart.js/dist/Chart.min.js',
		paths.cssPath   +'/vendors/bernii/gauge.js/dist/gauge.min.js',
		paths.cssPath   +'/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
		paths.cssPath   +'/vendors/iCheck/icheck.min.js',
		paths.cssPath   +'/vendors/skycons/skycons.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.pie.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.time.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.stack.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.resize.js',
		paths.jsPath   +'/flot/jquery.flot.orderBars.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.js', 
		paths.cssPath   +'/vendors/Flot/jquery.flot.pie.js', 
		paths.cssPath   +'/vendors/Flot/jquery.flot.time.js',
		paths.cssPath   +'/vendors/Flot/jquery.flot.stack.js',  
		paths.cssPath   +'/vendors/Flot/jquery.flot.resize.js',  
		paths.jsPath   +'/flot/jquery.flot.orderBars.js',  
		paths.jsPath   +'/flot/date.js',  
		paths.jsPath   +'/flot/jquery.flot.spline.js',  
		paths.jsPath   +'/flot/curvedLines.js', 
		paths.jsPath   +'/maps/jquery-jvectormap-2.0.3.min.js',  
		paths.jsPath   +'/moment/moment.min.js',  
		paths.jsPath   +'/datepicker/daterangepicker.js',
		paths.cssPath   +'/vendors/datatables.net/js/jquery.dataTables.min.js',
		paths.jsPath   +'/plugins/parsley.min.js',
		paths.jsPath   +'/custom.min.js'
  ],
  jsFiles: [
    paths.publicPath + '/js/login/*.js'
  ]
};

var styles = {
  cssPlugins: [
    paths.cssPath+'/vendors/bootstrap/dist/css/bootstrap.min.css', 
    paths.cssPath+'/vendors/font-awesome/css/font-awesome.min.css',
    paths.cssPath+'/vendors/iCheck/skins/flat/green.css',
    paths.cssPath+'/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
		paths.cssPath+'/vendors/datatables.net-bs/css/buttons.bootstrap.min.css'
  ],
  cssFiles: [
    paths.cssPath+'/custom.min.css'
  ]
};

module.exports = {
  paths: paths,
  root_path: paths.rootPath,
  bowerPath: paths.bowerPath,
  cssPath : paths.cssPath,
  jsPlugins: scripts.jsPlugins,
	cssPlugins: styles.cssPlugins,
	cssFiles: styles.cssFiles,
  jsFiles: scripts.jsFiles
};

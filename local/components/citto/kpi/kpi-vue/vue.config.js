console.log(process.env.NODE_ENV)

if (process.env.NODE_ENV === 'production') {
  module.exports =
    {
      assetsDir: '../../../../../../local/components/citto/kpi/templates/kpi-vue-template',
      indexPath: 'template.php',
      outputDir: '../templates/kpi-vue-template',
      publicPath: '/vue'
    };
}


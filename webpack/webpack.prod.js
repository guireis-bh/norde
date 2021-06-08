const path = require('path')
const VueLoaderPlugin = require('vue-loader/lib/plugin')
const DotEnv = require('dotenv-webpack')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')

module.exports = {
    mode: 'production',
    entry: './resources/assets/js/app.js',
    output: {
        filename: 'app.js',
        path: path.resolve(__dirname, '../public/js')
    },
    module: {
        rules: [
          {
            test: /\.vue$/,
            loader: 'vue-loader'
          }
        ]
    },
    plugins: [
        // make sure to include the plugin!
        new VueLoaderPlugin(),
        new DotEnv(),
        new UglifyJsPlugin()
    ]
}
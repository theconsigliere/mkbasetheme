const webpack = require('webpack')
const path = require('path')

const DotEnv = require('dotenv-webpack')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const CopyPlugin = require('copy-webpack-plugin')
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const { ESBuildMinifyPlugin } = require('esbuild-loader')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const stylesHandler = MiniCssExtractPlugin.loader

// Paths
const jsPath = path.join(__dirname, 'src/js')
const stylesPath = path.join(__dirname, 'src/scss')

module.exports = {
  mode: 'development',
  entry: [
    path.join(jsPath, 'index.js'),
    path.join(stylesPath, 'style.scss'),
    path.join(stylesPath, 'gutenberg-styles.scss'),
    path.join(stylesPath, '/backend/login.scss'),
    path.join(stylesPath, '/backend/UI-colour-scheme.scss'),
    path.join(stylesPath, '/backend/dashboard.scss')
  ],
  output: {
    path: path.resolve(process.cwd(), 'build'),
    filename: 'js/index.js',
    iife: true
  },
  devtool: 'source-map',
  cache: true,
  resolve: {
    modules: ['node_modules']
  },
  module: {
    rules: [
      {
        parser: {
          amd: false,
        }
      },
      {
        test: /\.js$/,
        loader: 'esbuild-loader',
        exclude: /node_modules/,
        options: {
          target: 'es2015' // Syntax to compile to (see options below for possible values)
        }
      },
      {
        test: /\.(jpe?g|png|gif|svg)$/i,
        type: 'asset'
      },
      // Extract any SCSS content and minimize
      {
        test: /\.scss$/,
        // exclude: /node_modules/,
        use: [
          {
            loader: 'file-loader',
            options: {
              outputPath: 'styles/',
              name: '[name].css'
            }
          },
          // {
          //   loader: 'css-loader'
          // },
          {
            loader: 'postcss-loader'
          },
          {
            loader: 'sass-loader'
          }
        ]
      },
      {
        // Extract any CSS content and minimize
        test: /\.css$/,
        sideEffects: true,
        use: [
          stylesHandler,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 1
            }
          },
          { loader: 'postcss-loader' }
        ]
      }
    ]
  },
  optimization: {
    minimize: true,
    minimizer: [
      new ESBuildMinifyPlugin({
        target: 'es2015', // Syntax to compile to (see options below for possible values)
        css: true // Apply minification to CSS assets
      })
    ]
  },
  plugins: [
    new DotEnv(),
    new webpack.EnvironmentPlugin({ ...process.env }),
    new MiniCssExtractPlugin({
      filename: '[name]-[hash].css'
    }),
    new CleanWebpackPlugin(),
    new webpack.ProgressPlugin(),
    new CopyPlugin({
      patterns: [
        {
          from: 'src/images',
          to: 'images'
        }
      ]
    }),
    new ImageMinimizerPlugin({
      minimizerOptions: {
        // Lossless optimization with custom option
        // Feel free to experiment with options for better result for you
        plugins: [
          ['gifsicle', { interlaced: true }],
          ['jpegtran', { progressive: true }],
          ['optipng', { optimizationLevel: 5 }]
          // Svgo configuration here https://github.com/svg/svgo#configuration
          // ["svgo"],
        ]
      }
    }),
    new BrowserSyncPlugin({
      host: 'localhost',
      injectChanges: true,
      proxy: 'http://dmtheme.local/'
    })
  ]
}

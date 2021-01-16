var path = require('path');
var webpack = require('webpack');
 
module.exports = {
    entry: "./resources/js/index.js", // входная точка - исходный файл
    output:{
        path: path.resolve(__dirname, './resources/'),     // путь к каталогу выходных файлов - папка resources
        publicPath: '/resources/',
        filename: "bundle.js"       // название создаваемого файла
    },
     plugins: [
      new webpack.ProvidePlugin({
        $: "jquery/dist/jquery.min.js",
        jQuery: "jquery/dist/jquery.min.js",
        "window.jQuery": "jquery/dist/jquery.min.js"
      })
    ],

    module:{
        rules:[   //загрузчик для jsx
            {
                test: /\.js?$/, // определяем тип файлов
                exclude: /(node_modules)/,  // исключаем из обработки папку node_modules
                loader: "babel-loader",   // определяем загрузчик
                // options:{
                //     presets:["@babel/preset-env", "@babel/preset-react"]    // используемые плагины
                // }
                //or in .babelrc
            },
            {
                test: /\.(png|jpg|gif)$/,
                loader:"file-loader",
                options: {
                  outputPath: 'images',
                },
            },
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                  // Creates `style` nodes from JS strings
                  'style-loader',
                  // Translates CSS into CommonJS
                  'css-loader',
                  // Compiles Sass to CSS
                  'sass-loader',
                ],
              },
         // {
         //    test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
         //    use: [
         //      {
         //        loader: 'file-loader',
         //            options: {
         //              name: "[name].[ext]",
         //              outputPath: 'php_projs/project2/fonts/'
         //            }
         //      }
         //    ]
         //  }

        ]
    }
}
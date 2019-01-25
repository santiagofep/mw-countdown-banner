const path = require('path');

module.exports = {
  entry: './src/index.js',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'mwcb.js'
  },
	module: {
		rules: [
			{
				test:/\.(s*)css$/,
        use:['style-loader','css-loader', 'sass-loader']
			}
		]
	}
};
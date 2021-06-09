module.exports = {
    devServer: {
      overlay: {
        warnings: true,
        errors: true
      },
      proxy: 'https://localhost:8000'
    }
  }
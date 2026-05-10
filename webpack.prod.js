const createConfig = require('./webpack.config.js');

module.exports = (env, argv) => {
  return createConfig(env, { ...(argv || {}), mode: 'production' });
};

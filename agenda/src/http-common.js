import axios from "axios";

const client = axios.create({
  baseURL: '/wp-json/rsvptm/v1/',
  headers: {
    "Content-type": "application/json",
  },
  validateStatus: function (status) {
    return status < 400;
  }
});

export function setupNonceInterceptor(nonce) {
  client.interceptors.request.use((config) => {
    config.headers['X-WP-Nonce'] = nonce;
    return config;
  });
}

export default client;

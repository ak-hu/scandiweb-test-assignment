import axios from 'axios';

const API_BASE_URL = 'http://localhost:8888/scandidev/server/ApiHandler.php';

const api = axios.create({
  baseURL: API_BASE_URL,
});

const apiCall = (endpoint, method, data) => {
  const config = {
    params: method === 'GET' ? data : undefined,
  };

  return api.request({
    url: `?endpoint=${endpoint}`,
    method,
    data: method !== 'GET' ? data : undefined,
    ...config,
  })
    .then(response => response.data)
    .catch(error => {
      console.error('Axios error:', error);
      throw error; 
    });
};

export { apiCall };

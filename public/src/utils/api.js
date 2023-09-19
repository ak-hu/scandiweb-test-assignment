const API_BASE_URL = 'http://localhost:8888/scandidev/server/ApiHandler.php';

const apiCall = async (endpoint, method, data) => {
  const url = `${API_BASE_URL}?endpoint=${endpoint}`;
  const headers = {
    'Content-Type': 'application/json',
  };

  const options = {
    method,
    headers,
  };

  if (method !== 'GET' && data) {
    options.body = JSON.stringify(data);
  }

  try {
    const response = await fetch(url, options);
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return await response.json();
  } catch (error) {
    console.error('Fetch error:', error);
    throw error;
  }
};

export { apiCall };

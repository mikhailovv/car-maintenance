import store from '../store';

const api = {
  get: async (url, options = {}) => {
    const { token } = store.getState().auth;

    const headers = {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
    };

    const response = await fetch(
      `http://localhost:8000${url}`,
      { ...options, headers, credentials: 'include' },
    );

    if (!response.ok) {
      throw new Error(`API request failed: {response.statusText}`);
    }

    return response.json();
  },
  postWithoutToken: async (url, options = {}) => {
    const headers = {
      'Content-Type': 'application/json',
    };

    const response = await fetch(
      `http://localhost:8000${url}`,
      { ...options, method: 'POST', headers, credentials: 'include' },
    );

    if (!response.ok) {
      throw new Error(`API request failed: {response.statusText}`);
    }

    return response.json();
  },
  post: async (url, options = {}) => {
    const { token } = store.getState().auth;

    const headers = {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
    };

    const response = await fetch(
      `http://localhost:8000${url}`,
      { ...options, method: 'POST', headers, credentials: 'include' },
    );

    if (!response.ok) {
      throw new Error(`API request failed: {response.statusText}`);
    }

    return response.json();
  },
};

export default api;
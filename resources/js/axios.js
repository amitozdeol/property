import axios from 'axios';

// Set config defaults when creating the instance
const instance = axios.create({
    baseURL: document.head.querySelector('meta[name="api-base-url"]').content,
    headers:{
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': `Bearer ${document.head.querySelector('meta[name="api-base-token"]').content}`
    }
});

export default instance;

import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8000/', // your API base URL
  timeout: 10000,
})

export default axiosInstance

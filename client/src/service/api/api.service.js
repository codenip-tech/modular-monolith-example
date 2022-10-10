import axios from 'axios'

const API_PATH = process.env.NEXT_PUBLIC_API_PATH

export const get = async (path, config = {}) => {
  return axios.get(`${API_PATH}/${path}`, config)
}

export const post = async (path, payload) => {
  return axios.post(`${API_PATH}/${path}`, payload)
}

export const put = async (path, payload) => {
  return axios.put(`${API_PATH}/${path}`, payload)
}

export const remove = async (path) => {
  return axios.delete(`${API_PATH}/${path}`)
}

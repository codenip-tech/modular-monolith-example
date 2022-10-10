import decode from 'jwt-decode'
import { post } from '../api.service'

const routes = {
  login: 'login_check',
}

export const login = async (username, password) => {
  return await post(routes.login, {username, password})
}

export const decodeToken = (token) => {
  try {
    return decode(token)
  } catch (e) {
    console.log(e)
  }
}

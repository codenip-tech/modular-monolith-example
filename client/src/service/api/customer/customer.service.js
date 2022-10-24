import { get } from '../api.service'

const routes = {
  base: 'customers',
}

export const searchCustomers = async (filters) => {
  return await get(`${routes.base}${filters}`)
}

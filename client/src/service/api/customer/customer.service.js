import { get } from '../api.service'

const routes = {
  base: 'employees',
}

export const searchCustomers = async (id, filters) => {
  return await get(`${routes.base}/${id}/customers${filters}`)
}

import { get, post, remove } from '../api.service'

const routes = {
  base: 'employees',
}

export const searchCustomers = async (id, filters) => {
  return await get(`${routes.base}/${id}/customers${filters}`)
}

export const createCustomer = async (id, payload) => {
  return await post(`${routes.base}/${id}/customers`, payload)
}

export const deleteCustomer = async (employeeId, customerId) => {
  return await remove(`${routes.base}/${employeeId}/customers/${customerId}`)
}

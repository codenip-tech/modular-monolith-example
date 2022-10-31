import { Heading } from '@chakra-ui/react'
import SidebarWithHeader from '../../src/component/sidebar/sidebar'
import { useSelector } from 'react-redux'
import { searchCustomers } from '../../src/service/api/customer/customer.service'
import { useCallback, useEffect, useState } from 'react'
import {
  Table,
  Thead,
  Tbody,
  Tfoot,
  Tr,
  Th,
  Td,
  TableCaption,
  TableContainer,
} from '@chakra-ui/react'

export default function Customers() {
  const id = useSelector((state) => state.auth.id)
  const [customers, setCustomers] = useState([])

  const search = useCallback(async () => {
    try {
      const response = await searchCustomers(id, '?page=1&limit=10')
      setCustomers(response.data.items)
    } catch (e) {
      console.log(e)
    }
  }, [id])

  useEffect(() => {
    search()
  }, [])

  return (
    <SidebarWithHeader>
      <Heading>Customers list</Heading>
      <TableContainer>
        <Table variant="simple">
          <Thead>
            <Tr>
              <Th>ID</Th>
              <Th>Name</Th>
              <Th>Address</Th>
            </Tr>
          </Thead>
          <Tbody>
            {customers.map((customer) => (
              <Tr key={customer.id}>
                <Td>{customer.id}</Td>
                <Td>{customer.name}</Td>
                <Td>{customer.address}</Td>
              </Tr>
            ))}
          </Tbody>
        </Table>
      </TableContainer>
    </SidebarWithHeader>
  )
}

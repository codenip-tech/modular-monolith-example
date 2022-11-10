import { Heading } from '@chakra-ui/react'
import SidebarWithHeader from '../../src/component/sidebar/sidebar'
import { useSelector } from 'react-redux'
import { searchCustomers } from '../../src/service/api/customer/customer.service'
import { useCallback, useEffect, useState } from 'react'
import {
  Table,
  Thead,
  Tbody,
  Tr,
  Th,
  Td,
  TableContainer,
} from '@chakra-ui/react'
import InfiniteScroll from '../../src/component/common/infinite-scroll'

export default function Customers() {
  const id = useSelector((state) => state.auth.id)
  const [customers, setCustomers] = useState([])
  const [meta, setMeta] = useState({
    page: 1,
    limit: 30,
    hasNext: false,
    total: 0,
  })

  const search = useCallback(
    async (page = 1, limit = 30, loadMore = false) => {
      try {
        const response = await searchCustomers(id, buildFilters(page, limit))
        setCustomers(
          loadMore
            ? customers.concat(response.data.items)
            : response.data.items,
        )
        setMeta(response.data.meta)
      } catch (e) {
        console.log(e)
      }
    },
    [id, customers, buildFilters],
  )

  const buildFilters = useCallback((page, limit) => {
    return `?page=${page}&limit=${limit}`
  }, [])

  useEffect(() => {
    search()
  }, []) // eslint-disable-line

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
      <InfiniteScroll meta={meta} collection={customers} search={search} />
    </SidebarWithHeader>
  )
}

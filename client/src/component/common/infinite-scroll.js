import { Center, Text } from '@chakra-ui/react'
import LoadMore from '../table/load-more'

export default function InfiniteScroll({ meta, collection, search }) {
  return meta.hasNext ? (
    <>
      <Center mt={5}>
        <LoadMore loadMore={() => search(meta.page + 1, meta.limit, true)} />
      </Center>
      <Text mt={5} align={'center'}>
        Showing {collection.length} of {meta.total} results
      </Text>
    </>
  ) : (
    <Text mt={5} align={'center'}>
      Showing {collection.length} of {meta.total} results
    </Text>
  )
}

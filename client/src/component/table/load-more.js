import { Button } from '@chakra-ui/react'

export default function LoadMore({ loadMore }) {
  return (
    <Button variant="outline" colorScheme="teal" size="md" onClick={loadMore}>
      Show more
    </Button>
  )
}

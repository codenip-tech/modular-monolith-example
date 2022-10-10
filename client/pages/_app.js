import {ChakraProvider} from '@chakra-ui/react'
import axios from "axios";

function MyApp({Component, pageProps}) {
  axios.defaults.baseURL = process.env.NEXT_PUBLIC_API_BASE_URL

  return (
    <ChakraProvider>
      <Component {...pageProps} />
    </ChakraProvider>
  )
}

export default MyApp

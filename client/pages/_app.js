import { ChakraProvider } from '@chakra-ui/react'
import axios from 'axios'
import { combineReducers, legacy_createStore as createStore } from 'redux'
import AuthReducer, {
  fromLocalStorage,
  logout,
} from '../src/redux/reducer/auth'
import { loadState, saveState } from '../src/service/storage/storage.service'

import throttle from 'lodash/throttle'
import { createWrapper } from 'next-redux-wrapper'
import { Provider, useSelector } from 'react-redux'

const rootReducer = combineReducers({
  auth: AuthReducer,
})

const store = createStore(rootReducer)
const makeStore = () => store
const wrapper = createWrapper(makeStore)

loadState()
  .then((state) => {
    undefined !== state && store.dispatch(fromLocalStorage(state.auth))
  })
  .catch((err) => console.log(err))

store.subscribe(
  throttle(() => {
    saveState({
      auth: store.getState().auth,
    })
  }, 1000),
)

function MyApp({ Component, pageProps }) {
  const token = useSelector((state) => state.auth.token)

  axios.defaults.baseURL = process.env.NEXT_PUBLIC_API_BASE_URL
  axios.defaults.headers.Authorization = `Bearer ${token}`

  return (
    <ChakraProvider>
      <Provider store={store}>
        <Component {...pageProps} />
      </Provider>
    </ChakraProvider>
  )
}

export default wrapper.withRedux(MyApp)

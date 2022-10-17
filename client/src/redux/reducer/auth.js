const SAVE_USER = 'codenip/saveUser'
const FROM_LOCAL_STORAGE = 'codenip/fromLocalStorage'
const LOGOUT = 'codenip/logout'

const initialState = {}

const AuthReducer = (state = initialState, action) => {
  switch (action.type) {
    case SAVE_USER:
      return {
        ...state,
        id: action.payload.id,
        email: action.payload.username,
        token: action.token,
      }
    case FROM_LOCAL_STORAGE:
      return {
        ...state,
        id: action.values.id,
        email: action.values.email,
        token: action.values.token,
      }
    case LOGOUT:
      return {}
    default:
      return state
  }
}

export default AuthReducer

export const saveUser = (token, payload) => ({
  type: SAVE_USER,
  token: token,
  payload: payload,
})

export const fromLocalStorage = (values) => ({
  type: FROM_LOCAL_STORAGE,
  values: values,
})

export const logout = () => ({
  type: LOGOUT,
})

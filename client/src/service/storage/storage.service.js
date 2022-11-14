export const loadState = async () => {
  try {
    const serializedState = localStorage.getItem('state')
    if (null === serializedState) {
      return undefined
    }
    return JSON.parse(serializedState)
  } catch (e) {
    return undefined
  }
}

export const saveState = (state) => {
  try {
    const serializedState = JSON.stringify(state)
    localStorage.setItem('state', serializedState)
  } catch (e) {
    console.log(e)
  }
}

import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'
import { useForm, Controller } from 'react-hook-form'
import {
  Flex,
  Heading,
  Input,
  Button,
  InputGroup,
  Stack,
  chakra,
  Box,
  Avatar,
  FormControl,
  InputRightElement,
  Text,
} from '@chakra-ui/react'
import { useState } from 'react'
import { decodeToken, login } from '../src/service/api/auth/auth.service'
import { useRouter } from 'next/router'
import { useDispatch } from 'react-redux'
import { saveUser } from '../src/redux/reducer/auth'

export default function Home() {
  const router = useRouter()
  const dispatch = useDispatch()
  const validationSchema = yup.object().shape({
    email: yup.string().email('Invalid email').required('Email is mandatory'),
    password: yup
      .string()
      .required('Password is mandatory')
      .min(6, 'Password must be at least 6 characters'),
  })

  const {
    control,
    handleSubmit,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(validationSchema),
  })

  const [showPassword, setShowPassword] = useState(false)

  const handleShowClick = () => setShowPassword(!showPassword)

  const onSubmitForm = async (data) => {
    try {
      const response = await login(data.email.trim(), data.password.trim())
      const token = response.data.token
      const payload = decodeToken(token)

      dispatch(saveUser(token, payload))

      await router.push('/dashboard')
    } catch (e) {
      console.log(e)
    }
  }

  return (
    <Flex
      flexDirection="column"
      width="100wh"
      height="100vh"
      backgroundColor="gray.200"
      justifyContent="center"
      alignItems="center"
    >
      <Stack
        flexDir="column"
        mb="2"
        justifyContent="center"
        alignItems="center"
      >
        <Avatar bg="teal.500" />
        <Heading color="teal.400">Codenip Car Rental</Heading>
        <Box minW={{ base: '90%', md: '468px' }}>
          <form onSubmit={handleSubmit(onSubmitForm)}>
            <Stack
              spacing={4}
              p="1rem"
              backgroundColor="whiteAlpha.900"
              boxShadow="md"
            >
              <FormControl>
                <InputGroup>
                  <Controller
                    control={control}
                    name="email"
                    defaultValue=""
                    render={({ field: { onChange, value, ref } }) => (
                      <Input
                        type="email"
                        placeholder="email address"
                        onChange={onChange}
                        value={value}
                        ref={ref}
                      />
                    )}
                  />
                </InputGroup>
                <Text fontSize="sm" color="red.500">
                  {errors.email?.message}
                </Text>
              </FormControl>
              <FormControl>
                <InputGroup>
                  <Controller
                    control={control}
                    name="password"
                    defaultValue=""
                    render={({ field: { onChange, value, ref } }) => (
                      <Input
                        type={showPassword ? 'text' : 'password'}
                        placeholder="password"
                        onChange={onChange}
                        value={value}
                        ref={ref}
                      />
                    )}
                  />
                  <InputRightElement width="4.5rem">
                    <Button h="1.75rem" size="sm" onClick={handleShowClick}>
                      {showPassword ? 'Hide' : 'Show'}
                    </Button>
                  </InputRightElement>
                </InputGroup>
                <Text fontSize="sm" color="red.500">
                  {errors.password?.message}
                </Text>
              </FormControl>
              <Button
                borderRadius={0}
                type="submit"
                variant="solid"
                colorScheme="teal"
                width="full"
              >
                Login
              </Button>
            </Stack>
          </form>
        </Box>
      </Stack>
    </Flex>
  )
}

import { Box, Heading, useToast } from '@chakra-ui/react'
import { useRouter } from 'next/router'

import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'
import { useForm } from 'react-hook-form'
import { useSelector } from 'react-redux'
import SidebarWithHeader from '../../src/component/sidebar/sidebar'
import CustomerForm from '../../src/component/customer/customer-form'
import { createCustomer } from '../../src/service/api/customer/customer.service'

export default function Add() {
  const router = useRouter()
  const toast = useToast()
  const employeeId = useSelector((state) => state.auth.id)

  const validationSchema = yup.object().shape({
    name: yup
      .string()
      .required('Debes introducir el nombre del cliente para poder guardarlo'),
    email: yup.string().required('Email obligatorio').email('Email no válido'),
    age: yup
      .number()
      .typeError()
      .required('Edad obligatoria')
      .min(18, 'La edad mínima debe ser 18 años o superior')
      .max(150, 'La edad no puede ser superior a 150 años'),
    address: yup.string().required('Debes introducir una dirección'),
  })

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(validationSchema),
  })

  const onSubmitForm = async (data) => {
    try {
      await createCustomer(employeeId, {
        name: data.name,
        email: data.email,
        age: data.age,
        address: data.address,
      })
      await router.push('/customers')
    } catch (e) {
      if (409 === e.response.status) {
        toast({
          title: 'No se ha podido crear al cliente.',
          description: `Ya existe un cliente en la base de datos con email ${data.email}`,
          status: 'error',
          duration: 5000,
          isClosable: true,
        })
      }
    }
  }

  return (
    <SidebarWithHeader>
      <Heading mb="5">Nuevo cliente</Heading>
      <Box maxW="100%">
        <CustomerForm
          onSubmit={handleSubmit(onSubmitForm)}
          register={register}
          errors={errors}
          goBack={() => router.back()}
        />
      </Box>
    </SidebarWithHeader>
  )
}

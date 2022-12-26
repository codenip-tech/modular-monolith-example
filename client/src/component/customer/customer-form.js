import {
  Button,
  Flex,
  FormControl,
  Input,
  InputGroup,
  NumberDecrementStepper,
  NumberIncrementStepper,
  NumberInput,
  NumberInputField,
  NumberInputStepper,
  Stack,
  Text,
  Textarea,
} from '@chakra-ui/react'

export default function CustomerForm({ onSubmit, register, errors, goBack }) {
  return (
    <form onSubmit={onSubmit}>
      <Stack spacing={8} p="5">
        <FormControl>
          <InputGroup>
            <Input
              type="text"
              placeholder="Nombre"
              size="lg"
              {...register('name')}
            />
          </InputGroup>
          <Text fontSize="sm" color="red.500">
            {errors.name?.message}
          </Text>
        </FormControl>
        <FormControl>
          <InputGroup>
            <Input
              type="text"
              placeholder="Email"
              size="lg"
              {...register('email')}
            />
          </InputGroup>
          <Text fontSize="sm" color="red.500">
            {errors.email?.message}
          </Text>
        </FormControl>
        <FormControl>
          <InputGroup>
            <NumberInput size="lg">
              <NumberInputField {...register('age')} />
              <NumberInputStepper>
                <NumberIncrementStepper />
                <NumberDecrementStepper />
              </NumberInputStepper>
            </NumberInput>
          </InputGroup>
          <Text fontSize="sm" color="red.500">
            {errors.age?.message}
          </Text>
        </FormControl>
        <FormControl>
          <InputGroup>
            <Textarea placeholder="Dirección" {...register('address')} />
          </InputGroup>
          <Text fontSize="sm" color="red.500">
            {errors.address?.message}
          </Text>
        </FormControl>
        <Flex direction="row">
          <Button
            borderRadius={8}
            type="submit"
            variant="solid"
            colorScheme="cyan"
            width="xs"
            mr="3"
          >
            Guardar
          </Button>
          <Button
            borderRadius={8}
            variant="solid"
            colorScheme="gray"
            width="xs"
            onClick={goBack}
          >
            Volver
          </Button>
        </Flex>
      </Stack>
    </form>
  )
}

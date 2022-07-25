import { Button, Col, Container, Form, Row } from 'react-bootstrap'
import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'
import { useForm, Controller } from 'react-hook-form'

export default function Home() {
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

  const onSubmitForm = async (data) => {
    console.log(data)
    // TODO: API call to Google OAuth
  }

  return (
    <Container className={'mt-5'} fluid>
      <Row className={'justify-content-center'}>
        <Col md={4}>
          <Form onSubmit={handleSubmit(onSubmitForm)}>
            <Form.Group className="mb-3" controlId="formBasicEmail">
              <Form.Label>Email address</Form.Label>
              <Controller
                control={control}
                name="email"
                defaultValue=""
                render={({ field: { onChange, value, ref } }) => (
                  <Form.Control
                    onChange={onChange}
                    value={value}
                    ref={ref}
                    isInvalid={errors.email}
                    placeholder="Enter you email"
                  />
                )}
              />
              <Form.Text className={'text-danger'}>
                {errors.email?.message}
              </Form.Text>
            </Form.Group>

            <Form.Group className="mb-3" controlId="formBasicPassword">
              <Form.Label>Password</Form.Label>
              <Controller
                control={control}
                name="password"
                defaultValue=""
                render={({ field: { onChange, value, ref } }) => (
                  <Form.Control
                    type="password"
                    onChange={onChange}
                    value={value}
                    ref={ref}
                    isInvalid={errors.password}
                    placeholder="Enter you password"
                  />
                )}
              />
              <Form.Text className={'text-danger'}>
                {errors.password?.message}
              </Form.Text>
            </Form.Group>
            <Button variant="primary" type="submit">
              Login
            </Button>
          </Form>
        </Col>
      </Row>
    </Container>
  )
}

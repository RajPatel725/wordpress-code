import React from 'react'
import Child from './Child'
import { Col, Container, Row } from 'react-bootstrap'
// Parent
function Product() {

  const products = [
    {
      name: 'Google Home',
      description: 'Your AI assistant',
      price: 59.99,
    },
    {
      name: 'Google pixel 7A',
      description: 'My favorite phone',
      price: 60.99,
    },
    {
      name: 'Water bottle',
      description: 'Probott company',
      price: 25.95,
    }
  ]

  return (
    <>
      <Container className="mt-5">
        <Row className="justify-content-center">
          {products.map((product,index) =>{
            return(
              <Col key={index} md={3}>
                <Child name={product.name} description={product.description} price={product.price} />
              </Col>
            )
          })}
      </Row>
    </Container>
    </>
  )
}

export default Product
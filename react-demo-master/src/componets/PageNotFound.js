import React from 'react'
import { Col, Container, Row } from 'react-bootstrap';
import { Link } from 'react-router-dom';

function PageNotFound() {
  return (
    <Container>
      <Row className="text-center">
        <Col>
          <h1>Page Not Found</h1>
          <Link className="btn btn-primary" to="/">Home</Link>
        </Col>
      </Row>
    </Container>
  )
}

export default PageNotFound;
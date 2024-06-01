import React, { useState } from 'react'
import { Col, Container, Row } from 'react-bootstrap';

function StateWithObject() {
    const [data, setData] = useState({ name: 'Raj', age: 23 });
    return (
        <Container>
            <Row>
                <Col>
                    <h1>State with Object</h1>
                    <input type="text" value={data.name} onChange={(e) => setData({ ...data, name: e.target.value })} />
                    <input type="text" value={data.age} onChange={(e) => setData({ ...data, age: e.target.value })} />
                </Col>
                <Col>
                    <h1>{data.name}</h1>
                    <h1>{data.age}</h1>
                </Col>
            </Row>
        </Container>
    )
}

export default StateWithObject;
import React, { useState } from "react";
import { Col, Container, Row } from "react-bootstrap";
import PreProps from "./PreProps";

function PreState() {

    const [count, setCount] = useState(10);
    
    function updateCount() {
        let rand = Math.floor(Math.random() * 100);
        setCount(rand)
    }

    return (
        <>
            <Container>
                <Row>
                    <Col>
                        <h2>Current state value {count}</h2>
                        <button onClick={updateCount}>Click</button>
                    </Col>
                    <Col>
                        <PreProps />
                    </Col>
                </Row>
            </Container>
        </>
    )
}

export default PreState;
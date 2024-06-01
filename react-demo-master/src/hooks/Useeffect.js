import React, { useState } from 'react';
import { Button, Col, Container, Row } from 'react-bootstrap';
import UseeffectWithProps from './UseeffectWithProps';

function Useeffect() {
    const [data, setData] = useState(10);
    const [count, setCount] = useState(100);

    // useEffect(() => {
    //     console.log("useEffect count", props.count);
    // }, [count])

    return (
        <>
            <Container>
                <Row>
                    <Col>
                        {/* <h1>Data {count}</h1> */}
                        
                        <UseeffectWithProps data={data} count={count} />
                        <Button onClick={() => setData(data + 1)}>Update Data</Button>
                        <Button onClick={() => setCount(count + 1)}>Update Counter</Button>
                    </Col>
                </Row>
            </Container>
        </>
    )
}

export default Useeffect
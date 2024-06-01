import React, { useMemo, useState } from 'react';
import { Button, Col, Container, Row } from 'react-bootstrap';

function MemoH() {

    const [count, setCount] = useState(0);

    const [price, setPrice] = useState(0);

    const mainDataUpdate = useMemo(
        function updateCount() {
            console.log("updateCount");
            return count;
        }, [count]  // This is coundition for memo hooks,[count]
    )

    return (
        <>
            <Container>
                <Row>
                    <Col>
                        <h2>This is Memo counter {mainDataUpdate}</h2>
                        <h2>This is Simpl counter {price}</h2>
                    </Col>
                    <Col>
                        <Button onClick={() => setCount(count + 1)} className="d-block mb-3">Update Count</Button>
                        <Button onClick={() => setPrice(price + 1)} >Update Price</Button>
                    </Col>
                </Row>
                <Row>
                    <CapitalizedText />
                </Row>
            </Container>
        </>
    )
}

function CapitalizedText() {
    const [text, setText] = useState('');

    const handleClick = () => {
        setText(text.split(' ').map(word => {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }).join(' '));
    }
    
    return (
        <div>
            <h1>Test Convert To Capitalized</h1>
            <input type="text" value={text} onChange={(e) => setText(e.target.value)} />
            <button onClick={handleClick}>click!</button>
        </div>
    );
}

export default MemoH;
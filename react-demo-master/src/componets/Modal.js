import React, { useState } from 'react';
import { Button, Col, Container, Row } from 'react-bootstrap';

function Modal(){

    const [modal, setModal] = useState(false);
    const [toggle, setToggle] = useState(true);

    return(
        <>
        <Container className="mt-5 modal_container">
            <Row className="modal_row">
                <Col className="justify-content-center d-flex">
                    <div className={`success_modal ${modal === true ? 'show': 'hide'}`}>
                        <Container className="main_modal_container">
                            <div>This is modal</div>
                            <Button onClick={()=> setModal(false)}>Close</Button>
                        </Container>
                    </div>
                    <Button onClick={()=> setModal(true)}>Click Me!!</Button>
                </Col>
                <Col className="justify-content-center d-flex">
                    {
                        toggle?
                        <>
                            <h4>Hello Bro!!</h4>
                        </>
                        :null
                    }
                    <Button onClick={()=>setToggle(!toggle)}>Toggle</Button>
                </Col>
            </Row>
        </Container>
        </>
    )
}

export default Modal;
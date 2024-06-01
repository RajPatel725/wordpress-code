import React from 'react';
import { Button, Col, Container, Row } from 'react-bootstrap';

// Pure component if state update after that return value.

{/* class Purecomponent extends Component { */}

{/* <Button onClick={() => this.setState({ count: this.state.count })} className="btn">Upadte conunter</Button> */}
                            
class Purecomponent extends React.PureComponent {

    constructor() {
        super();
        this.state = { count: 0 }
    }

    render() {
        console.log("This is simple.");
        return (
            <>
                <Container>
                    <Row>
                        <Col md={6}>
                            <h1>Hello {this.state.count}</h1>
                            <Button onClick={() => this.setState({ count: this.state.count })} className="btn">Upadte conunter</Button>
                        </Col>
                    </Row>
                </Container>
            </>
        )
    }
}

export default Purecomponent;
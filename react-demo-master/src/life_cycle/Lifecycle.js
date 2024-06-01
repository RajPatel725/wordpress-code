import React from 'react';
import { Container, Row } from 'react-bootstrap';
import ComponentWillUnmount from './ComponentWillUnmount';

class Lifecycle extends React.Component {

    constructor() {
        super();
        console.log('This is constructor');
        this.state = {title:"This is simple life cycle",show: true}
    }
    
    render() {
        console.log('Render');
        return (
            <>
                <Container>
                    <Row>
                        <h2>{this.state.title}</h2>
                        {
                            this.state.show ? <ComponentWillUnmount /> : "component Removed"
                        }
                        <button onClick={()=> this.setState({show: !this.state.show})}>Remove Component Will Unmount</button>
                    </Row>
                </Container>
            </>
        );
    }
}

export default Lifecycle;
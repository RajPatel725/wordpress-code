import React from 'react';
import { Col, Container, Row } from 'react-bootstrap';

class Did_mount extends React.Component {
    
    componentDidMount() {
        console.log("Component did mount 3");
        // You can called API here
    }

    constructor(){
        super();
        console.log("constructor 1");
        this.state = {count: 0,name: 'Click Me'}
    }

    componentDidUpdate(preProps,preState,snapshot){
        console.log("ComponentDidUpdate Last Number",preState.count, "Updated Number",this.state.count);

        /* If you want to check state value with some one condition */

        // if(preState.count === this.state.count){
        //     alert("Counter number has been same");
        // }
    }

    shouldComponentUpdate(){
        console.log("shouldComponentUpdate",this.state.count);
        // if(this.state.count < 5){
        //     return true;
        // }
        return true;
    }

    render() {
        console.log("render 2");
        return (
            <>
                <Container>
                    <Row>
                        <Col>
                            <h2>This is Component Did mount, {this.state.count}</h2>
                            <button onClick={()=>this.setState({count: this.state.count+1, name : "Count Plus"})}>{this.state.name}</button>
                        </Col>
                    </Row>
                </Container>
            </>
        )
    }
}

export default Did_mount;
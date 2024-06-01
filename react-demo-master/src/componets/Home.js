import React from "react";
import { Col, Container, Row } from "react-bootstrap";

class Home extends React.Component {

  constructor(){
    super();
    this.state = {
      name: "Home",
      data: 0,
    }
  }

  increment(){
    this.setState({data: this.state.data + 1 });
    this.setState({name: "Welcome"});
  }

  render(){
    return (
      <>
        <Container>
          <Row>
            <Col>
              <h1>{this.state.name} {this.state.data}</h1>
              <button onClick={()=>this.increment()} className="btn btn-primary">Update Data</button>
            </Col>
          </Row>
        </Container>
      </>
    );
  }
}

export default Home;
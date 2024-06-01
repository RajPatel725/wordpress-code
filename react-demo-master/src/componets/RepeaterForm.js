import React, { useState } from "react";
import { Button, Col, Container, Row } from "react-bootstrap";

function RepeaterForm() {

  const [inputFields, setInputFields] = useState([{ firstName: "", lastName: "" }])

  const handleFormChange = (index, event) => {
    let data = [...inputFields];
    data[index][event.target.name] = event.target.value;
    setInputFields(data);
  }

  const addFields = () => {
    let newfield = { firstName: "", lastName: "" }
    setInputFields([...inputFields, newfield])
  }

  const submit = (e) => {
    e.preventDefault();
    console.log(inputFields)
    localStorage.setItem('form', JSON.stringify(inputFields));
  }

  const removeFields = (index) => {
    let data = [...inputFields];
    data.splice(index, 1)
    setInputFields(data)
    console.log(data);
  }
  
  return (
    <>
      <Container>
        <Row>
          <Col>
            <h2>Repeater From</h2>
            <form>
              {inputFields.map((input, index) => {
                return (
                  <Row key={index} style={{ 'margin': '10px 0' }}>
                    <Col>
                      <input type="text" name="firstName" value={input.firstName} onChange={event => handleFormChange(index, event)} placeholder="Enter Your First name" required />
                    </Col>
                    <Col>
                      <input type="text" name="lastName" value={input.lastName} onChange={event => handleFormChange(index, event)} placeholder="Enter Your Last name" required />
                    </Col>
                    <Col>
                      {inputFields.length === 1 ?
                        <Button onClick={() => removeFields(index)} disabled>Remove</Button>
                        :
                        <Button onClick={() => removeFields(index)}>Remove</Button>
                      }
                    </Col>
                  </Row>
                )
              })}
            </form>
            <div className="add-new-row">
              <Button onClick={addFields} >Add New Row</Button>
              <Button onClick={submit}>Submit</Button>
            </div>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default RepeaterForm;

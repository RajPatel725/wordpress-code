import axios from 'axios';
import React, { useState, useEffect } from 'react';
import { Button, Col, Container, FormSelect, Row, Table } from 'react-bootstrap';

function MainForm() {

    const getData = () => {
        axios.get(`http://localhost:3001/user`)
            .then(({ data }) => { setData(data); })
            .catch(() => { alert("Error Bro!!"); });
    };

    useEffect(() => {
        getData();
    }, []);

    const [student, setStudent] = useState({
        fname: "",
        favColor: "",
        geander: "",
        language: [],
        massage: "",
        date: "",
        state: "",
        city: "",
        country: "",
    });

    const [data, setData] = useState([]);

    const formHandel = (event) => {
        event.preventDefault();
        // It's target to input value
        // const name = event.target.name; , const value = event.target.value;
        // setStudent(values => ({...values, [name]: value}))
        // This is only single value insert method, without arrya
        // setStudent(student =>({...student, [event.target.name]:event.target.value}))
        // This is multiple value insert method (Array)
        // console.log(event.target.value);
        setStudent(student => ({ ...student, [event.target.name]: event.target.name === "language" ? [...student.language, event.target.value] : event.target.value }));
    }

    const submit = (e) => {
        e.preventDefault();
        axios.post("http://localhost:3001/user", student)
            .then((response) => {
                if (response) {
                    setStudent({ ...setStudent, fname: "", favColor: "", geander: "", language: "", massage: "", date: "", state: "", city: "", country: "", });
                    getData();
                }
                console.log(response);
            })
        // console.log(student);
        // For, Exist value reset
    }

    // const countries = [
    //     { id: 1, name: 'India' },
    //     { id: 2, name: 'US' },
    // ];

    // const states = [
    //     { id: 1, countryId: 1, name: 'Gujrat' },
    //     { id: 2, countryId: 1, name: 'Goa' },
    //     { id: 3, countryId: 2, name: 'Colorado' },
    //     { id: 4, countryId: 2, name: 'Texas' },

    // ];

    // const citys = [
    //     { id: 1, stateId: 1, name: 'Junagadh' },
    //     { id: 2, stateId: 1, name: 'Somnath' },
    //     { id: 3, stateId: 2, name: 'Saligao' },
    //     { id: 4, stateId: 2, name: 'Margoa' },
    //     { id: 5, stateId: 3, name: 'Canon City' },
    //     { id: 6, stateId: 3, name: 'Holly' },
    //     { id: 7, stateId: 4, name: 'Alvin' },
    //     { id: 8, stateId: 4, name: 'Cedar Hill' },

    // ];

    // const [country, setCountry] = useState([]);
    // const [state, setState] = useState([]);
    // const [city, setCity] = useState([]);

    // useEffect(() => {
    //     setCountry(countries);
    // }, [])

    // const handleContery = (id) => {
    //     const filterState = states.filter(s => s.countryId === id);
    //     country && setState(filterState);
    // }

    // const handleSate = (id) => {
    //     const filterCitey = citys.filter(c => c.stateId === id);
    //     country && state && setCity(filterCitey);
    // }

    const deleteUser = (id) => {
        axios.delete(`http://localhost:3001/user/${id}`)
            .then((response) => {
                getData(response.data);
            });
    };

    return (
        <Container className="mt-5">
            <Row>
                <Col md={4}>
                    <form onSubmit={submit}>
                        <input type="text" name="fname" value={student.fname} onChange={formHandel} placeholder="Enter your name" />
                        <br />
                        <FormSelect id="favColor" name="favColor" onChange={formHandel} value={student.favColor} >
                            <option defaultValue>-- Choose --</option>
                            <option value="orange">Orange</option>
                            <option value="yellow">Yellow</option>
                            <option value="green">Green</option>
                        </FormSelect>
                        <br />
                        <div>Geander:-<br />
                            Male <input type="radio" name="geander" value="male"
                                checked={student.geander === "male"}
                                onChange={formHandel} />
                            Female <input type="radio" name="geander" value="female"
                                checked={student.geander === "female"}
                                onChange={formHandel} />
                        </div>
                        <br />
                        <div>Languages:<br />
                            PHP <input type="checkbox" name="language" value="php" onChange={formHandel} />
                            JavaScript <input type="checkbox" name="language" value="js" onChange={formHandel} />
                        </div>
                        <br />
                        <div>Textarea:<br />
                            <textarea row="5" cols="30" name="massage" value={student.massage}
                                onChange={formHandel} placeholder="Please enter your message" />
                        </div>
                        <div>Date:<br />
                            <input type="date" name="date" value={student.date} onChange={formHandel} />
                        </div>
                        <br />
                        {/* <div className="country_state_city">
                            <select onChange={(e) => handleContery(e.target.value)} name="country" value={student.country}>
                                <option value="0">Section Country</option>
                                {country && country !== undefined ? country.map((ctr, index) => {
                                    return (
                                        <option key={index} value={ctr.id}>{ctr.name}</option>
                                    )
                                })
                                    :
                                    "No Countery"
                                }
                            </select>
                            <br />
                            <select onChange={(e) => handleSate(e.target.value)} name="state" value={student.state}>
                                <option value="0">Section State</option>
                                {state && state !== undefined ? state.map((sta, index) => {
                                    return (
                                        <option key={index} value={sta.id}>{sta.name}</option>
                                    )
                                })
                                    :
                                    "No State"
                                }
                            </select>
                            <br />
                            <select name="city" onChange={formHandel} value={student.city}>
                                <option value="0">Section City</option>
                                {city && city !== undefined ? city.map((cit, index) => {
                                    return (
                                        <option key={index} value={cit.id}>{cit.name}</option>
                                    )
                                })
                                    :
                                    "No City"
                                }
                            </select>
                        </div>
                        <br /> */}
                        <Button type="submit">Submit</Button>
                    </form>
                </Col>
                <Col md={6}>
                    <Table striped bordered>
                        <tbody>
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Name</b></td>
                                <td><b>Color</b></td>
                                <td><b>Geander</b></td>
                                <td><b>Languages</b></td>
                                {/* <td><b>Massage</b></td> */}
                                <td><b>Date</b></td>
                            </tr>
                            {data.map((item, i) => (
                                <tr key={i}>
                                    <td> <Button title="On click to delete this is id." id={item.id} onClick={() => deleteUser(item.id)}>
                                        {item.id}
                                    </Button></td>
                                    <td>{item.fname}</td>
                                    <td>{item.favColor}</td>
                                    <td>{item.geander}</td>
                                    <td>{item.language.toString()}</td>
                                    {/* <td>{item.massage}</td> */}
                                    <td>{item.date}</td>
                                </tr>
                            ))}

                        </tbody>
                    </Table>
                </Col>
            </Row>
        </Container>
    )
}

export default MainForm;
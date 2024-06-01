import React, { useEffect, useState } from 'react';
import { Col, Container, Row } from 'react-bootstrap';

function Countrystatecity() {

    const [country, setCountry] = useState([]);
    const [state, setState] = useState([]);
    const [city, setCity] = useState([]);

    const countries = [
        { id: 1, name: 'India' },
        { id: 2, name: 'US' }
    ];

    const states = [
        { id: 1, countryId: 1, name: 'Gujrat' },
        { id: 2, countryId: 1, name: 'Goa' },
        { id: 3, countryId: 2, name: 'Colorado' },
        { id: 4, countryId: 2, name: 'Texas' },
    ];

    const citys = [
        { id: 1, stateId: 1, name: 'Junagadh' },
        { id: 2, stateId: 1, name: 'Somnath' },
        { id: 3, stateId: 2, name: 'Saligao' },
        { id: 4, stateId: 2, name: 'Margoa' },
        { id: 5, stateId: 3, name: 'Canon City' },
        { id: 6, stateId: 3, name: 'Holly' },
        { id: 7, stateId: 4, name: 'Alvin' },
        { id: 8, stateId: 4, name: 'Cedar Hill' },
    ];

    useEffect(() => {
        setCountry(countries);
    }, []);

    const onChangeCountry = (id) => {
        const selectedCountryId = parseInt(id);
        const filterState = states.filter(sta => sta.countryId === selectedCountryId);
        setState(filterState);
        setCity([]);
    }

    const onChangeState = (id) => {
        const filterCityID = parseInt(id);
        const filterCity = citys.filter(cit => cit.stateId === filterCityID);
        setCity(filterCity);
    }

    return (
        <Container>
            <Row>
                <Col>
                    <h1>Counutry</h1>
                    <select onChange={(e) => onChangeCountry(e.target.value)}>
                        <option>Select Country</option>
                        {country.map((item) => {
                            return (
                                <option key={item.id} value={item.id}>{item.name}</option>
                            )
                        })}
                    </select>
                </Col>
                <Col>
                    <h1>State</h1>
                    <select onChange={(e) => onChangeState(e.target.value)}>
                        <option>Select State</option>
                        {state.map((stateItem) => {
                            return (
                                <option key={stateItem.id} value={stateItem.id}>{stateItem.name}</option>
                            )
                        })}
                    </select>
                </Col>
                <Col>
                    <h1>City</h1>
                    <select>
                        <option>Select City</option>
                        {city.map((cityItem) => {
                            return (
                                <option key={cityItem.id} value={cityItem.id}>{cityItem.name}</option>
                            )
                        })}
                    </select>
                </Col>
            </Row>
        </Container>
    )
}

export default Countrystatecity;
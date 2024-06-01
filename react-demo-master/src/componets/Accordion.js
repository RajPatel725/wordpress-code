import React, { useState } from 'react';
import { Col, Container, Row } from 'react-bootstrap';

function Accordion() {

    const accordionData = [
        {
            id: 1,
            title: 'Section 1',
            content: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis sapiente
          laborum cupiditate possimus labore, hic temporibus velit dicta earum
          suscipit commodi eum enim atque at? Et perspiciatis dolore iure
          voluptatem.`
        },
        {
            id: 2,
            title: 'Section 2',
            content: `Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia veniam
          reprehenderit nam assumenda voluptatem ut. Ipsum eius dicta, officiis
          quaerat iure quos dolorum accusantium ducimus in illum vero commodi
          pariatur? Impedit autem esse nostrum quasi, fugiat a aut error cumque
          quidem maiores doloremque est numquam praesentium eos voluptatem amet!
          Repudiandae, mollitia id reprehenderit a ab odit!`
        },
        {
            id: 3,
            title: 'Section 3',
            content: `Sapiente expedita hic obcaecati, laboriosam similique omnis architecto ducimus magnam accusantium corrupti
          quam sint dolore pariatur perspiciatis, necessitatibus rem vel dignissimos
          dolor ut sequi minus iste? Quas?`
        }
    ];

    return (
        <>
            <Container>
                <Row>
                    <Col>
                        <h1>Accordion</h1>
                        <div className="accordion">
                            {accordionData.map(({ id, title, content }) => (
                                <div className="accordion_item" key={id}>
                                    <AccordionItem title={title} content={content} />
                                </div>
                            ))}
                        </div>
                    </Col>
                </Row>
            </Container>
        </>
    )
}

export default Accordion;

function AccordionItem({ title, content, id }) {
    const [isActive, setIsActive] = useState(null);

    return (
        <>
            <div className="accordion_title" onClick={() => setIsActive(!isActive)}>
                <h4>{title}</h4>
                <div>{isActive ? "-" : "+"}</div>
            </div>
            {isActive && <div className="accordion_content">{content}</div>}
        </>
    )
}
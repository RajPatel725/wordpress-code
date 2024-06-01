import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { Col, Container, Row } from 'react-bootstrap';
import { Link } from 'react-router-dom';
// import Props from './Filter';

export default function Blog() {

  const [posts, setPosts] = useState([]);

  useEffect(() => {
    axios.get('https://awagindia.org/wp-json/wp/v2/posts').then((item) => {
      setPosts(item.data);
    })
  }, []);

  return (
    <>
      <Container>
        <Row>
          <Col>
            {posts && posts?.map((post, index) =>
              <div className='col-12' key={index}>
                <h1>{index} - <Link to={`single/${post.id}`}>{post.title.rendered}</Link></h1>
                {/* <div className='post-info' dangerouslySetInnerHTML={{ __html: post.content.rendered }} /> */}
              </div>
            )}
          </Col>
        </Row>
      </Container>
    </>
  )
}
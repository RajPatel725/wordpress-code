import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { Col, Container, Row } from 'react-bootstrap';
import { useParams } from 'react-router-dom';

function Single() {
  const { id } = useParams();

  const [posts, setPosts] = useState();

  useEffect(() => {
    axios.get(`https://awagindia.org/wp-json/wp/v2/posts/${id}`)
      .then((posts) => { setPosts(posts.data); })
  }, [id]);

  return (
    <Container>
      <Row>
        <Col>
          {posts &&
            <>
              <h2>{posts.title.rendered}</h2>
              <div className='post-info' dangerouslySetInnerHTML={{ __html: posts.content.rendered }} />
            </>
          }
        </Col>
      </Row>
    </Container>
  )
}

export default Single
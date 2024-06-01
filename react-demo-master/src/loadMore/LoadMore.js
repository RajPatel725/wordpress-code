import axios from 'axios';
import React, { useEffect, useState } from 'react'

function LoadMore() {

  const [items, setItems] = useState([]);
  const [visible, setVisible] = useState(3);

  useEffect(() => {
    axios.get('https://jsonplaceholder.typicode.com/posts')
      .then((item) => setItems(item.data))
  }, []);

  return (
    <div className='container'>
      <div className='row'>
        {items.slice(0, visible).map((item) => {
          return (
            <div key={item.id} className="col-md-4 card">
              <div className="card-body">
                <div className="id"><h6><b>{item.id}. {item.title}</b></h6></div>
                <p>{item.body}</p>
              </div>
            </div>
          )
        })}
      </div>
      <div className='row mt-5'>
        <div className="text-center">
          <button className="btn btn-primary" onClick={() => setVisible(visible + 3)}>Load More</button>
        </div>
      </div>
    </div>
  )
}

export default LoadMore

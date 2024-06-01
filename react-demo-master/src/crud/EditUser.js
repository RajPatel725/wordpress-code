import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { Button } from 'react-bootstrap';
import { useNavigate, useParams } from 'react-router-dom'

function EditUser() {

  const { id } = useParams();

  const [user, setUser] = useState({
    id: "",
    name: "",
  });

  const onInputChange = (e) => {
    const { name, value } = e.target;
    setUser({ ...user, [name]: value });
  };

  useEffect(()=> {
    axios.get(`http://localhost:3001/data/${id}`).then((item) => {
      setUser(item.data);
    })
  }, [id]);

  const navigate = useNavigate();

  const onSubmit = (e) => {
    e.preventDefault();
    axios.put(`http://localhost:3001/data/${id}`,user)
    .then(response => {
      console.log(response);
    })
    navigate('/user');
    setUser();
  };

  return (
    <>
       <div className="container">
        <div className="row">
          <form onSubmit={e=>onSubmit(e)}>
            <div className="col-12">
              <label htmlFor="id">ID</label>
              <input
              type="number"
                name="id"
                autoComplete="off"
                onChange={(e) => onInputChange(e)}
                value={user.id}
              required />
            </div>

            <div className="col-12">
              <label htmlFor="name">First Name</label>
              <input
                name="name"
                autoComplete="off"
                onChange={(e) => onInputChange(e)}
                value={user.name}
                required
              />
            </div>
              <Button type="submit">
                  Update
              </Button>      
          </form>
        </div>
      </div>
    </>
  )
}

export default EditUser
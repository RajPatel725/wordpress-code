import axios from "axios";
import React, { useState } from "react";
import { Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";

function AddUser() {
  const [user, setUser] = useState({id: "",name: ""});

  //  Form Handl
  const handleInput = (e) => {
    const { name, value } = e.target;
    setUser({ ...user, [name]: value });
  };

  const navigate = useNavigate();

  // Post User Data
  const handleSubmit = (e) => {
    axios.post("http://localhost:3001/data", user);
    e.preventDefault();
    setUser({ ...user, id: "", name: "" });
    navigate("/user");
  };

  return (
    <>
      <div className="container">
        <div className="row">
          <form action="" onSubmit={handleSubmit}>
            <div className="col-12">
              <label htmlFor="id">ID</label>
              <input
                name="id" 
                autoComplete="off"
                onChange={handleInput}
                value={user.id}
                required={true}
              />
            </div>

            <div className="col-12">
              <label htmlFor="name">First Name</label>
              <input
                name="name"
                autoComplete="off"
                onChange={handleInput}
                value={user.name}
                required={true}
              />
            </div>
            <Button type="submit">
              Submit
            </Button>
          </form>
        </div>
      </div>
    </>
  );
}

export default AddUser;

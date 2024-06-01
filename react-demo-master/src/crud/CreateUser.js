import axios from "axios";
import React, { useEffect, useState } from "react";
import { Button, Table } from "react-bootstrap";
import { Link } from "react-router-dom";

function CreateUser() {
  // const [isError, setIsError] = useState("");
  // const [user, setUser] = useState({
  //   id: "",
  //   name: "",
  // });

  // Get User Data
  const [data, setData] = useState([]);
  const getData = () => {
    axios
      .get(`http://localhost:3001/data`)
      .then(({ data }) => {
        setData(data);
      })
      .catch(() => {
        alert("Dofa error che.");
      });
  };

  useEffect(() => {
    getData();
  }, []);

  //  Form Handl
  // const handleInput = (e) => {
  //   const { name, value } = e.target;
  //   setUser({ ...user, [name]: value });
  //   getData()
  // };

  // // Post User Data
  // const handleSubmit = (e) => {
  //     axios
  //     .post("http://localhost:3001/data", user).then(response => {
  //       getData(response.data);
  //     })
  //     .catch((error) => setIsError(error.massage));

  //   e.preventDefault();
  //   setUser({ ...user, id:"",name:"", }); // Empty Data Before Submit
  // };

  const deleteUser = (id) => {
    // fetch(`http://localhost:3000/data/${id}` it's also work in fetch method
    axios.delete(`http://localhost:3001/data/${id}`)
      .then((response) => {
        getData(response.data);
      });
  };

  return (
    <>
      <div className="container">
        {/* <div className="row">
          <form action="" onSubmit={handleSubmit}>
            <div className="col-12">
              <label htmlFor="id">ID</label>
              <input
                name="id"
                autoComplete="off"
                onChange={handleInput}
                value={user.id}
              required />
            </div>

            <div className="col-12">
              <label htmlFor="name">First Name</label>
              <input
                name="name"
                autoComplete="off"
                onChange={handleInput}
                value={user.name}
                required
              />
            </div>
            <Button color="primary" variant="outlined" type="submit">
              Submit
            </Button>
          </form>
        </div> */}
        <div className="row">
          <div className="col-12">
            <h2>Local of JSON data</h2>
            <Table striped bordered>
              <tbody>
                <tr>
                  <td>ID</td>
                  <td>Name</td>
                  <td>
                    <Link bg="success" to="/user/add">
                      Add new user
                    </Link>
                  </td>
                  <td>
                    <Link bg="success" to="/user/filter">
                      User Filter
                    </Link>
                  </td>
                </tr>

                {data.map((item, i) => (
                  <tr key={i}>
                    <td>{item.id}</td>
                    <td>{item.name}</td>
                    <td>
                      <Link to={`/user/edit/${item.id}`}>
                        Edit
                      </Link>
                    </td>
                    <td>
                      <Button id={item.id} onClick={() => deleteUser(item.id)}>
                        Delete
                      </Button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </Table>
          </div>
        </div>
      </div>
    </>
  );
}

export default CreateUser;

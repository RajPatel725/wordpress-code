import axios from "axios";
import { useState } from "react";
import { Button } from "react-bootstrap";

function Filter() {
    const [id, setID] = useState("");
    const [user, setUser] = useState("");

    function searchUser() {
        if (id === "") {
            return;
        }

        axios
            .get(`http://localhost:3001/data/${id}`)
            .then((res) => {
                console.log(res);
                setUser(res.data);
            })
            .catch((err) => {
                alert("Dofa user id nthi");
            });
    }

    return (
        <div className="container">
            <div className="row">
                <div className="col-12">
                    <h1>User Finder</h1>
                    <div className="row">
                        <div className="col-6">
                            <input
                                type="number"
                                placeholder="User Id"
                                onChange={(e) => {
                                    setID(e.target.value);
                                }}
                            />
                        </div>
                        <div className="col-6">
                            <Button className="btn" onClick={() => searchUser()}>
                                Search
                            </Button>
                        </div>
                    </div>
                    <div className="row">
                        <div>{user.id}</div>
                        <div>{user.name}</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Filter;

import React, { useEffect, useState } from 'react'

function PromiseCompo() {

    const [data, setData] = useState(null);

    useEffect(() => {
        getData()
            .then(data => setData(data))
            .catch(error => console.error(error));
    }, []);

    const getData = () => {
        return new Promise((resolve, reject) => {
            fetch(`http://localhost:3001/user`)
                .then(response => response.json())
                .then(data => resolve(data))
                .catch(error => reject(error));
        });
    };

    return (
        <>
            <h1>Promise</h1>
            <div className="promise_names">
                {data ? (
                    <div>
                        {data.map((item, index) => (
                            <h2 key={index}>{item.fname}</h2>
                        ))}
                    </div>
                ) : (
                    <p>Loading...</p>
                )}
            </div>
        </>
    )
}

export default PromiseCompo
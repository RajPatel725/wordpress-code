import React, { useEffect } from 'react';

function UseeffectWithProps(props) {

    useEffect(() => {
        console.log("useEffect count", props.count);
    }, [props.count])

    return (
        <>
            <h1>Data {props.data}</h1>
            <h1>Count {props.count}</h1>
        </>
    )
}

export default UseeffectWithProps;
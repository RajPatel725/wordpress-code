import React, { useEffect, useRef } from 'react'

function PorpsVal(props) {

    const lastvalue = useRef(props.count);

    useEffect(() => {
        lastvalue.current = props.count;
    },[props.count]);

    var previousValue = lastvalue.current;
    return (
        <>
            <h2>Current Props value {props.count}</h2>
            <h2>Previous Props value {previousValue}</h2>
        </>
    )
}

export default PorpsVal
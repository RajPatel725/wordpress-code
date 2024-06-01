import React, { useState } from 'react';

function Hoc() {
    return (
        <>
            <h2>Higher Order Component</h2>
            <HocRed cmp={Conunter} />
            <HocWhite cmp={Conunter} />
            <HocGreen cmp={Conunter} />
        </>
    )
}

function HocRed(props) {
    return (
        <div style={{ backgroundColor: "orange", width: 150 }}>
            <props.cmp />
        </div>
    )
}

function HocWhite(props) {
    return (
        <div style={{ backgroundColor: "white", width: 350 }}>
            <p>Jay Hind</p>
            <props.cmp />
        </div>
    )
}

function HocGreen(props) {
    return (
        <div style={{ backgroundColor: "green", width: 550 }}>
            <p>This is second component same as Red component.</p>
            <props.cmp />
        </div>
    )
}

function Conunter() {
    const [count, setCount] = useState(0);
    return (
        <>
            <h3>{count}</h3>
            <button onClick={() => setCount(count + 1)}>update</button>
        </>
    )
}

export default Hoc;
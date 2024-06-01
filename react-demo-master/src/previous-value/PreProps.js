import React, { useState } from 'react'
import PorpsVal from './PorpsVal';

function PreProps() {
    const [count, setCount] = useState(1);
    return (
        <>
            <PorpsVal count={count} />
            <button onClick={() => setCount(count + 3)}>Update Count</button>
        </>
    )
}

export default PreProps
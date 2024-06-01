import React, { useState, useCallback } from 'react';

function UseCallBack() {
    const [count, setCount] = useState(0);

    const handleClick = useCallback(() => {
        setCount(count + 1);
        console.log(count);
    }, [count]);

    return (
        <div>
            <p>You clicked {count} times</p>
            <button onClick={handleClick}>Update count</button>
        </div>
    );
}

export default UseCallBack;

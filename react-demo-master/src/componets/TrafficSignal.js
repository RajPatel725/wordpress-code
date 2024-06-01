import React, { useState, useEffect } from 'react';

const TrafficSignal = () => {
    const [color, setColor] = useState('yellow');
    const [counter, setCounter] = useState(0);

    useEffect(() => {
        let interval;

        if (color === 'yellow') {
            interval = setTimeout(() => {
                setColor('green');
                setCounter(0);
            }, 3000);
        } else if (color === 'green') {
            interval = setTimeout(() => {
                setColor('red');
                setCounter(0);
            }, 30000);
        } else {
            interval = setTimeout(() => {
                setColor('yellow');
                setCounter(0);
            }, 30000);
        }

        return () => clearTimeout(interval);
    }, [color]);

    useEffect(() => {
        const interval = setInterval(() => setCounter((prevCounter) => prevCounter + 1), 1000);

        return () => clearInterval(interval);
    }, []);

    return (
        <div className={`traffic-signal ${color}`}>
            <div className="circle"></div>
            <div className="circle"></div>
            <div className="circle"></div>
            <div className="counter">{counter}</div>
        </div>  
    );
};

export default TrafficSignal;
